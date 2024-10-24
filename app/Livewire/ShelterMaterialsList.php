<?php

namespace App\Livewire;

use App\Models\Shelter\Material;
use Livewire\Component;
use Livewire\WithPagination;

class ShelterMaterialsList extends Component
{
    use WithPagination;  // Make sure to use the pagination trait

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

    public function updating($property)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['purchaseOrderNo', 'purchaseRequisitionNo']);
    }

    public function render()
    {
        $materials = Material::query()
            ->when($this->purchaseOrderNo, function($query) {
                return $query->where('purchase_order_id', 'like', "%{$this->purchaseOrderNo}%");
            })
            ->when($this->purchaseRequisitionNo, function($query) {
                return $query->where('purchase_requisition_no', 'like', "%{$this->purchaseRequisitionNo}%");
            })
            ->paginate($this->perPage);

        return view('livewire.shelter-materials-list', [
            'materials' => $materials
        ]);
    }
}
