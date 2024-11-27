<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\Dependent;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\LivingStatus;
use App\Models\Purok;
use App\Models\Religion;
use App\Models\RoofType;
use App\Models\TaggedAndValidatedApplicant;
use App\Models\TransactionType;
use App\Models\Tribe;
use App\Models\WallType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class TaggedAndValidatedApplicantDetails extends Component
{
    public $applicant;
    public $taggedAndValidatedApplicant;
    public $isEditing = false, $isLoading = false;

    public $applicantForSpouse;
    public $transaction_type_id, $transactionTypes, $transaction_type_name;
    public $first_name, $middle_name, $last_name, $suffix_name, $contact_number, $barangay_id, $barangays, $purok_id, $puroks,
            $date_applied;

    // New fields
    public $full_address, $civil_status_id, $civilStatuses, $religion, $tribe;
    public $living_situation_id, $livingSituations, $case_specification_id, $caseSpecifications, $living_situation_case_specification,
        $government_program_id, $governmentPrograms, $living_status_id, $livingStatuses, $roof_type_id, $roofTypes, $wall_type_id,
        $wallTypes, $sex, $date_of_birth, $occupation, $monthly_income, $family_income, $tagging_date, $rent_fee, $landlord,
        $house_owner, $tagger_name, $remarks;

    // Live-in partner's details
    public $partner_first_name, $partner_middle_name, $partner_last_name, $partner_occupation, $partner_monthly_income;
    // Spouse's details
    public $spouse_first_name, $spouse_middle_name, $spouse_last_name, $spouse_occupation, $spouse_monthly_income;

    // Dependent's details
    public $dependents = [], $dependent_civil_status_id, $dependent_civilStatuses, $renamedFileName = [];
    public $showDeleteConfirmationModal = false, $dependentToDelete, $confirmationPassword = '', $deleteError = '';
    public $images = [], $imagesForTagging = [];
    public $selectedImage = null; // This is for the tagging image
    public $selectedAttachment = null; // this is for the awarding attachment

    public $taggedDocuments = [];
    public $selectedDocument = null;

    public function mount($applicantId): void
    {
        $this->taggedAndValidatedApplicant = TaggedAndValidatedApplicant::with([
            'applicant.person',
            'applicant.address.purok',
            'applicant.address.barangay',
            'applicant.transactionType',
            'livingSituation',
            'caseSpecification',
            'governmentProgram',
            'livingStatus',
            'civilStatus',
            'liveInPartner',
            'spouse',
            'roofType',
            'wallType',
            'taggedDocuments'
        ])->findOrFail($applicantId);

        $this->taggedDocuments = $this->taggedAndValidatedApplicant->taggedDocuments;

        $this->loadFormData();
    }
    public function loadFormData(): void
    {
        $this->civilStatuses = Cache::remember('civil_statuses', 60*60, function() {
            return CivilStatus::all();  // Cache for 1 hour
        });
        // For Dependents
        $this->dependent_civilStatuses = Cache::remember('civil_statuses', 60*60, function() {
            return CivilStatus::all();  // Cache for 1 hour
        });
        $this->livingSituations = Cache::remember('livingSituations', 60*60, function() {
            return LivingSituation::all();  // Cache for 1 hour
        });
        $this->caseSpecifications = Cache::remember('caseSpecifications', 60*60, function() {
            return CaseSpecification::all();  // Cache for 1 hour
        });
        $this->governmentPrograms = Cache::remember('governmentPrograms', 60*60, function() {
            return GovernmentProgram::all();  // Cache for 1 hour
        });
        $this->livingStatuses = Cache::remember('livingStatuses', 60*60, function() {
            return LivingStatus::all();  // Cache for 1 hour
        });
        $this->roofTypes = Cache::remember('roofTypes', 60*60, function() {
            return RoofType::all();  // Cache for 1 hour
        });
        $this->wallTypes = Cache::remember('wallTypes', 60*60, function() {
            return WallType::all();  // Cache for 1 hour
        });

        // Applicant basic information
        $this->first_name = $this->taggedAndValidatedApplicant->applicant->person->first_name ?? null;
        $this->transactionTypes = TransactionType::all();
        $this->middle_name = $this->taggedAndValidatedApplicant->applicant->person->middle_name ?? null;
        $this->last_name = $this->taggedAndValidatedApplicant->applicant->person->last_name ?? null;
        $this->suffix_name = $this->taggedAndValidatedApplicant->applicant->person->suffix_name ?? null;
        $this->contact_number = $this->taggedAndValidatedApplicant->applicant->person->contact_number ?? null;
        $this->transaction_type_id = $this->taggedAndValidatedApplicant?->applicant->transactionType?->transaction_type_id ?? null;
        $this->date_applied = optional($this->taggedAndValidatedApplicant->applicant->date_applied)
            ->format('F d, Y') ?? null;
        // Load Address Information - Store IDs instead of names
        $this->barangay_id = $this->taggedAndValidatedApplicant->applicant?->address?->barangay?->id;
        $this->purok_id = $this->taggedAndValidatedApplicant->applicant?->address?->purok?->id;
        $this->full_address = $this->taggedAndValidatedApplicant->full_address ?? null;
        $this->occupation = $this->taggedAndValidatedApplicant->occupation ?? null;
        $this->tribe = $this->taggedAndValidatedApplicant->tribe ?? null;
        $this->religion = $this->taggedAndValidatedApplicant->religion ?? null;
        $this->monthly_income = $this->taggedAndValidatedApplicant->monthly_income ?? null;
        // Load initial puroks if barangay is selected
        if ($this->barangay_id) {
            $this->puroks = Purok::where('barangay_id', $this->barangay_id)->get();
        }
        $this->civil_status_id = $this->taggedAndValidatedApplicant?->civilStatus?->civil_status_id ?? null;
        // Live in partner details
        $this->partner_first_name = $this->taggedAndValidatedApplicant->liveInPartner->partner_first_name ?? null;
        $this->partner_middle_name = $this->taggedAndValidatedApplicant->liveInPartner->partner_middle_name ?? null;
        $this->partner_last_name = $this->taggedAndValidatedApplicant->liveInPartner->partner_last_name ?? null;
        $this->partner_occupation = $this->taggedAndValidatedApplicant->liveInPartner->partner_occupation ?? null;
        $this->partner_monthly_income = $this->taggedAndValidatedApplicant->liveInPartner->partner_monthly_income ?? null;
        // spouse details
        $this->spouse_first_name = $this->taggedAndValidatedApplicant->spouse->spouse_first_name ?? null;
        $this->spouse_middle_name = $this->taggedAndValidatedApplicant->spouse->spouse_middle_name ?? null;
        $this->spouse_last_name = $this->taggedAndValidatedApplicant->spouse->spouse_last_name ?? null;
        $this->spouse_occupation = $this->taggedAndValidatedApplicant->spouse->spouse_occupation ?? null;
        $this->spouse_monthly_income = $this->taggedAndValidatedApplicant->spouse->spouse_monthly_income ?? null;
        // Dependents' details
        $this->dependents = $this->taggedAndValidatedApplicant->dependents->map(function($dependent) {
            return [
                'id' => $dependent->id,  // Make sure this is included
                'dependent_first_name' => $dependent->dependent_first_name,
                'dependent_middle_name' => $dependent->dependent_middle_name,
                'dependent_last_name' => $dependent->dependent_last_name,
                'dependent_sex' => $dependent->dependent_sex,
                'dependent_civil_status_id' => $dependent->dependent_civil_status_id,
                'dependent_date_of_birth' => $dependent->dependent_date_of_birth,
                'dependent_relationship' => $dependent->dependentRelationship->relationship,
                'dependent_occupation' => $dependent->dependent_occupation,
                'dependent_monthly_income' => $dependent->dependent_monthly_income,
            ];
        })->toArray();
        $this->tagging_date = optional($this->taggedAndValidatedApplicant->tagging_date)
            ->format('F d, Y') ?? null;
        $this->living_situation_id = $this->taggedAndValidatedApplicant?->livingSituation?->living_situation_id ?? null;
        $this->livingSituations = LivingSituation::all();
        // Load case specification data
        if ($this->taggedAndValidatedApplicant?->livingSituation?->living_situation_id == 8) {
            $this->case_specification_id = $this->taggedAndValidatedApplicant?->caseSpecification?->case_specification_id ?? null;
        } else {
            $this->living_situation_case_specification = $this->taggedAndValidatedApplicant?->living_situation_case_specification ?? '';
        }
        $this->caseSpecifications = CaseSpecification::all();

        // government programs
        $this->government_program_id = $this->taggedAndValidatedApplicant?->governmentProgram->government_program_id ?? null;
        $this->governmentPrograms = GovernmentProgram::all();

        $this->living_status_id = $this->taggedAndValidatedApplicant?->living_status_id ?? null;
        $this->livingStatuses = LivingStatus::all();
        if ($this->living_status_id == 1){
            // Renting
            $this->rent_fee = $this->taggedAndValidatedApplicant?->rent_fee ?? null;
            $this->landlord = $this->taggedAndValidatedApplicant?->landlord ?? null;
        } elseif ($this->living_status_id == 5){
            // Just staying in someone's house
            $this->house_owner = $this->taggedAndValidatedApplicant?->house_owner ?? null;
        }

        $this->roof_type_id = $this->taggedAndValidatedApplicant?->roofType?->roof_type_id ?? null;
        $this->roofTypes = RoofType::all();

        $this->wall_type_id = $this->taggedAndValidatedApplicant?->wallType?->wall_type_id ?? null;
        $this->wallTypes = WallType::all();

        $this->remarks = $this->taggedAndValidatedApplicant?->remarks ?? null;

        $this->images = $this->taggedAndValidatedApplicant?->images ?? [];
    }
    public function viewDocument($documentId): void
    {
        $this->selectedDocument = $this->taggedDocuments->find($documentId);
    }
    public function closeDocument(): void
    {
        $this->selectedDocument = null;
    }
    public function render()
    {
        return view('livewire.tagged-and-validated-applicant-details', [
            'taggedAndValidatedApplicant' => $this->taggedAndValidatedApplicant,
        ])->layout('layouts.app');
    }
}
