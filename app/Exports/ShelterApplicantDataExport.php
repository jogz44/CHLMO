<?php

namespace App\Exports;

use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\OriginOfRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
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

class ShelterApplicantDataExport implements FromView, ShouldAutoSize, WithChunkReading, WithStyles, WithDrawings, WithEvents
{
    use Exportable;
    private $filters;
    public function __construct($filters = null)
    {
        $this->filters = $filters;
    }
    private function getTitle(): string
    {
        $title = 'LIST OF SHELTER ASSISTANCE PROGRAM APPLICANTS';

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
            $startDate = Carbon::parse($this->filters['start_date'])->format('m/d/Y');
            $endDate = Carbon::parse($this->filters['end_date'])->format('m/d/Y');
            $subtitle[] = "Date From: {$startDate} To: {$endDate}";
        }
        return $subtitle;
    }


    public function view(): View
    {
        $query = ShelterApplicant::with([
            'person',
            'originOfRequest',
        ]);
    
        // Apply filters
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('date_request', [
                $this->filters['start_date'],
                $this->filters['end_date']
            ]);
        }
    
        if (!empty($this->filters['request_origin_id'])) {
            $query->where('request_origin_id', $this->filters['request_origin_id']);
        }
    
        if (isset($this->filters['tagging_status'])) {
            $query->where('is_tagged', $this->filters['tagging_status'] === 'Tagged');
        }
    
        $shelterApplicants = $query->get();
    
        // Get the dynamic title and subtitle
        $title = $this->getTitle();
        $subtitle = $this->getSubtitle();
    
        // Make sure you have a corresponding export view
        return view('exports.shelter-applicants', [
            'shelterApplicants' => $shelterApplicants,
            'title' => $title,
            'subtitle' => $subtitle
        ]);
    }
    

    public function chunkSize(): int
    {
        return 500;
    }

    public function styles(Worksheet $sheet): array
    {
        // Set paper orientation to landscape
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Adjust column widths
        $sheet->getColumnDimension('A')->setWidth(15); // ID
        $sheet->getColumnDimension('B')->setWidth(30); // Name
        $sheet->getColumnDimension('C')->setWidth(10); // originOfRequest
        $sheet->getColumnDimension('D')->setWidth(15); // DATE REQUEST
    

        // Set print area
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $sheet->getPageSetup()->setPrintArea("A1:{$lastColumn}{$lastRow}");

        return [
            1 => ['font' => ['bold' => true, 'size' => 16]], // Header row
        ];
    }

    /**
     * @throws Exception
     */
    public function drawings(): Drawing
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('storage/images/logo.png'));
        $drawing->setHeight(100); // Adjust height as needed
        $drawing->setCoordinates('B1'); // Stay in column B
        $drawing->setOffsetX(100); // Adjust this value to push it toward the end of column B
        $drawing->setOffsetY(2);
    
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
        },
    ];
}

}
