<?php

namespace App\Livewire;

use App\Models\Awardee;
use App\Models\Barangay;
use App\Models\Blacklist;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\DependentsRelationship;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\LivingStatus;
use App\Models\Purok;
use App\Models\Religion;
use App\Models\RoofType;
use App\Models\TransactionType;
use App\Models\Tribe;
use App\Models\WallType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Livewire\Logs\ActivityLogs;

class AwardeeDetails extends Component
{
    public $isEditing = false, $isLoading = false;

    public $awardee, $taggedApplicant, $applicant;
    // Applicant information
    public $transaction_type_id, $transactionTypes, $first_name, $middle_name, $last_name, $suffix_name, $barangay_id, $purok_id, $full_address, $contact_number;
    public $puroks = [], $tribe, $sex, $date_of_birth, $religion, $occupation, $monthly_income, $family_income,
            $spouse_first_name, $spouse_middle_name, $spouse_last_name, $spouse_occupation, $spouse_monthly_income,
            $partner_first_name, $partner_middle_name, $partner_last_name, $partner_occupation, $partner_monthly_income;

    // Tagged applicant details
    public $civil_status_id, $civilStatuses, $date_applied, $tagging_date, $grant_date,
            $living_situation_id, $livingSituations, $living_status_id, $livingStatuses, $case_specification_id, $caseSpecifications, $living_situation_case_specification,
            $government_program_id, $governmentPrograms, $rent_fee, $landlord, $house_owner, $roof_type_id, $roofTypes, $wall_type_id, $wallTypes,
            $remarks;
    // Dependent's details
    public $dependents = [];
    public $images = [], $imagesForAwarding = [];
    public $dependent_relationship_id, $dependentRelationships;
    public $selectedImage = null; // This is for the tagging image
    public $selectedAttachment = null; // this is for the awarding attachment

    // For blacklisting
    public $openModalBlacklist = false, $showBlacklistConfirmationModal = false, $awardeeToBlacklist, $confirmationPassword = '', $blacklistError = '';
    // Track deleted dependents
    public $deletedDependentIds = [];

    // Blacklisting
    public $date_blacklisted, $blacklist_reason_description, $updated_by;

