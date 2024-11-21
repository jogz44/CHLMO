<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\Material;
use App\Models\Shelter\PurchaseOrder;
use App\Models\Shelter\PurchaseRequisition;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;

class ShelterDistributionList extends Component
{
    use WithPagination;

    public $search = '';
    public $profileNo, $date_of_ris, $first_name, $middle_name, $last_name, $contact_number;
    public $startRisDate, $endRisDate;
    public $selectedMaterial, $materials = [], $purchaseOrder, $purchaseRequisition, $purchaseOrderFilter, $purchaseRequisitionFilter;
    public $poNumbers = [];
    public $prNumbers = [];
    public $selectedPoNumber = '';
    public $selectedPrNumber = '';

    public function mount()
    {
        $this->date_of_ris = now()->toDateString();
        $this->startRisDate = null;
        $this->endRisDate = null;
        $this->search = ''; // Ensure search is empty initially

        $this->materials = Material::all();
        // Fetch PO and PR numbers
        $this->poNumbers = PurchaseOrder::pluck('po_number', 'id')->toArray(); // id => po_number
        $this->prNumbers = PurchaseRequisition::pluck('pr_number', 'id')->toArray(); // id => pr_number

        // Cache filters to improve performance
        $this->purchaseOrderFilter = Cache::remember('purchaseOrder', 3600, function () {
            return PurchaseOrder::all();
        });
        $this->purchaseRequisitionFilter = Cache::remember('purchaseRequisition', 3600, function () {
            return PurchaseRequisition::all();
        });
    }

    public function applyFilters()
    {
        $this->resetPage(); // Reset pagination when applying filters

        // Refetch PO numbers if PR is selected
        if (!empty($this->selectedPrNumber)) {
            $this->poNumbers = PurchaseOrder::where('purchase_requisition_id', $this->selectedPrNumber)->pluck('po_number', 'id')->toArray();
        }

        // Ensure grantees are filtered correctly
        $this->render();
    }

    // Triggered when search or other filters are updated
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Reset pagination when search changes
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->startRisDate = null;
        $this->endRisDate = null;
        $this->search = '';
        $this->selectedPrNumber = null;
        $this->selectedPoNumber = null;
        $this->resetPage();
    }

    // Clear search input
    public function clearSearch()
    {
        $this->search = '';
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

    public function render()
    {
        $query = Grantee::with([
            'profiledTaggedApplicant.shelterApplicant.person',
            'deliveredMaterials.material',
            'deliveredMaterials.material.purchaseOrder',
            'deliveredMaterials.material.materialUnit' // Ensure relationships for materials
        ])->where(function ($query) {
            $query->whereHas('profiledTaggedApplicant.shelterApplicant.person', function ($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            })->orWhereHas('profiledTaggedApplicant.shelterApplicant', function ($q) {
                $q->where('request_origin_id', 'like', '%' . $this->search . '%')
                    ->orWhere('profile_no', 'like', '%' . $this->search . '%')
                    ->orWhere('contact_number', 'like', '%' . $this->search . '%');
            });
        });

        // Apply date range filter
        if ($this->startRisDate && $this->endRisDate) {
            $query->whereBetween('date_of_ris', [$this->startRisDate, $this->endRisDate]);
        }

        // // Apply PO Number Filter
        if (!empty($this->selectedPoNumber)) {
            $query->whereHas('deliveredMaterials.material.purchaseOrder', function ($q) {
                $q->where('id', $this->selectedPoNumber);
            });
        } elseif (!empty($this->selectedPrNumber)) {
            // Only apply PR filter when PO is not selected
            $query->whereHas('deliveredMaterials.material.purchaseOrder.purchaseRequisition', function ($q) {
                $q->where('id', $this->selectedPrNumber);
            });
        }


        // Apply PR Number Filter
        if (!empty($this->selectedPrNumber)) {
            $query->whereHas('deliveredMaterials.material.purchaseOrder.purchaseRequisition', function ($q) {
                $q->where('id', $this->selectedPrNumber);
            });
        }

        // Get the paginated grantees
        $grantees = $query->orderBy('date_of_ris', 'desc')->paginate(5);

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

        return view('livewire.shelter-distribution-list', [
            'grantees' => $grantees,
            'allMaterials' => $allMaterials, // Pass all unique materials to the view
        ]);
    }
}
