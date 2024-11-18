<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ShelterReportAvailabilityMaterials extends Component
{
    public $materials;
    public $totalQuantity;

    public function mount()
    {
        // Fetch materials with correct aggregation
        $this->materials = DB::table('materials')
            ->join('material_units', 'materials.material_unit_id', '=', 'material_units.id')
            ->leftJoin('delivered_materials', 'materials.id', '=', 'delivered_materials.material_id')
            ->select(
                'materials.id as id',
                'materials.item_description as description',
                'material_units.unit as unit',
                'materials.quantity as total_quantity', // Fetch total quantity
                DB::raw('COALESCE(SUM(delivered_materials.grantee_quantity), 0) as withdrawal'), // Aggregate withdrawal
                DB::raw('materials.quantity - COALESCE(SUM(delivered_materials.grantee_quantity), 0) as available_materials') // Calculate available materials
            )
            ->groupBy('materials.id', 'materials.item_description', 'material_units.unit', 'materials.quantity') // Group by necessary fields
            ->get();

        // Calculate total quantity of all materials
        $this->totalQuantity = DB::table('materials')
            ->sum('quantity'); // Sum up the 'quantity' column
    }

    public function render()
    {
        return view('livewire.shelter-report-availability-materials', [
            'materials' => $this->materials,
            'totalQuantity' => $this->totalQuantity,
        ]);
    }
}