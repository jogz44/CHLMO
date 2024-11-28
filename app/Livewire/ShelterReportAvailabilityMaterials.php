<?php

namespace App\Livewire;

use App\Models\Shelter\Material;
use GuzzleHttp\Psr7\Query;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Exports\MaterialAvailabilityExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel; // Correct Excel import
use App\Exports\ShelterReportMaterialAvailabilityDataExport;




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
        

    $this->materials = $query->get()->groupBy('material_id');
}

    public function updatedSelectedPrPo()
    {
    // $this->isFiltered = !empty($this->selectedPrPo); // Set filter flag
    $this->isFiltered = true;
    $this->fetchMaterials();
    }


    // public function clearFilter()
    // {
    //     $this->selectedPrPo = null;
    //     $this->fetchMaterials();
    // }
    public function clearFilter()
{
    $this->selectedPrPo = null;
    $this->isFiltered = false;  // Reset the filter flag
    $this->fetchMaterials();
}


    public function export()
{
    try {
        $filters = array_filter([
            'po_number' => $this->poNumber,        // PO Number filter
            'pr_number' => $this->prNumber,        // PR Number filter
            'item_description' => $this->itemsDescription,  // Filter for item description
            'availability_status' => $this->available_quantity > 0 ? 1 : 0,  // Filter for availability
        ]);

        return Excel::download(
            new ShelterReportMaterialAvailabilityDataExport($filters),
            'shelter-' . now()->format('Y-m-d') . '.xlsx'
        );
    } catch (\Exception $e) {
        Log::error('Export error: ' . $e->getMessage());
        $this->dispatch('alert', [
            'title' => 'Export failed:',
            'message' => $e->getMessage(),
            'type' => 'danger',
        ]);
    }
    // Dispatch a browser event in case of an error
    $this->dispatch('alert', [
        'title' => 'Export failed:',
        'message' => $e->getMessage(),
        'type' => 'danger',
    ]);
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

