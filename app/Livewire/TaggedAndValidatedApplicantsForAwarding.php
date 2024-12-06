<?php

namespace App\Livewire;

use App\Models\Awardee;
use App\Models\Barangay;
use App\Models\CaseSpecification;
use App\Models\LivingSituation;
use App\Models\Purok;
use App\Models\RelocationSite;
use App\Models\TaggedAndValidatedApplicant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Livewire\Logs\ActivityLogs;
use Illuminate\Support\Facades\Auth;



class TaggedAndValidatedApplicantsForAwarding extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $isLoading = false;
    public $tagging_date, $transaction_type;

    // Filter properties:
    public $applicantId;
    public $startTaggingDate, $endTaggingDate, $selectedTaggingStatus;
    public $selectedPurok_id, $puroksFilter = [], $selectedBarangay_id, $barangaysFilter = [], $selectedLivingSituation_id,
        $livingSituationsFilter = [], $selectedCaseSpecification_id, $caseSpecificationsFilter = [];
    public $taggingStatuses;

    // Tagged and validated applicant details
    public $first_name, $middle_name, $last_name, $suffix_name, $barangay, $purok, $living_situation, $contact_number,
        $occupation, $monthly_income;

    // For assigning relocation site
    public $assigned_relocation_site_id,
        $assignedRelocationSites = [];

    // For awarding modal
    public $grant_date,
        $taggedAndValidatedApplicantId,
        $actual_relocation_site_id,
        $actualRelocationSites = [],
        $lot_size,
        $unit = 'm²';

    public $taggedAndValidatedApplicant;

    public function updatingSearch(): void
    {
        // This ensures that the search query is updated dynamically as the user types
        $this->resetPage();
    }
    public function clearSearch(): void
    {
        $this->search = ''; // Clear the search input
    }
    public function resetFilters(): void
    {
        $this->startTaggingDate = null;
        $this->endTaggingDate = null;
        $this->selectedPurok_id = null;
        $this->selectedBarangay_id = null;
        $this->selectedLivingSituation_id = null;
        $this->selectedCaseSpecification_id = null;
        $this->selectedTaggingStatus = null;

        // Reset pagination and any search terms
        $this->resetPage();
        $this->search = '';
    }

    public function mount(): void
    {
        $this->tagging_date = now()->toDateString();
        $this->unit = "m²";

        // Initialize filter options
        $this->puroksFilter = Cache::remember('puroks', 60*60, function() {
            return Purok::all();
        });
        $this->barangaysFilter = Cache::remember('barangays', 60*60, function() {
            return Barangay::all();
        });
        $this->livingSituationsFilter = Cache::remember('living_situations', 60*60, function() {
            return LivingSituation::all();
        });
        $this->caseSpecificationsFilter = Cache::remember('case_specifications', 60*60, function() {
            return CaseSpecification::all();
        });
        $this->taggingStatuses = ['Award Pending', 'Awarded']; // Add your statuses here

        // For Awarding Modal

        // Set today's date as the default value for date_applied
        $this->grant_date = now()->toDateString(); // YYYY-MM-DD format

        // Initialize dropdowns
        $this->assignedRelocationSites = RelocationSite::all(); // Fetch all relocation sites
        $this->actualRelocationSites = RelocationSite::all(); // Fetch all relocation sites
    }
    public function updatingBarangay(): void
    {
        $this->resetPage();
    }
    public function updatingPurok(): void
    {
        $this->resetPage();
    }
    public function updatedSelectedBarangayId($barangayId): void
    {
        // Fetch the puroks based on the selected barangay
        $this->puroksFilter = Purok::where('barangay_id', $barangayId)->get();
        $this->selectedPurok_id = null; // Reset selected purok when barangay changes
        $this->isLoading = false; // Reset loading state
        logger()->info('Retrieved Puroks', [
            'selectedBarangay_id' => $barangayId,
            'puroksFilter' => $this->puroksFilter
        ]);
    }
    protected function rules(): array
    {
        return [
            'letterOfIntent' => 'required|file|max:10240',
            'votersID' => 'required|file|max:10240',
            'validID' => 'required|file|max:10240',
            'certOfNoLandHolding' => 'required|file|max:10240',
            'marriageCert' => 'nullable|file|max:10240',
            'birthCert' => 'required|file|max:10240',
        ];
    }
    public function awardApplicant(): void
    {
        DB::beginTransaction();
        try {
            // Validate the input data
            $this->validate([
                'grant_date' => 'required|date',
                'actual_relocation_site_id' => 'required|exists:relocation_sites,id',
                'lot_size' => 'required|numeric',
                'unit' => 'in:m²',
            ]);

            // Verify documents exist
            $applicant = TaggedAndValidatedApplicant::findOrFail($this->taggedAndValidatedApplicantId);
            if (!$applicant->documents->count()) {
                throw new \Exception('Documents must be submitted before awarding.');
            }

            // Check if there's enough space available
            $relocationSite = RelocationSite::find($this->relocation_lot_id);
            $remainingSize = $relocationSite->getRemainingLotSize();

            if ($remainingSize < $this->lot_size) {
                throw new \Exception('Insufficient lot size available. Only ' . number_format($remainingSize, 2) . ' ' . $this->unit . ' remaining.');
            }

            // Create awardee record
            $awardee = Awardee::create([
                'tagged_and_validated_applicant_id' => $this->taggedAndValidatedApplicantId,
                'actual_relocation_site_id' => $this->actual_relocation_site_id,
                'lot_size' => $this->lot_size,
                'unit' => $this->unit,
                'grant_date' => $this->grant_date,
                'documents_submitted' => false,
                'is_awarded' => true,
                'is_blacklisted' => false,
            ]);

            // Update applicant status
            $applicant->update([
                'is_awarding_on_going' => true,
            ]);

            // Log the activity
            $logger = new ActivityLogs();
            $user = Auth::user();
            $logger->logActivity('Awarded an Applicant', $user);

            // Update relocation site status
            $relocationSite->updateFullStatus();

            DB::commit();

            $this->dispatch('alert', [
                'title' => 'Award Complete!',
                'message' => 'Applicant has been successfully awarded. <br><small>'. now()->calendar() .'</small>',
                'type' => 'success'
            ]);

            $this->redirect('transaction-request');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('alert', [
                'title' => 'Failed to complete award process',
                'message' => $e->getMessage() . '<br><small>'. now()->calendar() .'</small>',
                'type' => 'danger'
            ]);
        }
    }
    public function resetForm(): void
    {
        $this->reset([
            'actual_relocation_site_id', 'lot_size', 'grant_date',
        ]);
    }

    private function handleError(string $message, \Exception $e = null): void
    {
        if ($e) {
            logger()->error($message, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        $this->dispatch('alert', [
            'title' => 'Error',
            'message' => $message,
            'type' => 'error'
        ]);
    }

    public function viewApplicantDetails($applicantId): RedirectResponse
    {
        return redirect()->route('tagged-and-validated-applicant-details', ['applicantId' => $applicantId]);
    }

    public function render()
    {
        $query = TaggedAndValidatedApplicant::with([
            'applicant.person',
            'applicant.address.purok',
            'applicant.address.barangay',
            'livingSituation',
            'caseSpecification',
            'awardees'
        ]);

        // Apply search filter
        if ($this->search) {
            $query->whereHas('applicant', function($q) {
                $q->where('applicant_id', 'like', '%'.$this->search.'%')
                    ->orWhereHas('person', function($personQuery) {
                        $personQuery->where('first_name', 'like', '%'.$this->search.'%')
                            ->orWhere('middle_name', 'like', '%'.$this->search.'%')
                            ->orWhere('last_name', 'like', '%'.$this->search.'%')
                            ->orWhere('suffix_name', 'like', '%'.$this->search.'%')
                            ->orWhere('contact_number', 'like', '%'.$this->search.'%');
                    })
                    ->orWhereHas('address.purok', function ($subQuery) {
                        $subQuery->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->orWhereHas('address.barangay', function ($subQuery) {
                        $subQuery->where('name', 'like', '%'.$this->search.'%');
                    });
            })->orWhereHas('livingSituation', function($q) {
                $q->where('living_situation_description', 'like', '%' . $this->search . '%');
            })->orWhereHas('caseSpecification', function($q) {
                $q->where('case_specification_name', 'like', '%' . $this->search . '%');
            })->orWhere('living_situation_case_specification', 'like', '%'.$this->search.'%');
        }

        // Apply date range filter (if both dates are present)
        if ($this->startTaggingDate && $this->endTaggingDate) {
            $query->whereBetween('tagging_date', [$this->startTaggingDate, $this->endTaggingDate]);
        }

        // Additional filters
        if ($this->selectedPurok_id) {
            $query->whereHas('applicant.address', function ($q) {
                $q->where('purok_id', $this->selectedPurok_id);
            });
        }

        if ($this->selectedBarangay_id) {
            $query->whereHas('applicant.address', function ($q) {
                $q->where('barangay_id', $this->selectedBarangay_id);
            });
        }

        if ($this->selectedLivingSituation_id) {
            $query->whereHas('livingSituation', function ($q) {
                $q->where('living_situation_id', $this->selectedLivingSituation_id);
            });
        }

        if ($this->selectedCaseSpecification_id) {
            $query->where(function($q) {
                $q->where('case_specification_id', $this->selectedCaseSpecification_id)
                    ->orWhere('living_situation_case_specification', $this->selectedCaseSpecification_id)
                    ->orWhere('non_informal_settler_case_specification', $this->selectedCaseSpecification_id);
            });
        }

        if ($this->selectedTaggingStatus !== null) {
            $query->where('is_awarding_on_going', $this->selectedTaggingStatus === 'Awarded');
        }

        // Paginate the filtered results
        $taggedAndValidatedApplicants = $query->orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.tagged_and_validated_applicants_for_awarding', [
            'taggedAndValidatedApplicants' => $taggedAndValidatedApplicants,
            'puroks' => $this->puroksFilter,
            'barangays' => $this->barangaysFilter,
            'livingSituations' => $this->livingSituationsFilter,
            'caseSpecifications' => $this->caseSpecificationsFilter,  // Add this
            'taggingStatuses' => $this->taggingStatuses,
        ]);
    }
}
