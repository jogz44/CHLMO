<?php

namespace App\Livewire;

use App\Models\Shelter\Material;
use Livewire\Component;
use Livewire\WithPagination;

class ShelterMaterialsList extends Component
{
    use WithPagination;

    public $search = '';
    public $purchaseOrderNo;
    public $purchaseRequisitionNo;
    public $itemsDescription;
    public $quantity;
    public $unit;
    public $perPage = 15;

    protected $queryString = [
        'purchaseOrderNo' => ['except' => ''],
        'purchaseRequisitionNo' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
    }

    public function resetFilters()
    {
        $this->reset(['purchaseOrderNo', 'purchaseRequisitionNo', 'itemsDescription', 'quantity', 'unit']);
    }

    public function render()
    {
        $materials = Material::query()
        ->when($this->purchaseOrderNo, fn($query) => $query->where('purchase_order_id', 'like', "%{$this->purchaseOrderNo}%"))
        ->when($this->purchaseRequisitionNo, fn($query) => $query->where('purchase_requisition_no', 'like', "%{$this->purchaseRequisitionNo}%"))
        ->when($this->itemsDescription, fn($query) => $query->where('item_description', 'like', "%{$this->itemsDescription}%"))
        ->when($this->quantity, fn($query) => $query->where('quantity', $this->quantity))
        ->when($this->unit, fn($query) => $query->where('material_unit_id', $this->unit)) // Exact match for unit
        ->paginate($this->perPage);
        
        return view('livewire.shelter-materials-list', [
            'materials' => $materials
        ]);

        dd($materials); // Debugging output to check the query result
    }
}