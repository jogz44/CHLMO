<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\Material;
use App\Models\Shelter\MaterialUnit;
use App\Models\Shelter\ProfiledTaggedApplicant;
use App\Models\Shelter\DeliveredMaterial;
use App\Models\Shelter\ShelterUploadedFiles;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Logs\ActivityLogs;
use Livewire\WithFileUploads;

class GrantApplicant extends Component
{
    use WithFileUploads;
    public $profiledTaggedApplicantId;
    public $materialUnits = [];
    public $purchaseOrders = [];
    public $materialUnitId, $material_id, $purchaseOrderId;
    public $quantity, $available_quantity, $granteeId, $date_of_delivery, $date_of_ris, $ar_no;
    public $grantee_quantity = [];
    public $images = [];

    public $materialLists = [];
    public $materials = [
        ['material_id' => '', 'grantee_quantity' => '', 'material_unit_id' => '', 'purchase_order_id' => '', 'available_quantity' => '']
    ];

    public function mount()
    {
        // For Granting Modal
        $this->date_of_delivery = now()->toDateString(); // YYYY-MM-DD format
        $this->date_of_ris = now()->toDateString(); // YYYY-MM-DD format

        $this->materialUnits = MaterialUnit::all();
        $this->purchaseOrders = Material::all();
        $this->materialLists = Material::all();
    }

    public function findMaterialInfo($material_id)
    {
        $material = Material::with(['purchaseOrder', 'materialUnit', 'available_quantity'])->find($material_id);
        if ($material) {
            return [
                'material_unit_id' => $material->materialUnit?->unit ?? 'N/A',
                'purchase_order_id' => $material->purchaseOrder?->po_number ?? 'N/A',
                'available_quantity' => $material->available_quantity // 'available quantity' holds the available stock
            ];
        }
        return [];
    }


    public function updateMaterialInfo($index)
    {
        $material = Material::with(['purchaseOrder', 'materialUnit'])->find($this->materials[$index]['material_id']);

        if ($material) {
            // Store IDs for internal logic
            $this->materials[$index]['material_unit_id'] = $material->materialUnit?->id ?? null;
            $this->materials[$index]['purchase_order_id'] = $material->purchaseOrder?->id ?? null;

            // Store readable values for display
            $this->materials[$index]['materialUnitDisplay'] = $material->materialUnit?->unit ?? 'N/A';
            $this->materials[$index]['purchaseOrderDisplay'] = $material->purchaseOrder?->po_number ?? 'N/A';

            // Quantity is a straightforward value
            $this->materials[$index]['available_quantity'] = $material->available_quantity;
        } else {
            // Set defaults if material not found
            $this->materials[$index]['material_unit_id'] = null;
            $this->materials[$index]['purchase_order_id'] = null;
            $this->materials[$index]['materialUnitDisplay'] = 'N/A';
            $this->materials[$index]['purchaseOrderDisplay'] = 'N/A';
            $this->materials[$index]['available_quantity'] = 'N/A';
        }
    }

    public function selectMaterial($index, $material_id)
    {
        $this->materials[$index]['material_id'] = $material_id;

        // Call the existing method to update material info
        $this->updateMaterialInfo($index);
    }



    public function addMaterial()
    {
        $this->materials[] = ['material_id' => '', 'grantee_quantity' => '', 'material_unit_id' => '', 'purchase_order_id' => '', 'available_quantity' => ''];
    }

    public function removeMaterial($index)
    {
        unset($this->materials[$index]);
        $this->materials = array_values($this->materials); // reindex array
    }

    public function findpurchaseOrderId($material_id)
    {
        $material = Material::with('purchaseOrder')->find($material_id);
        return $material?->purchaseOrder?->po_number ?? 'N/A';
    }

    protected function rules(): array
    { // For Granting Modal
        return [
            'date_of_delivery' => 'required|date',
            'date_of_ris' => 'required|date',
            'ar_no' => 'required|numeric',
            'materials.*.material_id' => 'required|exists:materials,id',
            'grantee_quantity.*' => 'required|numeric|min:1',
            'materials.*.material_unit_id' => 'required|exists:material_units,id',
            'materials.*.purchase_order_id' => 'required|exists:purchase_orders,id'
            // 'photo.*' => 'required|image|max:2048'
        ];
    }

