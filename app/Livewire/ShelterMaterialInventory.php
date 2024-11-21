<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\Shelter\Material;
use App\Models\Shelter\MaterialUnit;
use App\Models\Shelter\PurchaseOrder;
use App\Models\Shelter\PurchaseRequisition;
use App\Livewire\Logs\ActivityLogs;
use Illuminate\Support\Facades\Auth;

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

    public $materialGroups = []; // Keeps track of PR-PO combinations and their associated materials

    // Updated validation rules to ensure required fields
    protected $rules = [
        'purchaseOrderNo' => 'required|string|max:255',
        'purchaseRequisitionNo' => 'required|string|max:255',  // Validate the Purchase Requisition No
        'rows.*.item_description' => 'required|string|max:255',
        'rows.*.quantity' => 'required|numeric',
        'rows.*.unit' => 'required|string|max:255',
    ];

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

    public function save()
    {
        try {
            // Validate the input
            $this->validate();

            // Ensure the purchase order and requisition numbers have proper prefixes
            $this->purchaseOrderNo = str_starts_with($this->purchaseOrderNo, 'PO-') ? strtoupper($this->purchaseOrderNo) : 'PO-' . strtoupper($this->purchaseOrderNo);
            $this->purchaseRequisitionNo = str_starts_with($this->purchaseRequisitionNo, 'PR-') ? strtoupper($this->purchaseRequisitionNo) : 'PR-' . strtoupper($this->purchaseRequisitionNo);

            // Handle Purchase Requisition
            $purchaseRequisition = PurchaseRequisition::firstOrCreate(
                ['pr_number' => $this->purchaseRequisitionNo],
                ['pr_number' => $this->purchaseRequisitionNo]
            );

            // Handle Purchase Order
            $purchaseOrder = PurchaseOrder::firstOrCreate(
                ['po_number' => $this->purchaseOrderNo],
                [
                    'po_number' => $this->purchaseOrderNo,
                    'purchase_requisition_id' => $purchaseRequisition->id,
                ]
            );

            // Generate the PR-PO key
            $prPoKey = $this->generatePrPoKey($this->purchaseRequisitionNo, $this->purchaseOrderNo);

            // Create or update the PR-PO group in materialGroups
            if (!array_key_exists($prPoKey, $this->materialGroups)) {
                $this->materialGroups[$prPoKey] = [
                    'purchaseRequisitionNo' => $this->purchaseRequisitionNo,
                    'purchaseOrderNo' => $this->purchaseOrderNo,
                    'materials' => [],
                ];
            }

            // Loop through each row and save the material information
            foreach ($this->rows as $row) {
                $materialUnitId = $row['unit'];

                if (!$materialUnitId) {
                    session()->flash('error', 'Invalid material unit.');
                    return;
                }

                // Add the material to the group
                $this->materialGroups[$prPoKey]['materials'][] = $row;

                // Save the material in the database
                Material::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'item_description' => $row['item_description'],
                    'quantity' => $row['quantity'],
                    'material_unit_id' => $materialUnitId,
                ]);
            }

                            // Log the activity
            $logger = new ActivityLogs();
            $user = Auth::user();
            $logger->logActivity('Add New Sets of Materials', $user);

            // Set a success message
            session()->flash('message', 'Material Inventory saved successfully!');

            // Reset form fields after successful save
            $this->reset(['purchaseOrderNo', 'purchaseRequisitionNo', 'rows']);
        } catch (\Exception $e) {
            // Handle errors
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    // Add this method inside your ShelterMaterialInventory component
    private function generatePrPoKey($pr, $po)
    {
        return md5($pr . $po); // Create a unique key by hashing the PR and PO numbers
    }


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