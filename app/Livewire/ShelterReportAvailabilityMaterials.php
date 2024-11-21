<?php

namespace App\Livewire;

use App\Models\Shelter\Material;
use GuzzleHttp\Psr7\Query;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ShelterReportAvailabilityMaterials extends Component
{
    use WithPagination;
    public $materials = [];
    public $prPoHeaders = [];
    public $selectedPrPo = null; // Track selected PR-PO combination
    public $isFiltered = false; // Flag to track if a filter is applied
    public $groupedMaterials = [];
    public $totalQuantity;
    public $itemsDescription = '';
    public $quantity = '';
    public $available_quantity = '';
    public $unit = '';
    public $poNumber = ''; // PO Number
    public $prNumber = ''; // PR Number

    public function mount()
    {
        $this->fetchPrPoHeaders();
        $this->fetchMaterials();
    }

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
            $prPo = explode('-', $this->selectedPrPo); // Split PR-PO
            $query->where('purchase_requisitions.pr_number', $prPo[0])
                  ->where('purchase_orders.po_number', $prPo[1]);
            $this->isFiltered = true; // Set filter flag
        } else {
            $this->isFiltered = false; // Reset filter flag
        }

        $this->materials = $query->get()->groupBy('material_id');
    }

    public function updatedSelectedPrPo()
    {
        $this->fetchMaterials();
    }

    public function clearFilter()
    {
        $this->selectedPrPo = null;
        $this->fetchMaterials();
    }

    public function render()
    {
        return view('livewire.shelter-report-availability-materials', [
            'materials' => $this->materials,
            'prPoHeaders' => $this->prPoHeaders,
            'isFiltered' => $this->isFiltered,
        ]);
    }
}

