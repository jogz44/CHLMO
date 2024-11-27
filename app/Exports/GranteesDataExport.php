<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Shelter\OriginOfRequest;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\ProfiledTaggedApplicant;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GranteesDataExport implements FromView, ShouldAutoSize, WithStyles, WithDrawings
{
    use Exportable;
    private $filters;
    public function __construct($filters = null)
    {
        $this->filters = $filters;
    }
    private function getTitle(): string
    {
        $title = 'LIST OF SHELTER ASSISTANCE PROGRAM GRANTEES';

        return $title;
    }

    private function getSubtitle(): array
    {
        $subtitle = [];

        // Add Barangay info
        if (!empty($this->filters['origin_of_request_id'])) {
            $originOfRequest = OriginOfRequest::find($this->filters['origin_of_request_id']);
            $subtitle[] = "ORIGIN OF REQUEST: {$originOfRequest->name}";
        }

        // Add Date Range
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $startGrantingDate = Carbon::parse($this->filters['start_date'])->format('m/d/Y');
            $endGrantingDate = Carbon::parse($this->filters['end_date'])->format('m/d/Y');
            $subtitle[] = "Date From: {$startGrantingDate} To: {$endGrantingDate}";
        }
        return $subtitle;
    }


    public function view(): View
    {
        $query = Grantee::with([
            'profiledTaggedApplicant.shelterApplicant.person',
            'profiledTaggedApplicant.shelterApplicant.address.purok',
            'profiledTaggedApplicant.shelterApplicant.address.barangay',
            'profiledTaggedApplicant.shelterApplicant.originOfRequest',
            'profiledTaggedApplicant.governmentProgram',
            'profiledTaggedApplicant.shelterSpouse',
        ]);

        // Apply filters
        if (!empty($this->filters['request_origin_id'])) {
            $query->whereHas('profiledTaggedApplicant.shelterApplicant', function($q) {
                $q->where('request_origin_id', $this->filters['request_origin_id']);
            });
        }

        $grantees = $query->get();

        return view('exports.grantees', [
            'grantees' => $grantees,
            'title' => $this->getTitle(),
            'subtitle' => $this->getSubtitle()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
        
        return [
            1 => ['font' => ['bold' => true]],
            'A1:M1' => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('storage/images/logo.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('A1');
        
        return $drawing;
    }

    public function startCell(): string
    {
        return 'A2'; // Start the text content from row 2
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $worksheet = $event->sheet->getDelegate();

                // Fit content to one page wide by height dynamically
                $worksheet->getPageSetup()->setFitToWidth(1);
                $worksheet->getPageSetup()->setFitToHeight(0);

                // Dynamically set print area to avoid extra columns or blank rows
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                $worksheet->getPageSetup()->setPrintArea("A1:{$highestColumn}{$highestRow}");

                // Optional: Set margins for compact view
                $worksheet->getPageMargins()
                    ->setTop(0.5)
                    ->setRight(0.5)
                    ->setBottom(0.5)
                    ->setLeft(0.5);

                // Optional: Adjust column widths to fit content
                $worksheet->getColumnDimension('A')->setWidth(15); // ID
                $worksheet->getColumnDimension('B')->setWidth(30); // Name
                $worksheet->getColumnDimension('C')->setWidth(10); // Purok
                $worksheet->getColumnDimension('D')->setWidth(15); // Barangay
                $worksheet->getColumnDimension('E')->setWidth(15); // House No.
                $worksheet->getColumnDimension('F')->setWidth(15); // Contact No.
                $worksheet->getColumnDimension('G')->setWidth(15); // Spouse Name
                $worksheet->getColumnDimension('H')->setWidth(15); // Origin of Request
                $worksheet->getColumnDimension('I')->setWidth(15); // Government Program
                $worksheet->getColumnDimension('J')->setWidth(15); // date request
                $worksheet->getColumnDimension('K')->setWidth(15); // date profiled tagged
                $worksheet->getColumnDimension('L')->setWidth(15); // Date of Delivery
                $worksheet->getColumnDimension('M')->setWidth(15); // Remarks
            },
        ];
    }
}
