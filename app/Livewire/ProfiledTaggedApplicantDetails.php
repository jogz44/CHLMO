<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\ProfiledTaggedApplicant;
use App\Models\Shelter\Grantee;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\Barangay;
use App\Models\LivingSituation;
use App\Models\GovernmentProgram;
use App\Models\Shelter\OriginOfRequest;
use App\Models\Shelter\ShelterLiveInPartner;
use App\Models\Shelter\ShelterSpouse;
use App\Models\Purok;
use App\Models\Religion;
use App\Models\StructureStatusType;
use App\Models\Tribe;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class ProfiledTaggedApplicantDetails extends Component
{
    public $isEditing = false, $isLoading = false;
    public $profiledTaggedApplicant;
    public $shelterApplicant;
    public $profiledTagged;

    public $first_name;
    public $middle_name;
    public $last_name;
    public $originOfRequest, $request_origin_id, $origin_name;
    public $age, $sex, $occupation, $contact_number, $barangay_id, $purok_id, $full_address, $year_of_residency;
    public $puroks = [], $tribe, $religion,  
        $spouse_first_name, $spouse_middle_name, $spouse_last_name,
        $partner_first_name, $partner_middle_name, $partner_last_name;
    public $marriedStatusId = 3; // ID for married status
    public $liveInPartnerStatusId = 2; // ID for live-in partner status


    public $date_request;
    public $civil_status_id, $civilStatuses, $date_tagged, $structure_status_id, $structureStatuses,
        $living_situation_id, $livingSituations, $case_specification_id, $caseSpecifications, $living_situation_case_specification,
        $government_program_id, $governmentPrograms, $remarks;

    public $materialUnitId, $material_id, $purchaseOrderId;
    public $quantity, $date_of_delivery, $date_of_ris;
    public $photo = [];
    public $selectedImage = null; // This is for the tagging image
    public $selectedAttachment = null; // this is for the awarding attachment

    public function mount($profileNo): void
    {
        $this->profiledTaggedApplicant = ProfiledTaggedApplicant::with([
            'shelterApplicant.address.purok',
            'shelterApplicant.person',
            'shelterApplicant.originOfRequest',
            'shelterApplicant.address.barangay',
            'livingSituation',
            'caseSpecification',
            'governmentProgram',
            'civilStatus',
            'shelterLiveInPartner',
            'shelterSpouse',
            'structureStatus'
           
        ])->findOrFail($profileNo);

        $this->loadFormData();
    }
    public function loadFormData(): void
    {
        $this->civilStatuses = Cache::remember('civil_statuses', 60*60, function() {
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
        $this->structureStatuses = Cache::remember('structureStatuses', 60*60, function() {
            return StructureStatusType::all();  // Cache for 1 hour
        });

        // Applicant basic information
        $this->first_name = $this->profiledTaggedApplicant->shelterApplicant->person->first_name ?? null;
        $this->middle_name = $this->profiledTaggedApplicant->shelterApplicant->person->middle_name ?? null;
        $this->last_name = $this->profiledTaggedApplicant->shelterApplicant->person->last_name ?? null;
        $this->origin_name = $this->profiledTaggedApplicant->shelterApplicant->originOfRequest->name ?? null;
        $this->barangay_id = $this->profiledTaggedApplicant->shelterApplicant->address?->barangay?->id;
        $this->purok_id = $this->profiledTaggedApplicant->shelterApplicant->address?->purok?->id;
        $this->date_request = optional($this->profiledTaggedApplicant->shelterApplicant->date_request)
            ->format('F d, Y') ?? null;
        // Load Address Information - Store IDs instead of names
        $this->contact_number = $this->profiledTaggedApplicant->contact_number ?? null;
        $this->year_of_residency = $this->profiledTaggedApplicant->year_of_residency ?? null;
        $this->full_address = $this->profiledTaggedApplicant->full_address ?? null;
        $this->occupation = $this->profiledTaggedApplicant->occupation ?? null;
        $this->tribe = $this->profiledTaggedApplicant->tribe ?? null;
        $this->religion = $this->profiledTaggedApplicant->religion ?? null;
        $this->age = $this->profiledTaggedApplicant->age ?? null;
        // Load initial puroks if barangay is selected
        if ($this->barangay_id) {
            $this->puroks = Purok::where('barangay_id', $this->barangay_id)->get();
        }
        $this->civil_status_id = $this->profiledTaggedApplicant?->civilStatus?->civil_status_id ?? null;
        $this->structure_status_id = $this->profiledTaggedApplicant?->structureStatus?->structure_status_id ?? null;
        // Live in partner details
        $this->partner_first_name = $this->profiledTaggedApplicant->liveInPartner->partner_first_name ?? null;
        $this->partner_middle_name = $this->profiledTaggedApplicant->liveInPartner->partner_middle_name ?? null;
        $this->partner_last_name = $this->profiledTaggedApplicant->liveInPartner->partner_last_name ?? null;
        // spouse details
        $this->spouse_first_name = $this->profiledTaggedApplicant->spouse->spouse_first_name ?? null;
        $this->spouse_middle_name = $this->profiledTaggedApplicant->spouse->spouse_middle_name ?? null;
        $this->spouse_last_name = $this->profiledTaggedApplicant->spouse->spouse_last_name ?? null;

        $this->date_tagged = optional($this->profiledTaggedApplicant->date_tagged)
            ->format('F d, Y') ?? null;
       
        $this->living_situation_id = $this->profiledTaggedApplicant?->livingSituation?->living_situation_id ?? null;
        $this->livingSituations = LivingSituation::all();
        // Load case specification data
        if ($this->profiledTaggedApplicant?->livingSituation?->living_situation_id == 8) {
            $this->case_specification_id = $this->profiledTaggedApplicant?->caseSpecification?->case_specification_id ?? null;
        } else {
            $this->living_situation_case_specification = $this->profiledTaggedApplicant?->living_situation_case_specification ?? '';
        }
        $this->caseSpecifications = CaseSpecification::all();

        // government programs
        $this->government_program_id = $this->profiledTaggedApplicant?->governmentProgram->government_program_id ?? null;
        $this->governmentPrograms = GovernmentProgram::all();

        $this->remarks = $this->profiledTaggedApplicant?->remarks ?? null;

        $this->photo = $this->profiledTaggedApplicant?->photo ?? [];
    }
 
    public function viewImage($imageId): void
    {
        $this->selectedImage = $this->profiledTaggedApplicant->photo->find($imageId);
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
    public function update(): void
    {
        $this->validate([
            'person_id' => 'required|integer',
            'contact_number' => 'nullable|string|max:15',
            'barangay_id' => 'required|integer',
            'purok_id' => 'required|integer',
            'date_request' => 'required|date',
            'origin_of_request_id' => 'required|integer',
            'year_of_residency' => 'required|integer',
            'structure_status_id' => 'required|integer',
            'full_address' => 'nullable|string|max:255',
            'civil_status_id' => 'required|integer',
            'tribe' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date',
            'religion' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'monthly_income' => 'required|integer',
            'family_income' => 'required|integer',
            'date_tagged' => 'required|date',
            'living_situation_id' => 'required|integer',
            'living_situation_case_specification' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_situation_id,1,2,3,4,5,6,7,9',
                'string',
                'max:255'
            ],
            'case_specification_id' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_situation_id,8', // Only required if living_situation_id is 8
                'exists:case_specifications,id'
            ],
            'government_program_id' => 'required|integer',

            'remarks' => 'nullable|string|max:255',
            'photo.*' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',

            // Live-in partner details
            'partner_first_name' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 2 && empty($value)) {
                        $fail('Live-in partner\'s first name is required.');
                    }
                },
            ],
            'partner_middle_name' => 'nullable|string|max:255',
            'partner_last_name' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 2) {
                        if (empty($value)) {
                            $fail('Live-in partner\'s last name is required.');
                        }
                    }
                },
            ],
            
            // Spouse details
            'spouse_first_name' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 3 && empty($value)) {
                        $fail('Spouse first name is required.');
                    }
                },
            ],
            'spouse_middle_name' => 'nullable|string|max:255',
            'spouse_last_name' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 3) {
                        if (empty($value)) {
                            $fail('Spouse last name is required.');
                        } elseif ($value !== $this->last_name) {
                            $fail('The spouse\'s last name must match the applicant\'s last name.');
                        }
                    }
                },
            ],
           
        ]);

        $this->profiledTaggedApplicant->shelterApplicant->person->first_name = $this->first_name;
        $this->profiledTaggedApplicant->shelterApplicant->person->middle_name = $this->middle_name;
        $this->profiledTaggedApplicant->shelterApplicant->person->last_name = $this->last_name;
        $this->profiledTaggedApplicant->shelterApplicant->request_origin_id = $this->originOfRequest->name;
        $this->profiledTaggedApplicant->shelterApplicant->date_request = $this->date_request;

        // Update address
        $address = $this->profiledTaggedApplicant->address;
        if ($address) {
            $address->barangay_id = $this->barangay_id;
            $address->purok_id = $this->purok_id;
            $address->save(); // Don't forget to save the address
        }
        $this->profiledTaggedApplicant->full_address = $this->full_address;
        $this->profiledTaggedApplicant->civilStatus->civil_status_id = $this->civil_status_id;
        $this->profiledTaggedApplicant->structureStatus->structure_status_id = $this->structure_status_id;
        $this->profiledTaggedApplicant->tribe = $this->tribe;
        $this->profiledTaggedApplicant->sex = $this->sex;
        $this->profiledTaggedApplicant->date_of_birth = $this->date_of_birth;
        $this->profiledTaggedApplicant->religion = $this->religion;
        $this->profiledTaggedApplicant->occupation = $this->occupation;
        $this->profiledTaggedApplicant->contact_number = $this->contact_number;
        $this->profiledTaggedApplicant->year_of_residency = $this->year_of_residency;

        // Live-in partner
        $this->profiledTaggedApplicant->liveInPartner->partner_first_name = $this->partner_first_name;
        $this->profiledTaggedApplicant->liveInPartner->partner_middle_name = $this->partner_middle_name;
        $this->profiledTaggedApplicant->liveInPartner->partner_last_name = $this->partner_last_name;

        // spouse
        $this->profiledTaggedApplicant->spouse->spouse_first_name = $this->spouse_first_name;
        $this->profiledTaggedApplicant->spouse->spouse_middle_name = $this->spouse_middle_name;
        $this->profiledTaggedApplicant->spouse->spouse_last_name = $this->spouse_last_name;

        $this->profiledTaggedApplicant->date_tagged = $this->date_tagged;
        $this->profiledTaggedApplicant->livingSituation->living_situation_id = $this->living_situation_id;
        $this->profiledTaggedApplicant->living_situation_case_specification = $this->living_situation_case_specification;
        $this->profiledTaggedApplicant->caseSpecification->case_specification_id = $this->case_specification_id;
        $this->profiledTaggedApplicant->governmentProgram->government_program_id = $this->government_program_id;
        $this->profiledTaggedApplicant->remarks = $this->remarks;

        // Save the updated applicant
        dd($this->profiledTaggedApplicant);
        $this->profiledTaggedApplicant->save();

        // Show a success message
        $this->dispatch('alert', [
            'title' => 'Update successful!',
            'message' => 'The applicant\'s information has been updated. <br><small>'. now()->calendar() .'</small>',
            'type' => 'success'
        ]);

        // Reload the form data
        $this->loadFormData();

        // Disable edit mode
        $this->isEditing = false;
    }
    public function render()
    {
        $OriginOfRequests = OriginOfRequest::all();
        return view('livewire.profiled-tagged-applicant-details', [
            'profiledTaggedApplicant' => $this->profiledTaggedApplicant,
            'OriginOfRequests' => $OriginOfRequests,
            'barangays' => Barangay::all(),
        ]) ->layout('layouts.adminshelter');
    }
}
