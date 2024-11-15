<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\ProfiledTaggedApplicant;
use App\Models\Shelter\OriginOfRequest;
use App\Models\Shelter\ShelterSpouse;
use App\Models\Shelter\ShelterLiveInPartner;
use App\Models\Shelter\ShelterImagesForHousing;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\Address;
use App\Models\CivilStatus;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\CaseSpecification;
use App\Models\RoofType;
use App\Models\WallType;
use App\Models\StructureStatusType;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class ShelterApplicantDetails extends Component
{
    use WithFileUploads;
    public $profileNo;
    public $applicant;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix_name;
    public $origin_name;  // Store the origin name
    public $date_request; // Store the request date

    // New fields
    public $age;
    public $sex;
    public $civil_status_id; // Store selected Civil Status ID
    public $civil_statuses; // For populating the civil statuses dropdown
    public $occupation;
    public $contact_number;
    public $isLoading = false;
    public $tribe, $religion;
    public $year_of_residency;


    public $barangay_id; // Store selected 
    public $purok_id; // Store selected 
    public $puroks = [];
    public $barangays = [];
    public $full_address;
    public $government_program_id; // Store selected Government Program ID
    public $governmentPrograms; // For populating the government programs dropdown
    public $living_situation_id, $livingSituations, $case_specification_id, $caseSpecifications, $living_situation_case_specification;
    public $date_tagged;
    public $remarks;
    public $applicantForSpouse;
    public $spouse_first_name;
    public $spouse_middle_name;
    public $spouse_last_name;
    public $partner_first_name, $partner_middle_name, $partner_last_name;
    public $photo = [], $renamedFileName = [], $structure_status_id, $structureStatuses;

    public function mount($profileNo)
    {
        $this->civil_statuses = Cache::remember('civil_statuses', 60 * 60, function () {
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


        // Fetch the applicant
        $this->applicant = ShelterApplicant::find($profileNo);

        if ($this->applicant) {
            $this->first_name = $this->applicant->first_name;
            $this->middle_name = $this->applicant->middle_name;
            $this->last_name = $this->applicant->last_name;
            $this->suffix_name = $this->applicant->suffix_name;

            // Fetch the related origin of request and request date
            $this->origin_name = $this->applicant->originOfRequest->name ?? 'N/A';
            $this->date_request = $this->applicant?->date_request
            ? $this->applicant->date_request->format('Y-m-d')
            : '--';

            // Initialize dropdowns
            $this->barangays = Barangay::all();
            $this->puroks = Purok::all();
            $this->governmentPrograms = GovernmentProgram::all();

            // Populate other new fields from the applicant
            $this->age = $this->applicant->age;
            $this->sex = $this->applicant->sex;
            $this->occupation = $this->applicant->occupation;
            $this->contact_number = $this->applicant->contact_number;
            $this->year_of_residency = $this->applicant->year_of_residency;

        $this->date_tagged = now()->toDateString(); // YYYY-MM-DD format

        } else {
            session()->flash('error', 'Applicant not found');
        }
    }

    public function updatingBarangay()
    {
        $this->resetPage();
    }
    public function updatingPurok()
    {
        $this->resetPage();
    }

    public function updatedBarangayId($barangayId)
    {
        // Fetch the puroks based on the selected barangay
        $this->puroks = Purok::where('barangay_id', $barangayId)->get();
        $this->purok_id = null; // Reset selected purok when barangay changes
    }

    
    protected function rules()
    {
        return [
            'civil_status_id' => 'nullable|exists:civil_statuses,id',
            'tribe' => 'required|string|max:255',
            'religion' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'age' => 'required|integer',
            'barangay_id' => 'required|exists:barangays,id',
            'occupation' => 'required|string|max:255',
            'year_of_residency' => 'required|integer',
            'structure_status_id' => 'required|exists:structure_status_types,id',
            'contact_number' => [
                'required',
                'regex:/^09\d{9}$/'
            ],
            'living_situation_id' => 'required|exists:living_situations,id',
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
            'purok_id' => 'required|exists:puroks,id',
            'date_tagged' => 'required|date',
            'government_program_id' => 'required|exists:government_programs,id',
            'remarks' => 'nullable|string|max:255',
            'photo.*' => 'required|file|mimes:jpeg,png,jpg,gif',
            'full_address' => 'nullable|string|max:255',

             // Live-in partner details
             'partner_first_name' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == '2' && empty($value)) {
                        $fail('Live-in partner\'s first name is required.');
                    }
                },
            ],
            'partner_middle_name' => 'nullable|string|max:255',
            'partner_last_name' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == '2' && empty($value)) {
                        $fail('Live-in partner\'s last name is required.');
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

        ];
    }

    public function store()
    {
        $this->validate();
       // dd('Validation passed');
        DB::beginTransaction();
        Log::info('Transaction started.');

        $address = Address::create([
            'barangay_id' => $this->barangay_id,
            'purok_id' => $this->purok_id,
        ]);
        // dd($address);

        try {
            $taggedApplicant = ProfiledTaggedApplicant::create([
                'profile_no' => $this->profileNo,
                'civil_status_id' => $this->civil_status_id,
                'tribe' => $this->tribe,
                'sex' => $this->sex,
                'age' => $this->age,
                'religion' => $this->religion,
                'address_id' => $address->id,
                'occupation' => $this->occupation ?: null,
                'year_of_residency' => $this->year_of_residency,
                'contact_number' => $this->contact_number ?: null,
                'full_address' => $this->full_address ?: null,
                'date_tagged' => now(),
                'living_situation_id' => $this->living_situation_id,
                'living_situation_case_specification' => $this->living_situation_id != 8 ? $this->living_situation_case_specification : null, // Store only for 1-7, 9
                'case_specification_id' => $this->living_situation_id == 8 ? $this->case_specification_id : null, // Only for 8
                'structure_status_id' => $this->structure_status_id,
                'date_tagged' => $this->date_tagged,
                'government_program_id' => $this->government_program_id,
                'remarks' => $this->remarks ?: null,
                'is_tagged' => true,
            ]);
            // dd($taggedApplicant);

             // Check if civil_status_id is 2 (Live-in) before creating LiveInPartner record
             if ($this->civil_status_id == '2') {
                ShelterLiveInPartner::create([
                    'profiled_tagged_applicant_id' => $taggedApplicant->id, // Link live-in partner to the applicant
                    'partner_first_name' => $this->partner_first_name,
                    'partner_middle_name' => $this->partner_middle_name,
                    'partner_last_name' => $this->partner_last_name,
                ]);
            }

            // Check if civil_status_id is 3 (Married) before creating Spouse record
            if ($this->civil_status_id == '3') {
                ShelterSpouse::create([
                    'profiled_tagged_applicant_id' => $taggedApplicant->id, // Link spouse to the applicant
                    'spouse_first_name' => $this->spouse_first_name,
                    'spouse_middle_name' => $this->spouse_middle_name,
                    'spouse_last_name' => $this->spouse_last_name,
                ]);
            }

            foreach ($this->photo as $index => $image) {
                $renamedFileName = $this->renamedFileName[$index] ?? $image->getClientOriginalName();
                $path = $image->storeAs('photo', $renamedFileName, 'public');
                ShelterImagesForHousing::create([
                    'profiled_tagged_applicant_id' => $taggedApplicant->id,
                    'image_path' => $path,
                    'display_name' => $renamedFileName,
                ]);
            }
            

            // Find the applicant by ID and update the 'tagged' field
            $applicant = ShelterApplicant::findOrFail($this->profileNo);
            $applicant->update(['is_tagged' => true]);

            DB::commit();
            // dd('Transaction committed');

            $this->dispatch('alert', [
                'title' => 'Tagging successful!',
                'message' => 'Applicant has been successfully tagged and validated. <br><small>' . now()->calendar() . '</small>',
                'type' => 'success'
            ]);
            return redirect()->route('shelter-transaction-applicants');

        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Error creating applicant or dependents: ' . $e->getMessage());
            dd('Database Error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.shelter-applicant-details')
            ->layout('layouts.adminshelter');
    }
}
