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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class GranteesDataExport implements FromView, ShouldAutoSize, WithStyles, WithDrawings
{
    use Exportable;
    private $filters;
    private $selectedPurok_id;
    private $selectedBarangay_id;
    private $puroksFilter;
    private $puroks;
    private $purok_id;
    private $barangay_id;

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

        // Apply date range filter
        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('date_of_delivery', [
                $this->filters['start_date'],
                $this->filters['end_date']
            ]);
        }

        // Apply filters
        if (!empty($this->filters['request_origin_id'])) {
            $query->whereHas('profiledTaggedApplicant.shelterApplicant', function ($q) {
                $q->where('request_origin_id', $this->filters['request_origin_id']);
            });
        }

        // Apply Barangay filter
        if (!empty($this->filters['barangay_id'])) {
            $query->whereHas('profiledTaggedApplicant.shelterApplicant.address.barangay', function ($q) {
                $q->where('id', $this->filters['barangay_id']);
            });
        }

        // Apply Purok filter
        if (!empty($this->filters['purok_id'])) {
            $query->whereHas('profiledTaggedApplicant.shelterApplicant.address.purok', function ($q) {
                $q->where('id', $this->filters['purok_id']);
            });
        }

        $grantees = $query->get();

        return view('exports.grantees', [
            'grantees' => $grantees,
            'title' => $this->getTitle(),
            'subtitle' => $this->getSubtitle()
        ]);
    }

    public function updatedBarangayId($barangayId): void
    {
        // Fetch the puroks based on the selected barangay
        $this->puroks = Purok::where('barangay_id', $barangayId)->get();
        $this->purok_id = null; // Reset selected purok when barangay changes
        logger()->info('Retrieved Puroks', [
            'barangay_id' => $barangayId,
            'puroks' => $this->puroks
        ]);
    }
    public function updatedSelectedBarangayId($barangayId)
    {
        // Fetch the puroks based on the selected barangay
        $this->puroksFilter = Purok::where('barangay_id', $barangayId)->get();
        $this->selectedPurok_id = null; // Reset selected purok when barangay changes
        logger()->info('Retrieved Puroks', [
            'selectedBarangay_id' => $barangayId,
            'puroksFilter' => $this->puroksFilter
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_LEGAL);

        return [
            1 => ['font' => ['bold' => true]],
            'A1:M1' => ['alignment' => ['horizontal' => 'center']],
        ];
    }

    public function drawings(): array
    {
        $drawings = [];

        // Left Logo
        $leftDrawing = new Drawing();
        $leftDrawing->setName('Left Logo');
        $leftDrawing->setDescription('Left Logo');
        $leftDrawing->setPath(public_path('storage/images/logo-left.png')); // Update path if necessary
        $leftDrawing->setHeight(100); // Adjust height as needed
        $leftDrawing->setCoordinates('C2'); // Starting cell
        $leftDrawing->setOffsetX(5); // Fine-tune horizontal positioning
        $leftDrawing->setOffsetY(5); // Fine-tune vertical positioning

        // Right Logo
        $rightDrawing = new Drawing();
        $rightDrawing->setName('Right Logo');
        $rightDrawing->setDescription('Right Logo');
        $rightDrawing->setPath(public_path('storage/images/logo-right.png')); // Update path if necessary
        $rightDrawing->setHeight(100); // Adjust height as needed
        $rightDrawing->setCoordinates('K2'); // Starting cell for the right logo
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

                $styleBottomMedium = [
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '000000'], // Black color
                        ],
                    ],
                ];
                // Apply different border styles
                $event->sheet->getStyle('A9:M9')->applyFromArray($styleBottomMedium); // Thick border
            },
        ];
    }
    public function exportGranteesPdf(Request $request)
    {
        $orientation = $request->input('orientation', 'portrait'); // Default to portrait if not provided

        $grantees = Grantee::all(); // Adjust query as needed for your data

        $pdf = Pdf::loadView('exports.grantees', [
            'grantees' => $grantees,
        ])->setPaper('legal', $orientation); // Dynamically set orientation

        return $pdf->download('grantees.pdf');
    }
}
