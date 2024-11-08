<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\LivingStatus;
use App\Models\Religion;
use App\Models\RoofType;
use App\Models\TaggedAndValidatedApplicant;
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
    public $transaction_type_id, $transaction_type_name;
    public $first_name, $middle_name, $last_name, $suffix_name, $contact_number, $barangay, $purok;

    // New fields
    public $full_address, $civil_status_id, $civil_statuses, $religion_id, $religions, $tribe_id, $tribes;
    public $living_situation_id, $livingSituations, $case_specification_id, $caseSpecifications, $living_situation_case_specification,
        $government_program_id, $governmentPrograms, $living_status_id, $livingStatuses, $roof_type_id, $roofTypes, $wall_type_id,
        $wallTypes, $sex, $date_of_birth, $occupation, $monthly_income, $family_income, $tagging_date, $rent_fee, $landlord,
        $house_owner, $tagger_name, $remarks;

    // Live-in partner's details
    public $partner_first_name, $partner_middle_name, $partner_last_name, $partner_occupation, $partner_monthly_income;
    // Spouse's details
    public $spouse_first_name, $spouse_middle_name, $spouse_last_name, $spouse_occupation, $spouse_monthly_income;

    // Dependent's details
    public $dependents = [], $dependent_civil_status_id, $dependent_civil_statuses, $images = [], $renamedFileName = [];
    // Dependent's details
//    public $dependents = [];
//    public $images = [];
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
            'civilStatus',
            'tribe',
            'religion'
        ])->findOrFail($applicantId);

        $this->civil_statuses = Cache::remember('civil_statuses', 60*60, function() {
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
