<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\RelocationSite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Logs\ActivityLogs;
use Livewire\WithPagination;

class RelocationSites extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $selectedSiteId, $password = '', $newStatus = '', $showPasswordModal = false;
    public $relocation_site_name = '';
    public $barangay_id;
    public $total_land_area = ''; // in hectares
    public $total_no_of_lots = ''; // in square meters
    public $total_lot_number_of_community_facilities = ''; // in square meters
    public $residential_lots = ''; // Computed fields

    // Edit mode fields
    public $editingRelocationSite;
    public $new_total_land_area;
    public $new_total_no_of_lots;
    public $new_total_lot_number_of_community_facilities;
    public $new_residential_lots;

    // UI state
    public $isModalOpen = false;
    public $showEditModal = false;
    public $isAwardeesModalVisible = false;
    public $selectedRelocationSite = null;
    public $barangays = [];

    // Search and filter
    public $search = '';
    public $filterBarangay = '';
    public $barangaysForFilter;

    protected $queryString = [
        'search' => ['except' => ''],
        'filterBarangay' => ['except' => '']
    ];

    protected $rules = [
        'relocation_site_name' => 'required|string|max:255|unique:relocation_sites,relocation_site_name',
        'barangay_id' => 'required|exists:barangays,id',
        'total_land_area' => 'required|numeric|min:0',
        'total_no_of_lots' => 'required|numeric|min:0',
        'total_lot_number_of_community_facilities' => 'required|numeric|min:0|lte:total_no_of_lots'
    ];

    protected $casts = [
        'total_land_area' => 'float', // not 'int'
        'total_no_of_lots' => 'float',
        'total_lot_number_of_community_facilities' => 'float',
    ];

    protected $messages = [
        'relocation_site_name.required' => 'Relocation site name is required.',
        'relocation_site_name.unique' => 'This relocation site name already exists.',
        'total_land_area.required' => 'Total land area is required.',
        'total_no_of_lots.required' => 'Total number of lots is required.',
        'total_lot_number_of_community_facilities.required' => 'Total lot number of community facilities is required.',
        'total_lot_number_of_community_facilities.lte' => 'Community facilities cannot exceed total number of lots.'
    ];

    public function mount(): void
    {
        $this->barangays = Barangay::all();
        $this->barangaysForFilter = Barangay::orderBy('name')->get();
    }

    // Computed property for residential lots
    public function updatedTotalNumberOfLots(): void
    {
        $this->calculateResidentialLots();
    }

    public function updatedTotalLotNumberOfCommunityFacilities(): void
    {
        $this->calculateResidentialLots();
    }

    private function calculateResidentialLots(): void
    {
        if ($this->total_no_of_lots && $this->total_lot_number_of_community_facilities) {
            $this->residential_lots = $this->total_no_of_lots - $this->total_lot_number_of_community_facilities;
        }
    }

    // Reset page on search update
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function getStatusBadgeClass($remainingSize, $totalSize): string
    {
        // If totalSize is 0 or null, treat as unavailable
        if ($totalSize <= 0) {
            return 'bg-gray-100 text-gray-800';
        }

        if ($remainingSize <= 0) {
            return 'bg-red-100 text-red-800';
        }

        $percentage = ($remainingSize / max(1, $totalSize)) * 100; // Use max to prevent division by zero
        if ($percentage <= 20) {
            return 'bg-orange-100 text-orange-800';
        }

        return 'bg-green-100 text-green-800';
    }

    public function getStatusText($remainingSize, $totalSize): string
    {
        // If totalSize is 0 or null, return unavailable
        if ($totalSize <= 0) {
            return 'UNAVAILABLE';
        }

        if ($remainingSize <= 0) {
            return 'FULL';
        }

        $percentage = ($remainingSize / max(1, $totalSize)) * 100; // Use max to prevent division by zero

        if ($percentage <= 20) {
            return 'ALMOST FULL';
        }
        return 'AVAILABLE';
    }
    public function createRelocationSite(): void
    {
        $this->validate();

        try {
            Log::info('Starting relocation site creation', [
                'form_data' => [
                    'barangay_id' => $this->barangay_id,
                    'relocation_site_name' => $this->relocation_site_name,
                    'total_land_area' => $this->total_land_area,
                    'total_no_of_lots' => $this->total_no_of_lots,
                    'total_lot_number_of_community_facilities' => $this->total_lot_number_of_community_facilities,
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

            // Create the relocation site
            try {
                $relocationSite = RelocationSite::create([
                    'relocation_site_name' => $this->relocation_site_name,
                    'barangay_id' => $this->barangay_id,
                    'total_land_area' => $this->total_land_area,
                    'total_no_of_lots' => $this->total_no_of_lots,
                    'community_facilities_road_lots_open_space' => $this->total_lot_number_of_community_facilities,
                    'is_full' => false
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
                'title' => 'Success!',
                'message' => 'Relocation site created successfully.<br><small>' . now()->calendar() . '</small>',
                'type' => 'success'
            ]);

            // Log the activity
            $logger = new ActivityLogs();
            $logger->logActivity('Created New Relocation Site', Auth::user());

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
                'title' => 'Error!',
                'message' => 'Failed to create relocation site.<br><small>' . now()->calendar() . '</small>',
                'type' => 'danger'
            ]);
        }
    }
    public function openEditModal($relocationSiteId): void
    {
        $this->editingRelocationSite = RelocationSite::with(['awardees', 'actualAwardees'])->find($relocationSiteId);

        // Initialize form fields with current values
        $this->new_total_land_area = $this->editingRelocationSite->total_land_area;
        $this->new_total_no_of_lots = $this->editingRelocationSite->total_no_of_lots;
        $this->new_total_lot_number_of_community_facilities = $this->editingRelocationSite->community_facilities_road_lots_open_space;

        $this->calculateNewResidentialLots();
        $this->showEditModal = true;
    }

    private function calculateNewResidentialLots(): void
    {
        if ($this->new_total_no_of_lots && $this->new_total_lot_number_of_community_facilities) {
            $this->new_residential_lots = $this->new_total_no_of_lots - $this->new_total_lot_number_of_community_facilities;
        }
    }

    public function updateRelocationSite(): void
    {
        $this->validate([
            'new_total_land_area' => 'required|numeric|min:0',
            'new_total_no_of_lots' => 'required|numeric|min:0',
            'new_total_lot_number_of_community_facilities' => [
                'required',
                'numeric',
                'min:0',
                'lte:new_total_no_of_lots',
                function ($attribute, $value, $fail) {
                    $residentialLots = $this->new_total_no_of_lots - $value;
                    $totalAllocatedSpace = $this->editingRelocationSite->awardees
                        ->sum(function ($awardee) {
                            return $awardee->actual_relocation_lot_size ?? $awardee->assigned_relocation_lot_size;
                        });

                    if ($residentialLots < $totalAllocatedSpace) {
                        $fail('New configuration would result in insufficient space for existing awardees.');
                    }
                },
            ]
        ]);

        try {
            DB::beginTransaction();

            $this->editingRelocationSite->update([
                'total_land_area' => $this->new_total_land_area,
                'total_no_of_lots' => $this->new_total_no_of_lots,
                'community_facilities_road_lots_open_space' => $this->new_total_lot_number_of_community_facilities
            ]);

            // Update the status
            $this->editingRelocationSite->updateFullStatus();

            DB::commit();

            $this->dispatch('alert', [
                'title' => 'Success!',
                'message' => 'Relocation site updated successfully.<br><small>' . now()->calendar() . '</small>',
                'type' => 'success'
            ]);

            // Log the activity
            $logger = new ActivityLogs();
            $logger->logActivity('Updated Relocation Site', Auth::user());

            $this->closeEditModal();

        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Error!',
                'message' => 'Failed to update relocation site.<br><small>' . now()->calendar() . '</small>',
                'type' => 'danger'
            ]);
        }
    }

    public function getAwardeesCount($relocationSiteId): array
    {
        $relocationSite = RelocationSite::find($relocationSiteId);

        return [
            'assigned' => $relocationSite->awardees()->count(),
            'actual' => $relocationSite->actualAwardees()->count()
        ];
    }

    public function getRemainingLotSize($relocationSiteId): float
    {
        $relocationSite = RelocationSite::with(['awardees', 'actualAwardees'])->find($relocationSiteId);

        if (!$relocationSite) {
            return 0;
        }

        $totalAvailableLots = $relocationSite->total_no_of_lots - $relocationSite->community_facilities_road_lots_open_space;

        // Calculate total allocated space based on actual or assigned lot sizes
        $totalAllocatedSpace = $relocationSite->awardees
            ->sum(function ($awardee) {
                // Use actual lot size if available, otherwise use assigned lot size
                return $awardee->actual_relocation_lot_size ?? $awardee->assigned_relocation_lot_size;
            });

        return $totalAvailableLots - $totalAllocatedSpace;
    }

    public function openAwardeesModal($relocationSiteId): void
    {
        $this->selectedRelocationSite = RelocationSite::with([
            'awardees.taggedAndValidatedApplicant.applicant.person',
            'actualAwardees'
        ])->findOrFail($relocationSiteId);
        $this->isAwardeesModalVisible = true;
    }

    public function closeAwardeesModal(): void
    {
        $this->isAwardeesModalVisible = false; // Updated property name
        $this->selectedRelocationSite = null;
    }

    public function render()
    {
        $query = RelocationSite::with(['barangay']);

        if ($this->search) {
            $searchTerms = preg_split('/\s+/', $this->search, -1, PREG_SPLIT_NO_EMPTY);

            $query->where(function ($query) use ($searchTerms) {
                // Match all terms against relocation_site_name
                foreach ($searchTerms as $term) {
                    $query->where('relocation_site_name', 'like', '%' . $term . '%');
                }

                // OR: match all terms against barangay name
                $query->orWhereHas('barangay', function ($subQuery) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $subQuery->where('name', 'like', '%' . $term . '%');
                    }
                });
            });
        }

        if ($this->filterBarangay) {
            $query->where('barangay_id', $this->filterBarangay);
        }

        $relocationSites = $query->orderBy('relocation_site_name', 'asc')
            ->paginate(5);

        return view('livewire.relocation-sites', [
            'relocationSites' => $relocationSites
        ]);
    }


    public function openModal(): void
    {
        $this->isModalOpen = true;
        $this->resetForm();
    }

    public function closeModal(): void
    {
        $this->isModalOpen = false;
        $this->resetForm();
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->reset(['editingRelocationSite', 'new_total_land_area', 'new_total_no_of_lots', 'new_total_lot_number_of_community_facilities']);
    }

    public function resetForm() {
        $this->reset([
            'relocation_site_name',
            'barangay_id',
            'total_land_area',
            'total_no_of_lots',
            'total_lot_number_of_community_facilities',
            'residential_lots'
        ]);
        $this->resetValidation();
    }
}
