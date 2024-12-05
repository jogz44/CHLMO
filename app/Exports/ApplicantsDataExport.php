<?php

namespace App\Exports;

use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\TransactionType;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
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

class ApplicantsDataExport implements FromView, ShouldAutoSize, WithChunkReading, WithStyles, WithDrawings, WithEvents
{
    use Exportable;
    protected $transactionType;
    private $filters;
    public function __construct($filters = null)
    {
        $this->filters = $filters;
    }

    private function getTitle(): string
    {
        return 'SUMMARY OF IDENTIFIED INFORMAL SETTLERS - APPLICANTS VIA WALK-IN HOUSING APPLICANTS';
    }

    private function getSubtitle(): array
    {
        $subtitle = [];

        // Add Barangay info
        if (!empty($this->filters['barangay_id'])) {
            $barangay = Barangay::find($this->filters['barangay_id']);
            $subtitle[] = "BARANGAY: {$barangay->name}";
        }

        // Add Purok info
        if (!empty($this->filters['purok_id'])) {
            $purok = Purok::find($this->filters['purok_id']);
            $subtitle[] = "PUROK: All Purok";
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
        $query = Applicant::with([
            'person',
            'address.barangay',
            'address.purok',
        ]);

        // Apply filters
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('date_applied', [
                $this->filters['start_date'],
                $this->filters['end_date']
            ]);
        }

        if (!empty($this->filters['barangay_id'])) {
            $query->whereHas('address', function($q) {
                $q->where('barangay_id', $this->filters['barangay_id']);
            });
        }

        if (!empty($this->filters['purok_id'])) {
            $query->whereHas('address', function($q) {
                $q->where('purok_id', $this->filters['purok_id']);
            });
        }

        if (isset($this->filters['tagging_status'])) {
            $query->where('is_tagged', $this->filters['tagging_status'] === 'Tagged');
        }

        $applicants = $query->get();

        // Get the dynamic title and subtitle
        $title = $this->getTitle();
        $subtitle = $this->getSubtitle();

        // Make sure you have a corresponding export view
        return view('exports.applicants', [
            'applicants' => $applicants,
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
        $sheet->getColumnDimension('C')->setWidth(10); // Suffix
        $sheet->getColumnDimension('D')->setWidth(15); // Contact
        $sheet->getColumnDimension('E')->setWidth(15); // Purok
        $sheet->getColumnDimension('F')->setWidth(15); // Barangay
        $sheet->getColumnDimension('G')->setWidth(20); // Transaction Type
        $sheet->getColumnDimension('H')->setWidth(15); // Date

        // Set print area
        $sheet->getPageSetup()->setPrintArea('A1:H' . ($sheet->getHighestRow()));

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
        $drawing->setPath(public_path('storage/images/housing_logo.png'));
        $drawing->setHeight(100);
        $drawing->setCoordinates('D1'); // Using column D for center alignment
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
            AfterSheet::class => function(AfterSheet $event) {
                $worksheet = $event->sheet->getDelegate();

                // Set to Legal paper size (8.5" x 14")
                $worksheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_LEGAL);

                // Set to Landscape orientation
                $worksheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                // Fit to 1 page wide by 1 page tall
                $worksheet->getPageSetup()->setFitToWidth(1);
                $worksheet->getPageSetup()->setFitToHeight(1);

                // Optional: Set margins (in inches)
                $worksheet->getPageMargins()
                    ->setTop(0.5)
                    ->setRight(0.5)
                    ->setBottom(0.5)
                    ->setLeft(0.5);

                // Optional: Adjust column widths to fit content
                $worksheet->getColumnDimension('A')->setWidth(13.33);
                $worksheet->getColumnDimension('B')->setWidth(43.89);
                $worksheet->getColumnDimension('C')->setWidth(6.89);
                $worksheet->getColumnDimension('D')->setWidth(15.11);
                $worksheet->getColumnDimension('E')->setWidth(19.56);
                $worksheet->getColumnDimension('F')->setWidth(24);
                $worksheet->getColumnDimension('G')->setWidth(15.11);
                $worksheet->getColumnDimension('H')->setWidth(15);
            }
        ];
    }
}