    public function grantApplicant()
    {
        $this->validate();
        DB::beginTransaction();

        try {
            // Create the grantee entry first
            $grantee = Grantee::updateOrCreate([
                'profiled_tagged_applicant_id' => $this->profiledTaggedApplicantId,
                'date_of_delivery' => $this->date_of_delivery,
                'date_of_ris' => $this->date_of_ris,
                'ar_no' => $this->ar_no,
                'is_granted' => true,
            ]);

            // Now loop over the materials to create DeliveredMaterial entries for this grantee
            foreach ($this->materials as $material) {
                // Check if there's enough stock available for the material
                $currentMaterial = Material::find($material['material_id']);
                if ($currentMaterial->available_quantity < $material['grantee_quantity']) {
                    throw new \Exception("Insufficient stock for material ID: {$material['material_id']}");
                }

                // Create the DeliveredMaterial record for each material
                DeliveredMaterial::create([
                    'grantee_id' => $grantee->id,
                    'material_id' => $material['material_id'],
                    'grantee_quantity' => $material['grantee_quantity'],
                ]);

                // Subtract the granted quantity from the available stock
                $currentMaterial->decrement('available_quantity', $material['grantee_quantity']);
            }

            // Retrieve the delivered materials for logging or debugging purposes
            $deliveredMaterials = $grantee->deliveredMaterials; // Will automatically load related delivered materials
            Log::info('Materials delivered to grantee', ['granteeId' => $grantee->id, 'deliveredMaterials' => $deliveredMaterials]);


            foreach ($this->images as $image) {
                $path = $image->storeAs('images', $image->getClientOriginalName(), 'public');
                ShelterUploadedFiles::create([
                    'grantee_id' => $grantee->id,
                    'image_path' => $path,
                    'display_name' => $image->getClientOriginalName(),
                ]);
            }

            Log::info('Grantee created successfully', ['granteeId' => $grantee->id]);

            Grantee::where('id', $this->granteeId)->update([
                'is_granted' => true
            ]);
            // $grantee->update(['is_granted' => true]);

            // Log the activity
            $logger = new ActivityLogs();
            $user = Auth::user();
            $logger->logActivity('Granted Shelter Applicant', $user);

            DB::commit();
            $this->resetForm();
            $this->dispatch('alert', [
                'title' => 'Granted!',
                'message' => 'The Applicant Successfuly Granted.',
                'type' => 'success',
            ]);

            return redirect()->route('shelter-profiled-tagged-applicants');
        } catch (QueryException $e) {
            DB::rollBack();
            $this->handleGrantingError($e);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing grant: ' . $e->getMessage());
            $this->dispatch('alert', [
                'title' => 'Insufficient Stock!',
                'message' => 'There was not enough stock to fulfill this request.',
                'type' => 'danger',
            ]);
        }
    }

    protected function handleGrantingError(QueryException $e)
    {
        $errorMessage = 'An error occurred while processing your request. Please try again later.';
        if ($e->getCode() === 23000) {
            $errorMessage = 'The information you provided conflicts with existing records. Please check your input and try again.';
        } elseif ($e->getCode() === 42000) {
            $errorMessage = 'There was a problem with the data you provided. Please check your input and try again.';
        }

        Log::error('Error creating grantee: ' . $e->getMessage());
        $this->dispatch('alert', [
            'title' => 'Something went wrong!',
            'message' => $errorMessage . ' <br><small>' . now()->calendar() . '</small>',
            'type' => 'danger',
        ]);
    }

    public function resetForm(): void
    {
        $this->reset([
            'material_id',
            'materialUnitId',
            'purchaseOrderId',
            'date_of_delivery',
            'date_of_ris',
            'ar_no',
            'grantee_quantity',
            'images',
        ]);
    }

    public function searchMaterials($query)
    {
        if (empty($query)) {
            return [];
        }

        $materials = Material::with('purchaseOrder')
        ->where('item_description', 'like', "%$query%")
        ->get()
        ->map(function ($material) {
            $material->purchaseOrderDisplay = $material->purchaseOrder->po_number ?? 'Not available';
            return $material;
        });

    return $materials;
    }

    public function updatedPhoto()
    {
        Log::info('Photo uploaded:', $this->images);
        // Validate the uploaded images immediately after selection
        $this->validateOnly('images');
    }

    public  function removeUpload($property, $fileName, $load): void
    {
        $filePath = storage_path('livewire-tmp/' . $fileName);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $load('');
    }

    public function render()
    {
        return view('livewire.grant-applicant')
        ->layout('layouts.adminshelter');
    }
}
