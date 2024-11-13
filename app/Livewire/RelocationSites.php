<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\RelocationSite;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RelocationSites extends Component
{
    public $selectedSiteId, $password = '', $newStatus = '', $showPasswordModal = false;
    public $relocation_site_name = '';
    public $barangay_id, $barangays = [], $purok_id, $puroks = [];
    public $total_lot_size;
    public $isModalOpen = false, $isLoading = false;

    protected $rules = [
        'relocation_site_name' => 'required|string|max:255|unique:relocation_sites,relocation_site_name',
        'barangay_id' => 'required|exists:barangays,id',
        'purok_id' => 'required|exists:puroks,id',
        'total_lot_size' => 'required|integer|min:0',
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
        $this->reset(['relocation_site_name', 'barangay_id', 'purok_id', 'total_lot_size']);
        $this->resetValidation();
    }
    public function mount()
    {
        $this->barangays = Barangay::all();
        $this->puroks = Purok::all();
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
    public function initiateStatusChange($siteId, $status)
    {
        $this->selectedSiteId = $siteId;
        $this->newStatus = $status;
        $this->showPasswordModal = true;
        $this->password = '';
        $this->resetValidation();
    }
    // For status update validation (separate method)
    protected function statusUpdateRules(): array
    {
        return [
            'password' => 'required|min:6',
            'newStatus' => 'required|in:vacant,full'
        ];
    }
    public function updateStatus()
    {
        // Validate password and status
        $this->validate($this->statusUpdateRules());

        try {
            // Verify password
            if (!Hash::check($this->password, auth()->user()->password)) {
                $this->addError('password', 'Invalid password');
                return;
            }

            // Update status
            RelocationSite::where('id', $this->selectedSiteId)
                ->update(['status' => $this->newStatus]);

            // Reset and close modal
            $this->showPasswordModal = false;
            $this->password = '';
            $this->selectedSiteId = null;
            $this->newStatus = '';

            session()->flash('success', 'Status updated successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Error updating status: ' . $e->getMessage());
        }
    }
    public function closePasswordModal()
    {
        $this->showPasswordModal = false;
        $this->password = '';
        $this->selectedSiteId = null;
        $this->newStatus = '';
        $this->resetValidation();
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
    public function createRelocationSite(): void
    {
        try {
            // Validate the input
            $this->validate();

            // Create the address entry first
            $address = Address::create([
                'barangay_id' => $this->barangay_id,
                'purok_id' => $this->purok_id,
            ]);

            // Create the relocation site
            RelocationSite::create([
                'relocation_site_name' => $this->relocation_site_name,
                'address_id' => $address->id,
                'total_lot_size' => $this->total_lot_size,
                'is_full' => false,
            ]);

            // Show success message
            $this->dispatch('alert', [
                'title' => 'Relocation site added successfully!',
                'message' => '<br><small>'. now()->calendar() .'</small>',
                'type' => 'success'
            ]);

            // Close modal and reset form
            $this->closeModal();

            $this->redirect('relocation-sites');

        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Error creating relocation site.',
                'message' => '<br><small>'. now()->calendar() .'</small>',
                'type' => 'danger'
            ]);
        }
    }
    public function render()
    {
        $relocationSites = RelocationSite::with('address')
            ->orderBy('relocation_site_name')
            ->paginate(10);

        return view('livewire.relocation-sites', [
            'relocationSites' => $relocationSites
        ]);
    }
}
