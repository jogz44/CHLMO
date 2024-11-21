<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shelter\Material;

class ShelterReportAvailabilityMaterials extends Component
{
    public $materials;
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
        $this->loadMaterials(); // Load materials on initialization
    }

    public function updated($propertyName)
    {
        $this->loadMaterials(); // Reload materials when filters are updated
    }

   public function loadMaterials()
   {
       // Build the query using Eloquent relationships and eager loading
       $this->materials = Material::query()
           ->with(['materialUnit', 'purchaseOrder.purchaseRequisition']) // Eager load relationships
           ->select(
               'materials.id',
               'materials.item_description',
               'materials.material_unit_id',
               'materials.quantity',
               'materials.available_quantity',
               'materials.purchase_order_id'
           )
           ->when($this->itemsDescription, fn($query) => $query->where('item_description', 'like', "%{$this->itemsDescription}%"))
           ->when($this->quantity, fn($query) => $query->where('quantity', '>=', $this->quantity))
           ->when($this->unit, fn($query) => $query->where('material_unit_id', $this->unit))
           ->when($this->poNumber, fn($query) => $query->whereHas('purchaseOrder', fn($q) => $q->where('po_number', $this->poNumber)))
           ->when($this->prNumber, fn($query) => $query->whereHas('purchaseOrder.purchaseRequisition', fn($q) => $q->where('pr_number', $this->prNumber)))
           ->get();
   
       // Group materials by PO Number and PR Number
       $this->groupedMaterials = $this->materials
           ->groupBy(function ($material) {
               $po_number = $material->purchaseOrder->po_number ?? 'Unknown PO';
               $pr_number = $material->purchaseOrder->purchaseRequisition->pr_number ?? 'Unknown PR';
               return "{$po_number} | {$pr_number}";
           })
           ->map(function ($group) {
               // Aggregate materials and count occurrences of each material description within the group
               $aggregatedMaterials = [];
               foreach ($group as $material) {
                   $key = $material->item_description;
                   
                   // If material already exists, increment the count and available quantity
                   if (isset($aggregatedMaterials[$key])) {
                       $aggregatedMaterials[$key]['count'] += 1;
                       $aggregatedMaterials[$key]['available_quantity'] += $material->available_quantity;
                   } else {
                       // Initialize the material entry
                       $aggregatedMaterials[$key] = [
                           'item_description' => $material->item_description,
                           'unit' => $material->materialUnit->unit ?? 'N/A',
                           'available_quantity' => $material->available_quantity,
                           'count' => 1,
                       ];
                   }
               }
   
               return [
                   'po_number' => $group->first()->purchaseOrder->po_number ?? 'Unknown PO',
                   'pr_number' => $group->first()->purchaseOrder->purchaseRequisition->pr_number ?? 'Unknown PR',
                   'materials' => $aggregatedMaterials,
               ];
           });

        // Calculate total quantity for all materials
        $this->totalQuantity = $this->materials->sum('quantity');
    }

    public function render()
    {
        return view('livewire.shelter-report-availability-materials', [
            'groupedMaterials' => $this->groupedMaterials, // Pass grouped materials to the Blade view
        ]);
    }
}
