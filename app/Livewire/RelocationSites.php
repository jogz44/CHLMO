<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\RelocationSite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RelocationSites extends Component
{
    public $selectedSiteId, $password = '', $newStatus = '', $showPasswordModal = false;
    public  $lot_number, $block_identifier, $relocation_site_name = '';
    public $barangay_id, $barangays = [], $purok_id, $puroks = [];
    public $total_lot_size;
    public $isModalOpen = false, $isLoading = false;
    // To edit relocation site
    public $showEditModal = false, $editingRelocationSite, $currentId, $newTotalLotSize;

    protected $rules = [
        'lot_number' => 'nullable|string|max:255',
        'block_identifier' => 'nullable|string|max:255',
        'relocation_site_name' => 'required|string|max:255|unique:relocation_sites,relocation_site_name',
        'barangay_id' => 'required|exists:barangays,id',
        'purok_id' => 'required|exists:puroks,id',
        'total_lot_size' => 'required|numeric|min:0',
    ];
    protected $messages = [
        'relocation_site_name.required' => 'Relocation site name is required.',
        'relocation_site_name.unique' => 'This relocation site name already exists.',
    ];
    public function openModal()
    {
        $this->isModalOpen = true;
        $this->resetForm();
    }
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetForm();
    }
    public function resetForm()
    {
        $this->reset(['lot_number', 'block_identifier', 'relocation_site_name', 'barangay_id', 'purok_id', 'total_lot_size']);
        $this->resetValidation();
    }
    public function mount()
    {
        $this->barangays = Barangay::all();
        $this->puroks = Purok::all();

//        $this->reset();
    }
    public function updatedBarangayId($barangayId): void
    {
        // Fetch the puroks based on the selected barangay
        $this->puroks = Purok::where('barangay_id', $barangayId)->get();
        $this->purok_id = null; // Reset selected purok when barangay changes
        $this->isLoading = false; // Reset loading state
        logger()->info('Retrieved Puroks', [
            'barangay_id' => $barangayId,
            'puroks' => $this->puroks
        ]);
    }
    public function getRemainingLotSize($relocationSiteId)
    {
        $relocationSite = RelocationSite::with('awardees')->find($relocationSiteId);

        if (!$relocationSite) {
            return 'N/A';
        }

        // Sum up the lot sizes of all awarded applicants for this relocation site
        $allocatedLotSize = $relocationSite->awardees->sum('lot_size');

        // Calculate the remaining lot size
        return $relocationSite->total_lot_size - $allocatedLotSize;
    }
    public function getStatusBadgeClass($remainingSize, $totalSize): string
    {
        $percentage = ($remainingSize / $totalSize) * 100;

        if ($remainingSize <= 0) {
            return 'bg-red-100 text-red-800';
        } elseif ($percentage <= 20) {
            return 'bg-orange-100 text-orange-800';
        }
        return 'bg-green-100 text-green-800';
    }
    public function getStatusText($remainingSize, $totalSize): string
    {
        $percentage = ($remainingSize / $totalSize) * 100;

        if ($remainingSize <= 0) {
            return 'FULL';
        } elseif ($percentage <= 20) {
            return 'ALMOST FULL';
        }
        return 'AVAILABLE';
    }
    public function createRelocationSite(): void
    {
        try {
            Log::info('Starting relocation site creation', [
                'form_data' => [
                    'barangay_id' => $this->barangay_id,
                    'purok_id' => $this->purok_id,
                    'lot_number' => $this->lot_number,
                    'block_identifier' => $this->block_identifier,
                    'relocation_site_name' => $this->relocation_site_name,
                    'total_lot_size' => $this->total_lot_size,
                ]
            ]);

            // Validate the input
            try {
                $this->validate();
                Log::info('Validation passed successfully');
            } catch (\Illuminate\Validation\ValidationException $e) {
                Log::error('Validation failed', [
                    'errors' => $e->errors(),
                    'message' => $e->getMessage()
                ]);
                throw $e;
            }

            // Create the address entry first
            try {
                $address = Address::create([
                    'barangay_id' => $this->barangay_id,
                    'purok_id' => $this->purok_id,
                ]);
                Log::info('Address created successfully', ['address' => $address->toArray()]);
            } catch (\Exception $e) {
                Log::error('Failed to create address', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }

            // Create the relocation site
            try {
                $relocationSite = RelocationSite::create([
                    'lot_number' => $this->lot_number,
                    'block_identifier' => $this->block_identifier,
                    'relocation_site_name' => $this->relocation_site_name,
                    'address_id' => $address->id,
                    'total_lot_size' => $this->total_lot_size,
                    'is_full' => false,
                ]);
                Log::info('Relocation site created successfully', ['site' => $relocationSite->toArray()]);
            } catch (\Exception $e) {
                Log::error('Failed to create relocation site', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }

            // Show success message
            $this->dispatch('alert', [
                'title' => 'Relocation site added successfully!',
                'message' => '<br><small>'. now()->calendar() .'</small>',
                'type' => 'success'
            ]);

            Log::info('Relocation site creation completed successfully');

            // Close modal and reset form
            $this->closeModal();
            $this->redirect('relocation-sites');

        } catch (\Exception $e) {
            Log::error('Unhandled exception in createRelocationSite', [
                'error' => $e->getMessage(),
                'class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->dispatch('alert', [
                'title' => 'Error creating relocation site.',
                'message' => '<br><small>'. now()->calendar() .'</small>',
                'type' => 'danger'
            ]);
        }
    }
    public function openEditModal($relocationSiteId)
    {
        $this->editingRelocationSite = RelocationSite::find($relocationSiteId);
        $this->newTotalLotSize = $this->editingRelocationSite->total_lot_size;
        $this->showEditModal = true;
    }
    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset('editingRelocationSite', 'newTotalLotSize');
    }
    public function updateTotalSize()
    {
        $this->validate([
            'newTotalLotSize' => 'required|numeric|min:0'
        ]);

        try {
            // Check if new size is less than currently allocated
            $totalAllocated = $this->editingRelocationSite->awardees()->sum('lot_size');
            if ($this->newTotalLotSize < $totalAllocated) {
                $this->addError('newTotalLotSize', "New size cannot be less than currently allocated size ($totalAllocated m²)");
                return;
            }

            $this->editingRelocationSite->update([
                'total_lot_size' => $this->newTotalLotSize,
                'is_full' => ($this->newTotalLotSize - $totalAllocated) <= 0
            ]);

            $this->dispatch('alert', [
                'title' => 'Success!',
                'message' => 'Total lot size updated successfully.<br><small>' . now()->calendar() . '</small>',
                'type' => 'success'
            ]);

            $this->closeEditModal();

        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Error!',
                'message' => 'Failed to update total lot size.<br><small>' . now()->calendar() . '</small>',
                'type' => 'danger'
            ]);
        }
    }
    public function render()
    {
        $relocationSites = RelocationSite::with('address')
            ->orderBy('relocation_site_name')
            ->paginate(5);

        return view('livewire.relocation-sites', [
            'relocationSites' => $relocationSites
        ]);
    }
}
