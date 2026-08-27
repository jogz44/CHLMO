<?php

namespace App\Exports;

use App\Models\Barangay;
use App\Models\CaseSpecification;
use App\Models\LivingSituation;
use App\Models\Purok;
use App\Models\RelocationSite;
use App\Models\TaggedAndValidatedApplicant;
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

class SummaryOfIdentifiedInformalSettlersDataExport implements FromView, ShouldAutoSize, WithChunkReading, WithStyles, WithDrawings, WithEvents
{
    use Exportable;
    private $filters;
    const DANGER_ZONE_ID = 8;
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    private function getTitle(): string
    {
        return 'SUMMARY OF IDENTIFIED INFORMAL SETTLERS';
    }

    private function getSubtitle(): array
    {
        $subtitle = [];

        // Add Date Range
        if (!empty($this->filters['startDate']) && !empty($this->filters['endDate'])) {
            $startDate = Carbon::parse($this->filters['startDate'])->format('m/d/Y');
            $endDate = Carbon::parse($this->filters['endDate'])->format('m/d/Y');
            $subtitle[] = "Date From: {$startDate} To: {$endDate}";
        }
        return $subtitle;
    }

    public function view(): View
    {
        $data = [
            'title' => $this->getTitle(),
            'subtitle' => $this->getSubtitle(),
            'taggedAndValidatedApplicants' => $this->getQuery()
                ->get()
                ->map(function ($item, $index) {
                    // Manually add row number
                    $item->row_num = $index + 1;
                    return $item;
                })
        ];

        return view('exports.summary-of-identified-informal-settlers', $data);
    }

