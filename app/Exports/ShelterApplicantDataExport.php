<?php

namespace App\Exports;

use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\OriginOfRequest;
use App\Models\Barangay;
use App\Models\Purok;
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
        $query = ShelterApplicant::with([
            'person',
            'address.barangay',
            'address.purok',
            'originOfRequest',
        ]);

        // Apply filters
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('date_request', [
                $this->filters['start_date'],
                $this->filters['end_date']
            ]);
        }

        if (!empty($this->filters['barangay_id'])) {
            $query->whereHas('address', function ($q) {
                $q->where('barangay_id', $this->filters['barangay_id']);
            });
        }

        if (!empty($this->filters['purok_id'])) {
            $query->whereHas('address', function ($q) {
                $q->where('purok_id', $this->filters['purok_id']);
            });
        }


        if (!empty($this->filters['request_origin_id'])) {
            $query->where('request_origin_id', $this->filters['request_origin_id']);
        }

        if (isset($this->filters['is_tagged'])) {
            $query->where('is_tagged', $this->filters['is_tagged'] === 'Tagged');
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
        $sheet->getColumnDimension('E')->setWidth(15); // Purok
        $sheet->getColumnDimension('F')->setWidth(15); // Barangay


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
    public function drawings(): array
    {
        $drawings = [];

        // Left Logo
        $leftDrawing = new Drawing();
        $leftDrawing->setName('Left Logo');
        $leftDrawing->setDescription('Left Logo');
        $leftDrawing->setPath(public_path('storage/images/logo-left.png')); // Update path if necessary
        $leftDrawing->setHeight(100); // Adjust height as needed
        $leftDrawing->setCoordinates('B2'); // Starting cell
        $leftDrawing->setOffsetX(5); // Fine-tune horizontal positioning
        $leftDrawing->setOffsetY(5); // Fine-tune vertical positioning

        // Right Logo
        $rightDrawing = new Drawing();
        $rightDrawing->setName('Right Logo');
        $rightDrawing->setDescription('Right Logo');
        $rightDrawing->setPath(public_path('storage/images/logo-right.png')); // Update path if necessary
        $rightDrawing->setHeight(100); // Adjust height as needed
        $rightDrawing->setCoordinates('F2'); // Starting cell for the right logo
        $rightDrawing->setOffsetX(5); // Fine-tune horizontal positioning
        $rightDrawing->setOffsetY(5); // Fine-tune vertical positioning

        $drawings[] = $leftDrawing;
        $drawings[] = $rightDrawing;

        return $drawings;
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
                $worksheet->getColumnDimension('A')->setWidth(13.33);
                $worksheet->getColumnDimension('B')->setWidth(43.89);
                $worksheet->getColumnDimension('C')->setWidth(6.89);
                $worksheet->getColumnDimension('D')->setWidth(15.11);
                $worksheet->getColumnDimension('E')->setWidth(19.56);
                $worksheet->getColumnDimension('F')->setWidth(24);

                $highestRow = $event->sheet->getDelegate()->getHighestRow(); // Last data row
                $highestColumn = $event->sheet->getDelegate()->getHighestColumn(); // Last column

                $styleBottomThick = [
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'], // Black color
                        ],
                    ],
                ];

                $styleBottomMedium = [
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '000000'], // Black color
                        ],
                    ],
                ];

                $styleBottomThin = [
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'], // Black color
                        ],
                    ],
                ];

                // Apply different border styles
                $event->sheet->getStyle('A9:F9')->applyFromArray($styleBottomMedium); // Thick border
            },
        ];
    }
}
