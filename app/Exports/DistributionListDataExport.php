<?php

namespace App\Exports;

use App\Models\Barangay;
use App\Models\Shelter\ProfiledTaggedApplicant;
use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\PurchaseOrder;
use App\Models\Shelter\PurchaseRequisition;
use App\Models\Shelter\Material;
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

class DistributionListDataExport implements FromView, ShouldAutoSize, WithChunkReading, WithStyles, WithDrawings, WithEvents
{
    use Exportable;
    private $filters;
    private $governmentProgram;
    private $selectedPrNumber;
    private $poNumbers;
    private $prNumbers;
    private $materials = [];
    private $selectedPoNumber;
    private $startRisDate;
    private $endRisDate;
    private $selectedPrId;
    private $selectedPoId;


    const DANGER_ZONE_ID = 8;

    private function getTitle(): string
    {
        return 'SHELTER ASSISTANCE PROGRAM';
    }

    private function getSubtitle(): string
    {
        return 'DISTRIBUTION LIST';
    }

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;

        // Extract specific filter values
        $this->startRisDate = $filters['start_date'] ?? null;
        $this->endRisDate = $filters['end_date'] ?? null;
        $this->selectedPoNumber = $filters['po_number'] ?? null;
        $this->selectedPrNumber = $filters['pr_number'] ?? null;
    }

    public function view(): View
    {
        $query = Grantee::with([
            'profiledTaggedApplicant.shelterApplicant.person',
            'deliveredMaterials.material',
            'deliveredMaterials.material.purchaseOrder',
            'deliveredMaterials.material.materialUnit',
        ]);

        // Apply date range filter
        if ($this->startRisDate && $this->endRisDate) {
            $query->whereBetween('date_of_ris', [$this->startRisDate, $this->endRisDate]);
        }

        // Apply PO Number Filter
        if (!empty($this->selectedPoNumber)) {
            $query->whereHas('deliveredMaterials.material.purchaseOrder', function ($q) {
                $q->where('id', $this->selectedPoNumber);
            });
        }

        // Apply PR Number Filter
        if (!empty($this->selectedPrNumber)) {
            $query->whereHas('deliveredMaterials.material.purchaseOrder.purchaseRequisition', function ($q) {
                $q->where('id', $this->selectedPrNumber);
            });
        }

        $grantees = $query->get();

        // Calculate totals 
        $totals = [
            'total_delivered' => $grantees->sum(function ($grantee) {
                return $grantee->deliveredMaterials->sum('grantee_quantity');
            }),
        ];

        // Dynamic material filtering based on grantees and filters
        $materialIds = $grantees->pluck('deliveredMaterials.*.material_id')->flatten()->unique();
        $allMaterials = Material::whereIn('id', $materialIds)
            ->when(!empty($this->selectedPoNumber), function ($q) {
                $q->whereHas('purchaseOrder', function ($q) {
                    $q->where('id', $this->selectedPoNumber);
                });
            })
            ->when(!empty($this->selectedPrNumber), function ($q) {
                $q->whereHas('purchaseOrder.purchaseRequisition', function ($q) {
                    $q->where('id', $this->selectedPrNumber);
                });
            })
            ->with(
                'materialUnit',
            )
            ->get();

        $selectedPrNumber = $this->getPrNumber(); // Fetch PR number from the related model or attribute
        $selectedPoNumber = $this->getPoNumber(); // Fetch PO number from the related model or attribute

        return view('exports.distribution-lists', [
            'grantees' => $grantees,
            'allMaterials' => $allMaterials,
            'title' => 'SHELTER ASSISTANCE PROGRAM',
            'subtitle' => 'DISTRIBUTION LIST',
            'totals' => $totals,
            'selectedPoNumber' => $this->selectedPoNumber,
            'selectedPrNumber' => $this->selectedPrNumber,
            'startRisDate' => $this->startRisDate,
            'endRisDate' => $this->endRisDate,
        ]);
    }

    private function getPrNumber()
    {
        return PurchaseRequisition::find($this->selectedPrId)?->pr_number ?? null; // Assuming you store the PR ID in $this->selectedPrId
    }

    private function getPoNumber()
    {
        return PurchaseOrder::find($this->selectedPoId)?->po_number ?? null; // Assuming you store the PO ID in $this->selectedPoId
    }


    public function updatedSelectedPrNumber($value)
    {
        if (!empty($value)) {
            // Fetch POs related to the selected PR
            $this->poNumbers = PurchaseOrder::where('purchase_requisition_id', $value)->pluck('po_number', 'id')->toArray();
        } else {
            // Reset POs to all available if no PR is selected
            $this->poNumbers = PurchaseOrder::pluck('po_number', 'id')->toArray();
        }

        // Clear the selected PO if PR is changed
        $this->selectedPoNumber = '';
        $this->applyFilters(); // Ensure filters are applied immediately
    }

    public function applyFilters()
    {
        // Refetch PO numbers if PR is selected
        if (!empty($this->selectedPrNumber)) {
            $this->poNumbers = PurchaseOrder::where('purchase_requisition_id', $this->selectedPrNumber)->pluck('po_number', 'id')->toArray();
        }
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
        $sheet->getColumnDimension('B')->setWidth(30); // date ris
        $sheet->getColumnDimension('C')->setWidth(10); // name
        $sheet->getColumnDimension('D')->setWidth(15); // ar no
        $sheet->getColumnDimension('E')->setWidth(15); // material

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
                $event->sheet->getStyle('A9:H9')->applyFromArray($styleBottomMedium); // Thick border
                $event->sheet->getStyle('A13:H13')->applyFromArray($styleBottomMedium); // Medium border
                $event->sheet->getStyle('A15:H15')->applyFromArray($styleBottomThin); // Thin border
            },
        ];
    }
}
