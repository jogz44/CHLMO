<?php

namespace App\Exports;

use App\Models\Barangay;
use App\Models\Shelter\ProfiledTaggedApplicant;
use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\Grantee;
use App\Models\GovernmentProgram;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ShelterRequestDeliveredMaterialsDataExport implements FromView, ShouldAutoSize, WithChunkReading, WithStyles, WithDrawings, WithEvents
{
    use Exportable;
    private $filters;
    private $governmentProgram;
    private $barangay_id;
    const DANGER_ZONE_ID = 8;
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    private function getTitle(): string
    {
        return 'REPORT ON REQUESTED AND DELIVERED MATERIALS UNDER THE SHELTER ASSISTANCE PROGRAM';
    }

    private function getSubtitle(): array
    {
        $subtitle = [];

        // Add Date Range
        if (!empty($this->filters['startDate']) && !empty($this->filters['endDate'])) {
            $startDate = Carbon::parse($this->filters['startDate'])->format('m/d/Y');
            $endDate = Carbon::parse($this->filters['endDate'])->format('m/d/Y');
            $subtitle[] = "FOR THE PERIOD OF: {$startDate} TO: {$endDate}";
        }

        return $subtitle;
    }

    public function view(): View
    {
        $statistics = $this->getStatistics(); // Fetch statistics data
        $totals = $this->getTotals($statistics); // Calculate totals


        $data = [
            'title' => $this->getTitle(),
            'subtitle' => $this->getSubtitle(),
            'barangays' => Barangay::select('id', 'name')->orderBy('name')->get(),
            'governmentProgram' => GovernmentProgram::select('id', 'program_name')->orderby('program_name')->get(),
            'statistics' => $statistics,
            'totals' => $totals, // Pass totals to the view
        ];

        return view('exports.shelter-request-delivered-materials', $data);
    }

    public function getStatistics()
    {
        $query = DB::table('barangays as b')
            ->select(
                'b.id as barangay_id',
                'b.name as barangay_name',
                DB::raw('COUNT(sa.id) as total_requests'),
                DB::raw('COUNT(CASE WHEN pta.is_tagged = true THEN 1 END) as tagged_requests'),
                DB::raw('COUNT(g.id) as delivered_requests')
            )
            ->leftJoin('addresses as addr', 'addr.barangay_id', '=', 'b.id')
            ->leftJoin('shelter_applicants as sa', 'sa.address_id', '=', 'addr.id')
            ->leftJoin('profiled_tagged_applicants as pta', 'pta.profile_no', '=', 'sa.id')
            ->leftJoin('grantees as g', 'g.profiled_tagged_applicant_id', '=', 'pta.id');

        // Apply date range filter
        if (!empty($this->filters['startDate']) && !empty($this->filters['endDate'])) {
            $query->whereBetween('sa.created_at', [
                Carbon::parse($this->filters['startDate'])->startOfDay(),
                Carbon::parse($this->filters['endDate'])->endOfDay(),
            ]);
        }

        // Filter by government program
        if (!empty($this->filters['barangay_id'])) {
            $query->where('b.id', $this->filters['barangay_id']);
        }

        // Filter by government program
        if (!empty($this->filters['government_program_id'])) {
            $query->where('pta.government_program_id', $this->filters['government_program_id']);
        }

        return $query
            ->groupBy('b.id', 'b.name')
            ->havingRaw('COUNT(sa.id) > 0') // Only barangays with requests
            ->orderBy('b.name', 'asc')
            ->get();
    }

    private function getTotals($statistics)
    {
        return [
            'total_requests' => $statistics->sum('total_requests'),
            'tagged_requests' => $statistics->sum('tagged_requests'),
            'delivered_requests' => $statistics->sum('delivered_requests'),
        ];
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
        $sheet->getColumnDimension('A')->setWidth(4.22); // No
        $sheet->getColumnDimension('B')->setWidth(36.89); // BARANGAY
        $sheet->getColumnDimension('C')->setWidth(30.22); // NO OF REQUEST
        $sheet->getColumnDimension('D')->setWidth(30.22); // NO. OF REQUEST TAGGED AND VALIDATED
        $sheet->getColumnDimension('E')->setWidth(30.22); // NO. OF REQUEST DELIVERED

        // Set print area
        $sheet->getPageSetup()->setPrintArea('A1:K' . ($sheet->getHighestRow()));

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
        $leftDrawing->setCoordinates('A2'); // Starting cell
        $leftDrawing->setOffsetX(5); // Fine-tune horizontal positioning
        $leftDrawing->setOffsetY(5); // Fine-tune vertical positioning

        // Right Logo
        $rightDrawing = new Drawing();
        $rightDrawing->setName('Right Logo');
        $rightDrawing->setDescription('Right Logo');
        $rightDrawing->setPath(public_path('storage/images/logo-right.png')); // Update path if necessary
        $rightDrawing->setHeight(100); // Adjust height as needed
        $rightDrawing->setCoordinates('E2'); // Starting cell for the right logo
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

                // Set to Legal paper size (8.5" x 14")
                $worksheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_LEGAL);
                $worksheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                $worksheet->getPageSetup()->setFitToWidth(1);
                $worksheet->getPageSetup()->setFitToHeight(1);

                // Set margins
                $worksheet->getPageMargins()
                    ->setTop(0.75)
                    ->setLeft(0.7)
                    ->setRight(0.7)
                    ->setBottom(0.75);

                // Set header and footer
                $worksheet->getHeaderFooter()->setOddHeader('');
                $worksheet->getHeaderFooter()->setEvenHeader('');
                $worksheet->getHeaderFooter()->setOddFooter('&P of &N'); // Page number
                $worksheet->getHeaderFooter()->setEvenFooter('&P of &N');

                // Apply styles to the table
                $lastRow = $worksheet->getHighestRow();
                $lastColumn = 'E';


                // Style the table headers
                $worksheet->getStyle("A14:{$lastColumn}14")->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F3F4F6']
                    ]
                ]);

                $worksheet->getStyle('A:E')->getAlignment()->setWrapText(true);
                
            }
        ];
    }
}