    private function getQuery()
    {
        $query = TaggedAndValidatedApplicant::query()
            ->select([
                'tagged_and_validated_applicants.tagging_date',
                'barangays.name as barangay',
                'puroks.name as purok',
                'living_situations.living_situation_description as living_situation',
                DB::raw('CASE 
                    WHEN tagged_and_validated_applicants.living_situation_id = ' . self::DANGER_ZONE_ID . '
                    THEN case_specifications.case_specification_name 
                    ELSE tagged_and_validated_applicants.living_situation_case_specification 
                END as case_specification'),
                'assigned_relocation_sites.relocation_site_name as assigned_relocation_site',
                DB::raw('COUNT(DISTINCT tagged_and_validated_applicants.id) as occupants_count'),
                DB::raw('COUNT(DISTINCT awardees.id) as awarded_count'),
                DB::raw('GROUP_CONCAT(DISTINCT actual_relocation_sites.relocation_site_name SEPARATOR ", ") as actual_relocation_sites'),
                DB::raw('MIN(tagged_and_validated_applicants.id) as min_id')
            ])
            ->join('applicants', 'tagged_and_validated_applicants.applicant_id', '=', 'applicants.id')
            ->join('addresses', 'applicants.address_id', '=', 'addresses.id')
            ->join('barangays', 'addresses.barangay_id', '=', 'barangays.id')
            ->join('puroks', 'addresses.purok_id', '=', 'puroks.id')
            ->join('living_situations', 'tagged_and_validated_applicants.living_situation_id', '=', 'living_situations.id')
            ->leftJoin('case_specifications', function($join) {
                $join->on('tagged_and_validated_applicants.case_specification_id', '=', 'case_specifications.id')
                    ->where('tagged_and_validated_applicants.living_situation_id', '=', self::DANGER_ZONE_ID);
            })
            ->leftJoin('awardees', 'tagged_and_validated_applicants.id', '=', 'awardees.tagged_and_validated_applicant_id')
            ->leftJoin('relocation_sites as assigned_relocation_sites', 'awardees.assigned_relocation_site_id', '=', 'assigned_relocation_sites.id')
            ->leftJoin('relocation_sites as actual_relocation_sites', 'awardees.actual_relocation_site_id', '=', 'actual_relocation_sites.id');

        // Apply filters [Previous filter logic remains the same]
        if (!empty($this->filters['filterBarangay'])) {
            $query->where('barangays.name', $this->filters['filterBarangay']);
        }

        if (!empty($this->filters['filterPurok'])) {
            $query->where('puroks.name', $this->filters['filterPurok']);
        }

        if (!empty($this->filters['filterLivingSituation'])) {
            $query->where('living_situations.living_situation_description', $this->filters['filterLivingSituation']);
        }

        if (!empty($this->filters['filterCaseSpecification'])) {
            $query->where(function ($q) {
                $q->where(function($subQ) {
                    $subQ->where('tagged_and_validated_applicants.living_situation_id', self::DANGER_ZONE_ID)
                        ->where('case_specifications.case_specification_name', $this->filters['filterCaseSpecification']);
                })->orWhere(function($subQ) {
                    $subQ->where('tagged_and_validated_applicants.living_situation_id', '!=', self::DANGER_ZONE_ID)
                        ->where('tagged_and_validated_applicants.living_situation_case_specification', $this->filters['filterCaseSpecification']);
                });
            });
        }

        if (!empty($this->filters['startDate'])) {
            $query->where('tagged_and_validated_applicants.tagging_date', '>=', $this->filters['startDate']);
        }

        if (!empty($this->filters['endDate'])) {
            $query->where('tagged_and_validated_applicants.tagging_date', '<=', $this->filters['endDate']);
        }

        if (!empty($this->filters['filterAssignedRelocationSite'])) {
            $query->where('assigned_relocation_sites.relocation_site_name', $this->filters['filterAssignedRelocationSite']);
        }

        if (!empty($this->filters['filterActualRelocationSite'])) {
            $query->whereExists(function ($subquery) {
                $subquery->select(DB::raw(1))
                    ->from('awardees as a')
                    ->join('relocation_sites as rs', 'a.actual_relocation_site_id', '=', 'rs.id')
                    ->whereColumn('a.tagged_and_validated_applicant_id', 'tagged_and_validated_applicants.id')
                    ->where('rs.relocation_site_name', $this->filters['filterActualRelocationSite']);
            });
        }

        // Get filter options (cached for performance)
        if (!empty($this->filters['filterOptions'])) {
            $this->filters['filterOptions'] = [
                'barangays' => Barangay::pluck('name')->unique()->sort()->values(),
                'puroks' => Purok::pluck('name')->unique()->sort()->values(),
                'livingSituations' => LivingSituation::pluck('living_situation_description')->unique()->sort()->values(),
                'caseSpecifications' => collect([
                    // Get Danger Zone case specifications
                    CaseSpecification::pluck('case_specification_name'),
                    // Get other living situation case specifications
                    TaggedAndValidatedApplicant::where('living_situation_id', '!=', self::DANGER_ZONE_ID)
                        ->whereNotNull('living_situation_case_specification')
                        ->pluck('living_situation_case_specification')
                ])->flatten()->unique()->sort()->values(),
                // Add filter options for Assigned and Actual Relocation Sites
                'relocationSites' => RelocationSite::all(),
            ];
        }

        // Create a copy of the base query for totals
        $totalsQuery = (clone $query);

        // Calculate totals without grouping
        $totals = $totalsQuery
            ->select([
                DB::raw('COUNT(DISTINCT tagged_and_validated_applicants.id) as total_occupants'),
                DB::raw('COUNT(DISTINCT awardees.id) as total_awarded')
            ])
            ->first();

        // Create a copy of the base query before grouping for totals calculation
        $totalsQuery = (clone $query);
        $grandTotals = (clone $totalsQuery)
            ->select([
                DB::raw('COUNT(DISTINCT tagged_and_validated_applicants.id) as total_occupants'),
                DB::raw('COUNT(DISTINCT awardees.id) as total_awarded'),
                DB::raw('COUNT(DISTINCT CASE WHEN awardees.id IS NULL THEN tagged_and_validated_applicants.id END) as total_pending')
            ])
            ->first();

        // Group by and order by
        $query->groupBy([
            'tagged_and_validated_applicants.tagging_date',
            'barangays.name',
            'puroks.name',
            'living_situations.living_situation_description',
            DB::raw('CASE 
                WHEN tagged_and_validated_applicants.living_situation_id = ' . self::DANGER_ZONE_ID . '
                THEN case_specifications.case_specification_name 
                ELSE tagged_and_validated_applicants.living_situation_case_specification 
            END'),
            'assigned_relocation_sites.relocation_site_name'
        ])->orderBy('min_id');

        return $query;
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
        $sheet->getColumnDimension('A')->setWidth(6.22); // ID.
        $sheet->getColumnDimension('B')->setWidth(15.56); // PRINCIPAL NAME
        $sheet->getColumnDimension('C')->setWidth(30); // AGE
        $sheet->getColumnDimension('D')->setWidth(30); // Purok
        $sheet->getColumnDimension('E')->setWidth(35); // living Situation (case)
        $sheet->getColumnDimension('F')->setWidth(35); // Case Specification
        $sheet->getColumnDimension('G')->setWidth(12.44); // No. of Actual Occupants
        $sheet->getColumnDimension('H')->setWidth(35); // Assigned Relocation Site
        $sheet->getColumnDimension('I')->setWidth(12.44); // Awarded
        $sheet->getColumnDimension('J')->setWidth(35); // Actual Relocation Site
        $sheet->getColumnDimension('K')->setWidth(35); // Remarks

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
        $leftDrawing->setHeight(85); // Adjust height as needed
        $leftDrawing->setCoordinates('E2'); // Starting cell
        $leftDrawing->setOffsetX(230); // Align near the right edge of column B
        $leftDrawing->setOffsetY(0); // Fine-tune vertical positioning

        // Right Logo
        $rightDrawing = new Drawing();
        $rightDrawing->setName('Right Logo');
        $rightDrawing->setDescription('Right Logo');
        $rightDrawing->setPath(public_path('storage/images/logo-right.png')); 
        $rightDrawing->setHeight(85); // Adjust height as needed
        $rightDrawing->setCoordinates('G2'); // Starting cell for the right logo
        $rightDrawing->setOffsetX(0); // Fine-tune horizontal positioning
        $rightDrawing->setOffsetY(0); // Fine-tune vertical positioning

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
            AfterSheet::class => function(AfterSheet $event) {
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
                $lastColumn = 'K';
                $preparedByRow = null;

                for ($row = 1; $row <= $lastRow; $row++) {
                    if ($worksheet->getCell("A{$row}")->getValue() === 'Prepared by:') {
                        $preparedByRow = $row;
                        break;
                    }
                }

                $lastTableRow = $preparedByRow ? $preparedByRow - 2 : $lastRow;

                // Style the header rows
                $worksheet->getStyle('A1:K12')->getFont()->setSize(9);
                $worksheet->getStyle('A6')->getFont()->setSize(14);

                // Style the table headers
                $worksheet->getStyle("A14:{$lastColumn}14")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F3F4F6']
                    ]
                ]);

                // Add borders to the table
                $worksheet->getStyle("A14:{$lastColumn}{$lastTableRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ]
                    ]
                ]);

                // Remove borders for specific rows (A15-A17)
                // $worksheet->getStyle('A14:K17')->applyFromArray([
                //     'borders' => [
                //         'outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE],
                //         'inside' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE]
                //     ]
                // ]);

                $worksheet->getStyle('A:K')->getAlignment()->setWrapText(true);
            }
        ];
    }
}
