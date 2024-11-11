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
use App\Models\Tribe;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GranteeDetails extends Component
{
    public $isEditing = false, $isLoading = false;
    public $grantee;
    public $shelterApplicant;
    public $profiledTagged;

    public $first_name;
    public $middle_name;
    public $last_name;
    public $originOfRequest, $request_origin_id, $origin_name;
    public $age, $sex, $occupation, $contact_number, $barangay_id, $purok_id, $full_address, $year_of_residency;
    public $puroks = [], $tribe_id, $religion_id,
        $spouse_first_name, $spouse_middle_name, $spouse_last_name,
        $partner_first_name, $partner_middle_name, $partner_last_name;
    public $marriedStatusId = 3; // ID for married status
    public $liveInPartnerStatusId = 2; // ID for live-in partner status


    public $date_request;
    public $civil_status_id, $civilStatuses, $date_tagged,
        $living_situation_id, $livingSituations, $case_specification_id, $caseSpecifications, $living_situation_case_specification,
        $government_program_id, $governmentPrograms, $remarks;

    public $materialUnitId, $material_id, $purchaseOrderId;
    public $quantity, $date_of_delivery, $date_of_ris;
    public $photo = [], $photoForAwarding = [];
    public $selectedImage = null; // This is for the tagging image
    public $selectedAttachment = null; // this is for the awarding attachment

    public function mount($profileNo): void
    {
        $this->grantee = Grantee::with([
            'profiledTaggedApplicant.civilStatus',
            'profiledTaggedApplicant.tribe',
            'profiledTaggedApplicant.originOfRequest',
            'profiledTaggedApplicant.religion',
            'profiledTaggedApplicant.livingSituation',
            'profiledTaggedApplicant.caseSpecification',
            'profiledTaggedApplicant.governmentProgram',
            'profiledTaggedApplicant.shelterSpouse',
            'profiledTaggedApplicant.shelterLiveInPartner',
            'profiledTaggedApplicant.address.purok',
            'profiledTaggedApplicant.address.barangay',
        ])->findOrFail($profileNo);

        $this->profiledTagged = $this->grantee->profiledTaggedApplicant;
        $this->shelterApplicant = $this->profiledTagged->shelterApplicant;
        $this->loadFormData();
    }
    public function loadFormData(): void
    {
        // Load Applicant Information
        $this->first_name = $this->shelterApplicant->first_name ?? '--';
        $this->middle_name = $this->shelterApplicant->middle_name ?? '--';
        $this->last_name = $this->shelterApplicant->last_name ?? '--';
        $this->request_origin_id = $this->shelterApplicant->originOfRequest->name ?? '--';
        $this->date_request = $this->shelterApplicant?->date_request
            ? $this->shelterApplicant->date_request->format('Y-m-d')
            : '--';

        // Load Tagged and Validated Applicant Information
        $this->civil_status_id = $this->profiledTagged?->civil_status_id ?? '--';
        $this->tribe_id = $this->profiledTagged?->tribe_id ?? '--';
        $this->age = $this->profiledTagged?->age ?? '--';
        $this->sex = $this->profiledTagged?->sex ?? '--';
        $this->year_of_residency = $this->profiledTagged?->year_of_residency ?? '--';
        $this->contact_number = $this->profiledTagged?->contact_number ?? '--';
        $this->religion_id = $this->profiledTagged?->religion_id ?? '--';
        $this->occupation = $this->profiledTagged?->occupation ?? '--';
        $this->date_tagged = optional($this->profiledTagged?->date_tagged)
            ->format('Y-m-d') ?? '--';

        // Load live-in partner information
        $this->partner_first_name = $this->profiledTagged?->shelterLiveInPartner?->partner_first_name ?? '--';
        $this->partner_middle_name = $this->profiledTagged?->shelterLiveInPartner?->partner_middle_name ?? '--';
        $this->partner_last_name = $this->profiledTagged?->shelterLiveInPartner?->partner_last_name ?? '--';

        // Load spouse information
        $this->spouse_first_name = $this->profiledTagged?->shelterSpouse?->spouse_first_name ?? '--';
        $this->spouse_middle_name = $this->profiledTagged?->shelterSpouse?->spouse_middle_name ?? '--';
        $this->spouse_last_name = $this->profiledTagged?->shelterSpouse?->spouse_last_name ?? '--';

        $this->date_of_delivery = optional($this->grantee->date_of_delivery)->format('F d, Y') ?? '--';
        
        // Load civil statuses here
        $this->civilStatuses = CivilStatus::all();
        // Load living situation
        $this->living_situation_id = $this->profiledTagged?->living_situation_id ?? null;
        $this->livingSituations = LivingSituation::all();

        // Load case specification data
        if ($this->profiledTagged?->living_situation_id == 8) {
            $this->case_specification_id = $this->profiledTagged?->case_specification_id ?? null;
        } else {
            $this->living_situation_case_specification = $this->profiledTagged?->living_situation_case_specification ?? '';
        }
        $this->caseSpecifications = CaseSpecification::all();
        
        // government programs
        $this->government_program_id = $this->profiledTagged?->government_program_id ?? '--';
        $this->governmentPrograms = GovernmentProgram::all();

        $this->remarks = $this->profiledTagged?->remarks ?? '--';

        // Load Address Information - Store IDs instead of names
        $this->barangay_id = $this->profiledTagged?->address?->barangay?->id;
        $this->purok_id = $this->profiledTagged?->address?->purok?->id;
        $this->full_address = $this->profiledTagged?->address?->full_address ?? '--';
        // Load initial puroks if barangay is selected
        if ($this->barangay_id) {
            $this->puroks = Purok::where('barangay_id', $this->barangay_id)->get();
        }

        $this->photo = $this->shelterApplicant->taggedAndValidated?->photo ?? [];

        $this->photoForAwarding = $this->shelterApplicant->taggedAndValidated?->grantees?->flatMap(function ($grantee) {
            return $grantee->granteeDocumentsSubmission()
                ->get()
                ->map(function ($submission) {
                    return $submission->file_name;
                })->filter();
        }) ?? collect();
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
    public function render()
    {
        $OriginOfRequests = OriginOfRequest::all();
        return view('livewire.grantee-details', [
            'grantee' => $this->grantee,
            'OriginOfRequests' => $OriginOfRequests,
            'barangays' => Barangay::all(),
            'tribes' => Tribe::all(),
            'religions' => Religion::all()
        ])
            ->layout('layouts.adminshelter');
    }
}
