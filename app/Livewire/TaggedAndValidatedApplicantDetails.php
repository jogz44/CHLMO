<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
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
use Livewire\Component;

class TaggedAndValidatedApplicantDetails extends Component
{
    public $applicant;
    public $taggedAndValidatedApplicant;
    public $isEditing = false, $isLoading = false;

    public $applicantForSpouse;
    public $transaction_type_id, $transactionTypes, $transaction_type_name;
    public $first_name, $middle_name, $last_name, $suffix_name, $contact_number, $barangay_id, $barangays = [], $purok_id, $puroks = [],
            $date_applied;


    // New fields
    public $full_address, $civil_status_id, $civilStatuses, $religion_id, $religions, $tribe_id, $tribes;
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
    public $images = [], $imagesForTagging = [];
    public $selectedImage = null; // This is for the tagging image
    public $selectedAttachment = null; // this is for the awarding attachment

    public function mount($applicantId): void
    {
        $this->taggedAndValidatedApplicant = TaggedAndValidatedApplicant::with([
            'applicant.address.purok',
            'applicant.address.barangay',
            'applicant.transactionType',
            'livingSituation',
            'caseSpecification',
            'governmentProgram',
            'livingStatus',
            'civilStatus',
            'tribe',
            'religion',
            'liveInPartner',
            'spouse',
            'roofType',
            'wallType'
        ])->findOrFail($applicantId);

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
        $this->tribes = Cache::remember('tribes', 60*60, function() {
            return Tribe::all();  // Cache for 1 hour
        });
        $this->religions = Cache::remember('religions', 60*60, function() {
            return Religion::all();  // Cache for 1 hour
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
        $this->first_name = $this->taggedAndValidatedApplicant->applicant->first_name ?? '--';
        $this->transactionTypes = TransactionType::all();
        $this->middle_name = $this->taggedAndValidatedApplicant->applicant->middle_name ?? '--';
        $this->last_name = $this->taggedAndValidatedApplicant->applicant->last_name ?? '--';
        $this->suffix_name = $this->taggedAndValidatedApplicant->applicant->suffix_name ?? '--';
        $this->contact_number = $this->taggedAndValidatedApplicant->applicant->contact_number ?? '--';
        $this->transaction_type_id = $this->taggedAndValidatedApplicant?->applicant->transactionType?->transaction_type_id ?? '--';
        $this->date_applied = optional($this->taggedAndValidatedApplicant->applicant->date_applied)
            ->format('F d, Y') ?? '--';
        // Load Address Information - Store IDs instead of names
        $this->barangay_id = $this->taggedAndValidatedApplicant->applicant?->address?->barangay?->id;
        $this->purok_id = $this->taggedAndValidatedApplicant->applicant?->address?->purok?->id;
        $this->full_address = $this->taggedAndValidatedApplicant->full_address ?? '--';
        $this->occupation = $this->taggedAndValidatedApplicant->occupation ?? '--';
        $this->monthly_income = $this->taggedAndValidatedApplicant->family_income ?? '--';
        $this->family_income = $this->taggedAndValidatedApplicant->family_income ?? '--';
        // Load initial puroks if barangay is selected
        if ($this->barangay_id) {
            $this->puroks = Purok::where('barangay_id', $this->barangay_id)->get();
        }
        // Live in partner details
        $this->partner_first_name = $this->taggedAndValidatedApplicant->liveInPartner->partner_first_name ?? '--';
        $this->partner_middle_name = $this->taggedAndValidatedApplicant->liveInPartner->partner_middle_name ?? '--';
        $this->partner_last_name = $this->taggedAndValidatedApplicant->liveInPartner->partner_last_name ?? '--';
        $this->partner_occupation = $this->taggedAndValidatedApplicant->liveInPartner->partner_occupation ?? '--';
        $this->partner_monthly_income = $this->taggedAndValidatedApplicant->liveInPartner->partner_monthly_income ?? '--';
        // spouse details
        $this->spouse_first_name = $this->taggedAndValidatedApplicant->spouse->spouse_first_name ?? '--';
        $this->spouse_middle_name = $this->taggedAndValidatedApplicant->spouse->spouse_middle_name ?? '--';
        $this->spouse_last_name = $this->taggedAndValidatedApplicant->spouse->spouse_last_name ?? '--';
        $this->spouse_occupation = $this->taggedAndValidatedApplicant->spouse->spouse_occupation ?? '--';
        $this->spouse_monthly_income = $this->taggedAndValidatedApplicant->spouse->spouse_monthly_income ?? '--';
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
                'dependent_relationship' => $dependent->dependent_relationship,
                'dependent_occupation' => $dependent->dependent_occupation,
                'dependent_monthly_income' => $dependent->dependent_monthly_income,
            ];
        })->toArray();
        $this->tagging_date = optional($this->taggedAndValidatedApplicant->tagging_date)
            ->format('F d, Y') ?? '--';
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
        $this->government_program_id = $this->taggedAndValidatedApplicant?->governmentProgram->government_program_id ?? '--';
        $this->governmentPrograms = GovernmentProgram::all();

        $this->living_status_id = $this->taggedAndValidatedApplicant?->living_status_id ?? '--';
        $this->livingStatuses = LivingStatus::all();
        if ($this->living_status_id == 1){
            // Renting
            $this->rent_fee = $this->taggedAndValidatedApplicant?->rent_fee ?? '--';
            $this->landlord = $this->taggedAndValidatedApplicant?->landlord ?? '--';
        } elseif ($this->living_status_id == 5){
            // Just staying in someone's house
            $this->house_owner = $this->taggedAndValidatedApplicant?->house_owner ?? '--';
        }

        $this->roof_type_id = $this->taggedAndValidatedApplicant?->roofType?->roof_type_id ?? '--';
        $this->roofTypes = RoofType::all();

        $this->wall_type_id = $this->taggedAndValidatedApplicant?->wallType?->wall_type_id ?? '--';
        $this->wallTypes = WallType::all();

        $this->remarks = $this->taggedAndValidatedApplicant?->remarks ?? '--';

        $this->images = $this->taggedAndValidatedApplicant?->images ?? [];

//        $this->imagesForTagging = $this->taggedAndValidatedApplicant?->flatMap(function ($taggedAndValidatedApplicant) {
//            return $taggedAndValidatedApplicant->images()
//                ->get()
//                ->map(function ($submission) {
//                    return $submission->file_name;
//                })->filter();
//        }) ?? collect();
    }
    public function viewImage($imageId): void
    {
        $this->selectedImage = $this->taggedAndValidatedApplicant->images->find($imageId);
    }
    public function closeImage(): void
    {
        $this->selectedImage = null;
    }

    public function toggleEdit(): void
    {
        $this->isEditing = !$this->isEditing;
        if (!$this->isEditing) {
            $this->loadFormData(); // Reset form data if canceling edit
        }
    }
    public function render()
    {
        return view('livewire.tagged-and-validated-applicant-details', [
            'taggedAndValidatedApplicant' => $this->taggedAndValidatedApplicant,
        ])->layout('layouts.app');
    }
}
