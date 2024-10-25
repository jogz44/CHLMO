<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Shelter\Material;
use App\Models\Shelter\MaterialUnit;
use App\Models\Shelter\PurchaseOrder;
use App\Models\Shelter\PurchaseRequisition;

class ShelterMaterialInventory extends Component
{
    public $item_description;
    public $unit;
    public $quantity;
    public $purchaseOrderNo;
    public $purchaseRequisitionNo;  // New field for Purchase Requisition Number
    public $search = '';
    public $material_unit_id;
    public $materialUnits = [];

    public $rows = [
        ['item_description' => '', 'quantity' => '', 'unit' => ''],
    ];

    // Updated validation rules to ensure required fields
    protected $rules = [
        'purchaseOrderNo' => 'required|string|max:255',
        'purchaseRequisitionNo' => 'required|string|max:255',  // Validate the Purchase Requisition No
        'rows.*.item_description' => 'required|string|max:255',
        'rows.*.quantity' => 'required|numeric',
        'rows.*.unit' => 'required|string|max:255',
    ];

    // public function updatingSearch(): void
    // {
    //     // This ensures that the search query is updated dynamically as the user types
    //     $this->resetPage();
    // }
    // public function clearSearch()
    // {
    //     $this->search = ''; // Clear the search input
    // }
    // public function resetFilters(): void
    // {
    //     $this->item_description = null;
    //     $this->quantity = null;
    //     $this->unit = null;

    //     // Reset pagination and any search terms
    //     // $this->resetPage();
    //     $this->search = '';
    // }


    // Load material units on component mount
    public function mount()
    {
        $this->materialUnits = MaterialUnit::all(); // Load material units
    }

    // Add a new row
    public function addRow()
    {
        $this->rows[] = ['item_description' => '', 'quantity' => '', 'unit' => ''];
    }

    // Remove a row by index
    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows); // Re-index the array after removal
    }

    // Save function to handle the logic
    public function save()
    {
        try {
            // Validate the input
            $this->validate();

            // Ensure the purchase order number starts with "PO"
            if (!str_starts_with($this->purchaseOrderNo, 'PO-')) {
                $this->purchaseOrderNo = 'PO-' . strtoupper($this->purchaseOrderNo); // Add "PO" and make uppercase
            }

            // First, handle the Purchase Requisition
            $purchaseRequisition = PurchaseRequisition::firstOrCreate(
                ['pr_number' => $this->purchaseRequisitionNo],  // Look for existing requisition by pr_number
                ['pr_number' => $this->purchaseRequisitionNo]   // Create a new one if not found
            );
            $purchaseRequisition = PurchaseRequisition::firstOrCreate(
                ['pr_number' => $this->purchaseRequisitionNo],  // Make sure this line refers to 'pr_number'
                ['pr_number' => $this->purchaseRequisitionNo]   // This should be saving 'pr_number', not 'id'
            );


            // Then, handle the Purchase Order creation
            $purchaseOrder = PurchaseOrder::firstOrCreate(
                ['po_number' => $this->purchaseOrderNo],   // Look for existing purchase order by po_number
                [
                    'po_number' => $this->purchaseOrderNo,   // Create with custom input
                    'purchase_requisition_id' => $purchaseRequisition->id  // Link to the newly created or existing requisition
                ]
            );

            // Loop through each row and save the material information
            foreach ($this->rows as $row) {
                // Get the material unit ID based on the selected unit from the form
                // $materialUnitId = MaterialUnit::where('id', $row['unit'])->value('id');
                $materialUnitId = $row['unit'];
                if (!$materialUnitId) {
                    session()->flash('error', 'Invalid material unit.');
                    return;
                }

                // Create a new material record in the database
                Material::create([
                    'purchase_order_id' => $purchaseOrder->id,  // Link to the purchase order
                    'item_description' => $row['item_description'],
                    'quantity' => $row['quantity'],
                    'material_unit_id' => $materialUnitId,  // Link to the material unit
                ]);
            }

            // Set a success message
            session()->flash('message', 'Material Inventory saved successfully!');

            // Reset form fields after successful save
            $this->reset(['purchaseOrderNo', 'purchaseRequisitionNo', 'rows']);
        
        } catch (\Exception $e) {
            // Handle any exceptions that might be thrown during the save process
            session()->flash('error', 'An error occurred while saving: ' . $e->getMessage());
        }
    }

    // Render the Livewire component
    public function render()
    {
        return view('livewire.shelter-material-inventory');
    }
}

// $query = Material::where(function($query) {
        //     $query->where('item_description', 'like', '%'.$this->search.'%')
        //         ->orWhere('quantity', 'like', '%'.$this->search.'%')
        //         ->orWhere('unit', 'like', '%'.$this->search.'%');
        // });

        // $query = Material::query();

        // // Apply search conditions if there is a search term
        // $query->when($this->search, function ($query) {
        //     return $query->where(function ($query) {
        //         $query->where('item_description', 'like', '%' . $this->search . '%')
        //             ->orWhere('quantity', 'like', '%' . $this->search . '%')
        //             ->orWhere('unit', 'like', '%' . $this->search . '%');
                    
        //     });
        // });