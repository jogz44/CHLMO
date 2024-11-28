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


    const DANGER_ZONE_ID = 8;

    private function getTitle(): string
    {
        return 'DISTRIBUTION LIST';
    }

    private function getSubtitle(): array
    {
        $subtitle = [];

        if (!empty($this->selectedPrNumber)) {
            $this->poNumbers = PurchaseOrder::where('purchase_requisition_id', $this->selectedPrNumber)->pluck('po_number', 'id')->toArray();
            $subtitle[] = "PO AND PR: {poNumbers}";
        }

        // Add Date Range
        if (!empty($this->filters['startRisDate']) && !empty($this->filters['endRisDate'])) {
            $startRisDate = Carbon::parse($this->filters['startRisDate'])->format('m/d/Y');
            $endRisDate = Carbon::parse($this->filters['endRisDate'])->format('m/d/Y');
            $subtitle[] = "FOR THE PERIOD OF: {$startRisDate} TO: {$endRisDate}";
        }

        return $subtitle;
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
            'deliveredMaterials.material.materialUnit'
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
            ->with('materialUnit')
            ->get();

        // Prep subtitle to show applied filters
        $subtitles = [];
        if ($this->startRisDate && $this->endRisDate) {
            $subtitles[] = "Date Range: " .
                Carbon::parse($this->startRisDate)->format('m/d/Y') .
                " to " .
                Carbon::parse($this->endRisDate)->format('m/d/Y');
        }

        if ($this->selectedPrNumber) {
            $prNumber = PurchaseRequisition::find($this->selectedPrNumber)->pr_number ?? 'N/A';
            $subtitles[] = "PR Number: {$prNumber}";
        }

        if ($this->selectedPoNumber) {
            $poNumber = PurchaseOrder::find($this->selectedPoNumber)->po_number ?? 'N/A';
            $subtitles[] = "PO Number: {$poNumber}";
        }

        return view('exports.distribution-lists', [
            'grantees' => $grantees,
            'allMaterials' => $allMaterials,
            'title' => 'DISTRIBUTION LIST',
            'subtitle' => $subtitles,
            'poNumbers' => $this->poNumbers,
            'prNumbers' => $this->prNumbers,
            'selectedPoNumber' => $this->selectedPoNumber,
            'selectedPrNumber' => $this->selectedPrNumber,
            'startRisDate' => $this->startRisDate,
            'endRisDate' => $this->endRisDate,
        ]);
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
        $sheet->getColumnDimension('D')->setWidth(15); // contact
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

                // Optional: Adjust column widths to fit content
                $worksheet->getColumnDimension('A')->setWidth(13.33);
                $worksheet->getColumnDimension('B')->setWidth(43.89);
                $worksheet->getColumnDimension('C')->setWidth(6.89);
                $worksheet->getColumnDimension('D')->setWidth(15.11);
                $worksheet->getColumnDimension('E')->setWidth(19.56);
            },
        ];
    }
}