    public function mount($applicantId): void
    {
        $this->awardee = Awardee::with([
            'taggedAndValidatedApplicant.applicant.person',
            'taggedAndValidatedApplicant.applicant.transactionType',
            'taggedAndValidatedApplicant.civilStatus',
            'taggedAndValidatedApplicant.livingSituation',
            'taggedAndValidatedApplicant.caseSpecification',
            'taggedAndValidatedApplicant.governmentProgram',
            'taggedAndValidatedApplicant.livingStatus',
            'taggedAndValidatedApplicant.roofType',
            'taggedAndValidatedApplicant.wallType',
            'taggedAndValidatedApplicant.spouse',
            'taggedAndValidatedApplicant.liveInPartner',
            'taggedAndValidatedApplicant.dependents.dependentRelationship',
            'address.purok',
            'address.barangay',
            'relocationLot',
            'lotSizeUnit',
            'blacklist'
        ])->findOrFail($applicantId);

        $this->taggedApplicant = $this->awardee->taggedAndValidatedApplicant;
        $this->applicant = $this->taggedApplicant->applicant;
        // Blacklisting
        $this->date_blacklisted = now()->toDateString();
        $this->updated_by = Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name;
        $this->loadFormData();
    }
    public function loadFormData(): void
    {
        // Load Applicant Information
        $this->transaction_type_id = $this->applicant?->transactionType?->transaction_type_id ?? '--';
        $this->transactionTypes = TransactionType::all();
        $this->first_name = $this->applicant->person->first_name ?? '--';
        $this->middle_name = $this->applicant->person->middle_name ?? '--';
        $this->last_name = $this->applicant->person->last_name ?? '--';
        $this->suffix_name = $this->applicant->person->suffix_name ?? '--';
        $this->contact_number = $this->applicant?->person->contact_number ?? '--';
        $this->date_applied = optional($this->applicant?->date_applied)
            ->format('F d, Y') ?? '--';

        // Load Tagged and Validated Applicant Information
        $this->civil_status_id = $this->taggedApplicant?->civil_status_id ?? '--';
        $this->tribe = $this->taggedApplicant?->tribe ?? '--';
        $this->sex = $this->taggedApplicant?->sex ?? '--';
        $this->date_of_birth = optional($this->taggedApplicant?->date_of_birth)
            ->format('F d, Y') ?? '--';
        $this->religion = $this->taggedApplicant?->religion ?? '--';
        $this->occupation = $this->taggedApplicant?->occupation ?? '--';
        $this->monthly_income = $this->taggedApplicant?->monthly_income ?? '--';
        $this->family_income = $this->taggedApplicant?->family_income ?? '--';
        $this->tagging_date = optional($this->taggedApplicant?->tagging_date)
            ->format('F d, Y') ?? '--';

        // Load live-in partner information
        $this->partner_first_name = $this->taggedApplicant?->liveInPartner?->partner_first_name ?? '--';
        $this->partner_middle_name = $this->taggedApplicant?->liveInPartner?->partner_middle_name ?? '--';
        $this->partner_last_name = $this->taggedApplicant?->liveInPartner?->partner_last_name ?? '--';
        $this->partner_occupation = $this->taggedApplicant?->liveInPartner?->partner_occupation ?? '--';
        $this->partner_monthly_income = $this->taggedApplicant?->liveInPartner?->partner_monthly_income ?? '--';

        // Load spouse information
        $this->spouse_first_name = $this->taggedApplicant?->spouse?->spouse_first_name ?? '--';
        $this->spouse_middle_name = $this->taggedApplicant?->spouse?->spouse_middle_name ?? '--';
        $this->spouse_last_name = $this->taggedApplicant?->spouse?->spouse_last_name ?? '--';
        $this->spouse_occupation = $this->taggedApplicant?->spouse?->spouse_occupation ?? '--';
        $this->spouse_monthly_income = $this->taggedApplicant?->spouse?->spouse_monthly_income ?? '--';

        $this->grant_date = optional($this->awardee->grant_date)->format('F d, Y') ?? '--';

        // Convert the collection to an array when loading
        $this->dependents = $this->taggedApplicant->dependents->map(function($dependent) {
            return [
                'id' => $dependent->id,  // Make sure this is included
                'dependent_first_name' => $dependent->dependent_first_name,
                'dependent_middle_name' => $dependent->dependent_middle_name,
                'dependent_last_name' => $dependent->dependent_last_name,
                'dependent_sex' => $dependent->dependent_sex,
                'dependent_civil_status_id' => $dependent->dependent_civil_status_id,
                'dependent_date_of_birth' => $dependent->dependent_date_of_birth,
                'dependent_relationship_id' => $dependent->dependent_relationship_id,
                'dependent_occupation' => $dependent->dependent_occupation,
                'dependent_monthly_income' => $dependent->dependent_monthly_income,
            ];
        })->toArray();
        // Load civil statuses here
        $this->civilStatuses = CivilStatus::all();
        // Load civil statuses here
        $this->dependentRelationships = DependentsRelationship::all();
        // Load living situation
        $this->living_situation_id = $this->taggedApplicant?->living_situation_id ?? null;
        $this->livingSituations = LivingSituation::all();

        // Load case specification data
        if ($this->taggedApplicant?->living_situation_id == 8) {
            $this->case_specification_id = $this->taggedApplicant?->case_specification_id ?? null;
        } else {
            $this->living_situation_case_specification = $this->taggedApplicant?->living_situation_case_specification ?? '';
        }
        $this->caseSpecifications = CaseSpecification::all();

        // government programs
        $this->government_program_id = $this->taggedApplicant?->government_program_id ?? '--';
        $this->governmentPrograms = GovernmentProgram::all();

        $this->living_status_id = $this->taggedApplicant?->living_status_id ?? '--';
        $this->livingStatuses = LivingStatus::all();

        $this->roof_type_id = $this->taggedApplicant?->roof_type_id ?? '--';
        $this->roofTypes = RoofType::all();

        $this->wall_type_id = $this->taggedApplicant?->wall_type_id ?? '--';
        $this->wallTypes = WallType::all();

        $this->remarks = $this->taggedApplicant?->remarks ?? '--';

        if ($this->living_status_id == 1){
            // Renting
            $this->rent_fee = $this->taggedApplicant?->rent_fee ?? '--';
            $this->landlord = $this->taggedApplicant?->landlord ?? '--';
        } elseif ($this->living_status_id == 5){
            // Just staying in someone's house
            $this->house_owner = $this->taggedApplicant?->house_owner ?? '--';
        }

        // Load Address Information - Store IDs instead of names
        $this->barangay_id = $this->awardee->relocationLot?->address?->barangay?->name;
        $this->purok_id = $this->awardee->relocationLot?->address?->purok?->name;
        $this->full_address = $this->awardeerelocationLot?->address?->full_address ?? '--';
        // Load initial puroks if barangay is selected
        if ($this->barangay_id) {
            $this->puroks = Purok::where('barangay_id', $this->barangay_id)->get();
        }

        $this->images = $this->applicant->taggedAndValidated?->images ?? [];

        $this->imagesForAwarding = $this->applicant->taggedAndValidated?->awardees?->flatMap(function ($awardee) {
            return $awardee->taggedAndValidatedApplicant->documents()
                ->with('attachmentType') // Eager load the relationship
                ->get()
                ->map(function ($submission) {
//                    return $submission->file_name;
                    return [
//                        'file_name' => $submission->file_name,
                        'attachment_name' => $submission->attachmentType->attachment_name ?? $submission->file_name
                    ];
                })->filter();
        }) ?? collect();
    }
    // For Awarding pictures
    public function viewAttachment($fileName): void
    {
        $this->selectedAttachment = $fileName;
    }
    public function closeAttachment(): void
    {
        $this->selectedAttachment = null;
    }
    public function updatedBarangayId($barangayId): void
    {
        $this->isLoading = true;

        try {
            if ($barangayId){
                $this->puroks = Purok::where('barangay_id', $barangayId)->get();
            } else{
                $this->puroks = [];
            }
            $this->purok_id = null; // Reset selected puroks when barangay changes
        } catch (\Exception $e){
            logger()->error('Error fetching puroks', [
                'barangay_id' => $barangayId,
                'error' => $e->getMessage()
            ]);
        }
        $this->isLoading = false;
    }
    public function toggleEdit(): void
    {
        $this->isEditing = !$this->isEditing;
        if (!$this->isEditing) {
            $this->loadFormData(); // Reset form data if canceling edit
        }
    }
    public function proceedToConfirmation(): void
    {
        // Validate the first form
        $this->validate([
            'date_blacklisted' => 'required|date',
            'blacklist_reason_description' => 'required|string|max:255',
        ]);

        $this->openModalBlacklist = false;
        $this->showBlacklistConfirmationModal = true;
    }
    protected function rules()
    {
        return [
            'date_blacklisted' => 'required|date',
            'blacklist_reason_description' => 'required|string|max:255',
            'confirmationPassword' => 'required',
        ];
    }
    public function store()
    {
        // Validate the input data
        $this->validate();

        // Verify password first
        if (!Hash::check($this->confirmationPassword, Auth::user()->password)) {
            $this->blacklistError = 'Incorrect password. Please try again.';
            return;
        }

        // Create the new applicant record and get the ID of the newly created applicant
        $blacklist = Blacklist::create([
            'awardee_id' => $this->awardee->id,
            'user_id' => Auth::id(),
            'date_blacklisted' => $this->date_blacklisted,
            'blacklist_reason_description' => $this->blacklist_reason_description,
            'updated_by' => $this->updated_by,
        ]);

        $this->awardee->update([
            'is_blacklisted' => true
        ]);

        $logger = new ActivityLogs();
        $user = Auth::user();
        $logger->logActivity('Blacklisted an Awardee', $user);

        $this->resetForm();
        $this->openModalBlacklist = false;
        $this->showBlacklistConfirmationModal = false;

        // Trigger the alert message
        $this->dispatch('alert', [
            'title' => 'Awardee is now Blacklisted!',
            'message' => '<br><small>'. now()->calendar() .'</small>',
            'type' => 'success'
        ]);

        $this->redirect(route('awardee-details', ['applicantId' => $this->awardee->id]));
    }
    public function resetForm(): void
    {
        $this->reset([
            'date_blacklisted',
            'blacklist_reason_description',
            'updated_by',
            'confirmationPassword',
            'blacklistError',
            'openModalBlacklist',
            'showBlacklistConfirmationModal'
        ]);
    }
    public function confirmBlacklisting($awardeeId): void
    {
        $this->awardeeToBlacklist = $awardeeId;
        $this->confirmationPassword = '';
        $this->blacklistError = '';
        $this->showBlacklistConfirmationModal = true;
    }
    public function cancelBlacklisting(): void
    {
        $this->openModalBlacklist = false;
        $this->showBlacklistConfirmationModal = false;
        $this->awardeeToBlacklist = null;
        $this->confirmationPassword = '';
        $this->blacklistError = '';
    }
    public function render()
    {
        return view('livewire.awardee-details',[
            'barangays' => Barangay::all(),
            'tribes' => Tribe::all(),
            'religions' => Religion::all(),
            'showRentDetails' => $this->living_status_id == 1,
            'showHouseOwnerDetails' => $this->living_status_id == 5,
        ])->layout('layouts.app');
    }
}
