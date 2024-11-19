<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ShelterReportAvailabilityMaterials extends Component
{
    public $materials;
    public $totalQuantity;
    public $filter;
    // Filter properties
    public $startDate;
    public $endDate;
    public $barangay;
    public $sector;
    public $poNumber;
    public $prNumber;

    public function mount()
    {
        $this->materials = DB::table('materials')
            ->join('material_units', 'materials.material_unit_id', '=', 'material_units.id')
            ->leftJoin('delivered_materials', 'materials.id', '=', 'delivered_materials.material_id')
            ->select(
                'materials.id as id',
                'materials.item_description as description',
                'material_units.unit as unit',
                'materials.quantity as total_quantity',
                DB::raw('COALESCE(SUM(delivered_materials.grantee_quantity), 0) as withdrawal'),
                DB::raw('materials.quantity - COALESCE(SUM(delivered_materials.grantee_quantity), 0) as available_materials')
            )
            ->groupBy('materials.id', 'materials.item_description', 'material_units.unit', 'materials.quantity')
            ->get();

        // Update total quantity
        $this->totalQuantity = DB::table('materials')
            ->sum('quantity');
    }

    public function render()
    {
        return view('livewire.shelter-report-availability-materials', [
            'materials' => $this->materials,
            'totalQuantity' => $this->totalQuantity,
        ]);
    }
}