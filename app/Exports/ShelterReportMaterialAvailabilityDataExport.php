<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // was missing
use App\Models\Barangay;
use App\Models\GovernmentProgram;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;

class ShelterReportMaterialAvailabilityDataExport implements FromView, ShouldAutoSize, WithEvents, WithStyles, WithDrawings
{
    use Exportable;

    private $selectedPrPo = null;
    private $filters = [];
    private $isFiltered = false;
    private $materials = [];
    private $prPoHeaders = [];

    // Now accepts the exact same value as the page's $this->selectedPrPo
    public function __construct($selectedPrPo = null, array $filters = [])
    {
        $this->selectedPrPo = $selectedPrPo;
        $this->filters = $filters;
    }

    private function getTitle(): string
    {
        return 'REPORT ON AVAILABILITY OF MATERIALS UNDER THE SHELTER ASSISTANCE PROGRAM';
    }

    private function getSubtitle(): array
    {
        $subtitle = [];

        if (!empty($this->filters['barangay_id'])) {
            $barangay = Barangay::find($this->filters['barangay_id']);
            if ($barangay) {
                $subtitle[] = 'BARANGAY: ' . strtoupper($barangay->name);
            }
        }

        if (!empty($this->filters['government_program_id'])) {
            $program = GovernmentProgram::find($this->filters['government_program_id']);
            if ($program) {
                $subtitle[] = 'SOCIAL WELFARE SECTOR: ' . strtoupper($program->program_name);
            }
        }

        return $subtitle;
    }

    public function view(): View
    {
        $this->fetchPrPoHeaders();
        $materials = $this->fetchMaterials();

        return view('exports.shelter-report-availability-materials', [
            'materials'    => $materials,
            'title'        => $this->getTitle(),
            'subtitle'     => $this->getSubtitle(),
            'isFiltered'   => $this->isFiltered,
            'prPoHeaders'  => $this->prPoHeaders,
        ]);
    }

    // Needed for the unfiltered case — the blade uses $prPoHeaders
    // to build the PR/PO columns, same as the Livewire component does.
    public function fetchPrPoHeaders()
    {
        $this->prPoHeaders = DB::table('purchase_orders')
            ->join('purchase_requisitions', 'purchase_orders.purchase_requisition_id', '=', 'purchase_requisitions.id')
            ->select(
                'purchase_requisitions.pr_number',
                'purchase_orders.po_number'
            )
            ->distinct()
            ->get();
    }

    public function fetchMaterials()
    {
        $query = DB::table('materials')
            ->join('material_units', 'materials.material_unit_id', '=', 'material_units.id')
            ->leftJoin('purchase_orders', 'materials.purchase_order_id', '=', 'purchase_orders.id')
            ->leftJoin('purchase_requisitions', 'purchase_orders.purchase_requisition_id', '=', 'purchase_requisitions.id')
            ->leftJoin('delivered_materials', 'materials.id', '=', 'delivered_materials.material_id')
            ->leftJoin('grantees', 'delivered_materials.grantee_id', '=', 'grantees.id')
            ->leftJoin('profiled_tagged_applicants as pta', 'grantees.profiled_tagged_applicant_id', '=', 'pta.id')
            ->leftJoin('shelter_applicants as sa', 'pta.profile_no', '=', 'sa.id')
            ->leftJoin('addresses as addr', 'sa.address_id', '=', 'addr.id')
            ->select(
                'materials.id as material_id',
                'materials.item_description as description',
                'material_units.unit as unit',
                DB::raw('SUM(materials.quantity) as total_quantity'),
                DB::raw('SUM(delivered_materials.grantee_quantity) as delivered_quantity'),
                DB::raw('SUM(materials.quantity - COALESCE(delivered_materials.grantee_quantity, 0)) as available_quantity'),
                'purchase_requisitions.pr_number',
                'purchase_orders.po_number'
            )
            ->groupBy(
                'materials.id',
                'materials.item_description',
                'material_units.unit',
                'purchase_requisitions.pr_number',
                'purchase_orders.po_number'
            );

        if ($this->selectedPrPo) {
            if (str_contains($this->selectedPrPo, '-PO-')) {
                [$prNumber, $poPart] = explode('-PO-', $this->selectedPrPo, 2);
                $poNumber = 'PO-' . $poPart;

                Log::info('Export filtering with PR: ' . $prNumber . ' and PO: ' . $poNumber);

                $query->where('purchase_requisitions.pr_number', $prNumber)
                    ->where('purchase_orders.po_number', $poNumber);

                $this->isFiltered = true;
            } else {
                Log::error('Invalid PR-PO format in export: ' . $this->selectedPrPo);
                $this->isFiltered = false;
            }
        } else {
            $this->isFiltered = false;
        }

        if (!empty($this->filters['barangay_id'])) {
            $query->where('addr.barangay_id', $this->filters['barangay_id']);
            $this->isFiltered = true;
        }

        if (!empty($this->filters['government_program_id'])) {
            $query->where('pta.government_program_id', $this->filters['government_program_id']);
            $this->isFiltered = true;
        }

        $this->materials = $query->get()->groupBy('material_id');
        return $this->materials;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function drawings(): array
    {
        $drawings = [];

        $leftDrawing = new Drawing();
        $leftDrawing->setName('Left Logo');
        $leftDrawing->setDescription('Left Logo');
        $leftDrawing->setPath(public_path('storage/images/logo-left.png'));
        $leftDrawing->setHeight(85);
        $leftDrawing->setCoordinates('A2');
        $leftDrawing->setOffsetX(5);
        $leftDrawing->setOffsetY(0);

        $rightDrawing = new Drawing();
        $rightDrawing->setName('Right Logo');
        $rightDrawing->setDescription('Right Logo');
        $rightDrawing->setPath(public_path('storage/images/logo-right.png'));
        $rightDrawing->setHeight(85);
        $rightDrawing->setCoordinates('G2');
        $rightDrawing->setOffsetX(5);
        $rightDrawing->setOffsetY(0);

        $drawings[] = $leftDrawing;
        $drawings[] = $rightDrawing;

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageMargins()->setTop(0.5)->setRight(0.5)->setBottom(0.5)->setLeft(0.5);
            },
        ];
    }
}