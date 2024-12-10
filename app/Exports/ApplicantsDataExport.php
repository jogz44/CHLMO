<?php

namespace App\Exports;

use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\Purok;
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
    private $filters;
    public function __construct($filters = null)
    {
        $this->filters = $filters;
    }

    private function getTitle(): string
    {
        return 'WALK-IN APPLICANTS';
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

        // Add Tagging Status
        if (!empty($this->filters['tagging_status'])) {
            $subtitle[] = "Status: {$this->filters['tagging_status']}";
        }

        return $subtitle;
    }

    public function view(): View
    {
        $query = Applicant::with([
            'person',
            'address.barangay',
            'address.purok',
        ])->where('transaction_type', 'Walk-in');

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

        // Modified tagging status filter
        if (!empty($this->filters['tagging_status'])) {
            $isTagged = $this->filters['tagging_status'] === 'Tagged';
            $query->where('is_tagged', $isTagged);
        }

        $applicants = $query->get();

        // Calculate totals
        $totals = [
            'total' => $applicants->count(),
            'tagged' => $applicants->where('is_tagged', true)->count(),
            'untagged' => $applicants->where('is_tagged', false)->count()
        ];

        // Get the dynamic title and subtitle
        $title = $this->getTitle();
        $subtitle = $this->getSubtitle();

        // Make sure you have a corresponding export view
        return view('exports.applicants', [
            'applicants' => $applicants,
            'title' => $title,
            'subtitle' => $subtitle,
            'totals' => $totals
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function styles(Worksheet $sheet): array
    {
        $lastRow = $sheet->getHighestRow();

        $dataStartRow = 11; // Adjust based on your header rows
        $dataEndRow = $lastRow - 8; // Adjust based on your footer rows

        // Default styles
        $styles = [
            // Style for the title and header sections
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['bold' => true, 'size' => 16]],
            3 => ['font' => ['bold' => true, 'size' => 16]],
            4 => ['font' => ['bold' => true, 'size' => 20]],

            // Table header style
            11 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F3F4F6']
                ]
            ]
        ];

        // Apply color coding to data rows
        foreach($this->view()->getData()['applicants'] as $index => $applicant) {
            $rowIndex = $dataStartRow + $index;
            $styles[$rowIndex] = [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'rgb' => $applicant->is_tagged ? 'E8F5E9' : 'FFEBEE'
                    ]
                ]
            ];
        }

        // Add legend at the bottom
        $legendRow = $lastRow + 2;
        $sheet->setCellValue("A{$legendRow}", "Color Legend:");
        $sheet->setCellValue("A" . ($legendRow + 1), "Tagged Applicants");
        $sheet->setCellValue("A" . ($legendRow + 2), "Untagged Applicants");

        // Style the legend
        $styles[$legendRow] = ['font' => ['bold' => true]];
        $styles[$legendRow + 1] = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E8F5E9']
            ]
        ];
        $styles[$legendRow + 2] = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'FFEBEE']
            ]
        ];

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

        // Set page setup
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
        $sheet->getPageSetup()->setFitToPage(true);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageSetup()->setFitToHeight(0);

        return $styles;
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
