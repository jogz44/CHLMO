<?php

namespace App\Livewire;

use App\Models\Shelter\Material;
use App\Models\Barangay;
use App\Models\GovernmentProgram;
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
    public $selectedBarangay_id = null;
    public $governmentProgram = null;
    public $barangaysFilter = [];
    public $governmentProgramsFilter = [];
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
        $this->barangaysFilter = Barangay::orderBy('name')->get();
        $this->governmentProgramsFilter = GovernmentProgram::orderBy('program_name')->get();
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
    
        // Correctly parse and apply filtering
        if ($this->selectedPrPo) {
    if (str_contains($this->selectedPrPo, '-PO-')) {
        [$prNumber, $poPart] = explode('-PO-', $this->selectedPrPo, 2);
        $poNumber = 'PO-' . $poPart;

        Log::info('Filtering with PR: ' . $prNumber . ' and PO: ' . $poNumber);

        $query->where('purchase_requisitions.pr_number', $prNumber)
              ->where('purchase_orders.po_number', $poNumber);

        $this->isFiltered = true;
    } else {
        Log::error('Invalid PR-PO format: ' . $this->selectedPrPo);
        $this->isFiltered = false;
    }
} else {
    $this->isFiltered = false;
}

        if ($this->selectedBarangay_id) {
            $query->where('addr.barangay_id', $this->selectedBarangay_id);
            $this->isFiltered = true;
        }

        if ($this->governmentProgram) {
            $query->where('pta.government_program_id', $this->governmentProgram);
            $this->isFiltered = true;
        }
    
        $this->materials = $query->get()->groupBy('material_id');
    
    }

    public function updatedSelectedPrPo()
    {   
        $this->fetchMaterials();

        Log::info('Selected PR-PO: ' . $this->selectedPrPo);
        Log::info('Materials after filtering: ' . json_encode($this->materials));
        Log::info('Is Filtered: ' . ($this->isFiltered ? 'Yes' : 'No'));
    }

    public function updatedSelectedBarangay_id()
    {
        $this->fetchMaterials();
    }

    public function updatedGovernmentProgram()
    {
        $this->fetchMaterials();
    }

    public function clearFilter()
    {
        $this->selectedPrPo = null;
        $this->selectedBarangay_id = null;
        $this->governmentProgram = null;
        $this->isFiltered = false;
        $this->fetchMaterials(); // Re-fetch materials when filter is cleared

    }

public function export()
{
    try {
        // Pass the SAME filter currently applied on the page (selectedPrPo)
        // so the Excel export matches exactly what's displayed in the table.
        return Excel::download(
            new ShelterReportMaterialAvailabilityDataExport($this->selectedPrPo, [
                'barangay_id' => $this->selectedBarangay_id,
                'government_program_id' => $this->governmentProgram,
            ]),
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
}


    public function render()
    {
        return view('livewire.shelter-report-availability-materials', [
            'materials' => $this->materials,
            'prPoHeaders' => $this->prPoHeaders,
            'barangaysFilter' => $this->barangaysFilter,
            'governmentProgramsFilter' => $this->governmentProgramsFilter,
            'isFiltered' => $this->isFiltered,
        ]);
    }
}
