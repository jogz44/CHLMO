<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\ShelterApplicantSpouse;
use App\Models\Shelter\ProfiledTaggedApplicant;
use App\Models\Shelter\OriginOfRequest;
use App\Models\Shelter\ShelterLivingStatus;

use App\Models\Barangay;
use App\Models\Purok;
use App\Models\Address;
use App\Models\CivilStatus;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\Religion;
use App\Models\RoofType;
use App\Models\WallType;
use App\Models\Tribe;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ShelterApplicantDetails extends Component
{
    public $profileNo;
    public $applicant;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix_name;
    public $origin_name;  // Store the origin name
    public $request_date; // Store the request date

    // New fields
    public $age;
    public $sex;
    public $civil_status_id; // Store selected Civil Status ID
    public $civil_statuses; // For populating the civil statuses dropdown
    public $occupation;
    public $contact_number;
    public $isLoading = false;
    public $year_of_residency;
    public $religion_id; // Store selected Religion ID
    public $religions; // For populating the religions dropdown
    public $tribe_id; // Store selected Tribe ID
    public $tribes; // For populating the tribes dropdown
    public $barangay_id; // Store selected 
    public $purok_id; // Store selected 
    public $puroks = [];
    public $barangays = [];
    public $full_address;
    public $government_program_id; // Store selected Government Program ID
    public $governmentPrograms; // For populating the government programs dropdown
    public $shelter_living_status_id;
     public $shelterLivingStatuses;
    public $date_tagged;
    public $remarks;

    public $shelter_spouse_first_name;
    public $shelter_spouse_middle_name;
    public $shelter_spouse_last_name;

    public function mount($profileNo)
    {
        $this->civil_statuses = Cache::remember('civil_statuses', 60 * 60, function () {
            return CivilStatus::all();  // Cache for 1 hour
        });

        $this->religions = Cache::remember('religions', 60 * 60, function () {
            return Religion::all();  // Cache for 1 hour
        });

        $this->tribes = Cache::remember('tribes', 60 * 60, function () {
            return Tribe::all();  // Cache for 1 hour
        });

        $this->shelterLivingStatuses = Cache::remember('shelterLivingStatuses', 60*60, function() {
            return ShelterLivingStatus::all();  // Cache for 1 hour
        });

        $this->governmentPrograms = Cache::remember('governmentPrograms', 60*60, function() {
            return GovernmentProgram::all();  // Cache for 1 hour
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
            $this->request_date = $this->applicant->created_at ? $this->applicant->created_at->format('Y-m-d') : '';

            // Initialize dropdowns
            $this->barangays = Barangay::all();
            $this->puroks = Purok::all();

            // Populate other new fields from the applicant
            $this->age = $this->applicant->age;
            $this->sex = $this->applicant->sex;
            $this->occupation = $this->applicant->occupation;
            $this->contact_number = $this->applicant->contact_number;
            $this->year_of_residency = $this->applicant->year_of_residency;

             // Check if address exists before accessing it
        if ($this->applicant && $this->applicant->address) {
            $this->full_address = $this->applicant->address->full_address;
        } else {
            $this->full_address = '';  // Default value if no address is found
        }

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
            'tribe_id' => 'required|exists:tribes,id',
            'sex' => 'required|in:Male,Female',
            'religion_id' => 'required|exists:religions,id',
            'barangay_id' => 'required|exists:barangays,id',
            'occupation' => 'required|string|max:255',
            'year_of_residency' => 'required|integer',
            'contact_number' => 'required|string|max:255',
            'shelter_living_status_id' => 'required|exists:shelter_living_statuses,id',
            'purok_id' => 'required|exists:puroks,id',
            'date_tagged' => 'required|date',
            'government_program_id' => 'required|exists:government_programs,id',

            // Spouse details
            'shelter_spouse_first_name' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 2 && empty($value)) {
                        $fail('Spouse first name is required.');
                    }
                },
            ],
            'shelter_spouse_middle_name' => 'nullable|string|max:255',
            'shelter_spouse_last_name' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 2) {
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
                'tribe_id' => $this->tribe_id,
                'sex' => $this->sex,
                'religion_id' => $this->religion_id ?: null,
                'address_id' => $address->id,
                'occupation' => $this->occupation ?: null,
                'year_of_residency' => $this->year_of_residency,
                'contact_number' => $this->contact_number ?: null,
                'date_tagged' => now(),
                'shelter_living_status_id' => $this->shelter_living_status_id,
                'date_tagged' => $this->date_tagged,
                'government_program_id' => $this->government_program_id,
                'remarks' => $this->remarks ?: 'N/A',
                'is_tagged' => true,
            ]);
            // dd($taggedApplicant);

            if ($this->civil_status_id == '2') {
                ShelterApplicantSpouse::create([
                    'profile_no' => $taggedApplicant->id, // Link spouse to the applicant
                    'shelter_spouse_first_name' => $this->shelter_spouse_first_name,
                    'shelter_spouse_middle_name' => $this->shelter_spouse_middle_name,
                    'shelter_spouse_last_name' => $this->shelter_spouse_last_name,
                ]);
                // dd('Spouse creation started');
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
