<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Barangay;
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
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class ApplicantDetails extends Component
{
    public $applicantId;
    public $applicant;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix_name;
    public $contact_number;
    public $barangay;
    public $purok;

    // New fields
    public $full_address;
    public $civil_status_id; // Store selected Civil Status ID
    public $civil_statuses; // For populating the civil statuses dropdown

    public $religion_id; // Store selected Religion ID
    public $religions; // For populating the religions dropdown
    public $tribe_id; // Store selected Tribe ID
    public $tribes; // For populating the tribes dropdown
    public $living_situation_id; // Store selected Living Situation ID
    public $livingSituations; // For populating the living situations dropdown
    public $case_specification_id; // Store selected Case Specification ID
    public $caseSpecifications; // For populating the case specifications dropdown
    public $government_program_id; // Store selected Government Program ID
    public $governmentPrograms; // For populating the government programs dropdown
    public $living_status_id; // Store selected Living Status ID
    public $livingStatuses; // For populating the living statuses dropdown
    public $roof_type_id; // Store selected Roof Type ID
    public $roofTypes; // For populating the roof types dropdown
    public $wall_type_id; // Store selected Wall Type ID
    public $wallTypes; // For populating the wall types dropdown

    public $sex;
    public $date_of_birth;

    public $occupation;
    public $monthly_income;
    public $family_income;
    public $tagging_date;
    public $rent_fee;
    public $tagger_name;
    public $remarks;
    public $photos = [];

    public function mount($applicantId)
    {
        $this->applicantId = $applicantId;
        $this->applicant = Applicant::find($applicantId);

        $this->civil_statuses = Cache::remember('civil_statuses', 60*60, function() {
            return CivilStatus::all();  // Cache for 1 hour
        });

        $this->religions = Cache::remember('religions', 60*60, function() {
            return Religion::all();  // Cache for 1 hour
        });

        $this->tribes = Cache::remember('tribes', 60*60, function() {
            return Tribe::all();  // Cache for 1 hour
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

        // Populate fields with applicant data
        $this->first_name = $this->applicant->first_name;
        $this->middle_name = $this->applicant->middle_name;
        $this->last_name = $this->applicant->last_name;
        $this->suffix_name = $this->applicant->suffix_name;
        $this->contact_number = $this->applicant->contact_number;

        // Access the barangay and purok through the address relation
        $this->barangay = $this->applicant->address->barangay->name ?? '';
        $this->purok = $this->applicant->address->purok->name ?? '';

        // Set today's date as the default value for tagged_date
        $this->tagging_date = now()->toDateString(); // YYYY-MM-DD format

        // Set interviewer
        $this->tagger_name = Auth::user()->full_name();
    }

    protected function rules()
    {
        return [
            'full_address' => 'nullable|string|max:255',
            'civil_status_id' => 'required|exists:civil_statuses,id',
            'tribe_id' => 'required|exists:tribes,id',
            'sex' => 'required|in:Male,Female',
            'date_of_birth' => [
                'required',
                'date',
                'before:' . now()->subYears(18)->format('Y-m-d'),  // Ensures they are 18+
            ],
            'religion_id' => 'nullable|exists:religions,id',
            'occupation' => 'nullable|string|max:255',
            'monthly_income' => 'required|integer',
            'family_income' => 'required|integer',
            'tagging_date' => 'required|date',
            'living_situation_id' => 'required|exists:living_situations,id',
            'case_specification_id' => 'required|exists:case_specifications,id',
            'government_program_id' => 'required|exists:government_programs,id',
            'living_status_id' => 'required|exists:living_statuses,id',
            'rent_fee' => 'nullable|integer',
            'roof_type_id' => 'required|exists:roof_types,id',
            'wall_type_id' => 'required|exists:wall_types,id',
            'remarks' => 'nullable|string|max:255',
            'photos.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function store()
    {
        // Debugging request data
//        dd($this->all());

        // Validate the input data
        $this->validate();

        $photoPaths = []; // Array to hold the paths of stored photos

        foreach ($this->photos as $photo) {
            // Store each photo and get the path
            $path = $photo->store('photos', 'public');
            $photoPaths[] = $path; // Store the path in the array
        }

        \Log::info('Creating tagged applicant', ['is_tagged' => true]);

        // Attempt to create the new tagged and validated applicant record
        try {
            TaggedAndValidatedApplicant::create([
                'applicant_id' => $this->applicantId,
                'full_address' => $this->full_address ?: 'N/A',
                'civil_status_id' => $this->civil_status_id,
                'tribe_id' => $this->tribe_id,
                'sex' => $this->sex,
                'date_of_birth' => $this->date_of_birth,
                'religion_id' => $this->religion_id ?: 'N/A',
                'occupation' => $this->occupation ?: 'N/A',
                'monthly_income' => $this->monthly_income,
                'family_income' => $this->family_income,
                'tagging_date' => $this->tagging_date,
                'living_situation_id' => $this->living_situation_id,
                'case_specification_id' => $this->case_specification_id,
                'government_program_id' => $this->government_program_id,
                'living_status_id' => $this->living_status_id,
                'rent_fee' => $this->rent_fee ?: 'N/A',
                'roof_type_id' => $this->roof_type_id,
                'wall_type_id' => $this->wall_type_id,
                'remarks' => $this->remarks ?: 'N/A',
                'photo' => !empty($photoPaths) ? json_encode($photoPaths) : 'N/A', // Store as JSON array
                // These two are auto-generated
                'is_tagged' => true,
                'tagger_name' => $this->tagger_name,
            ]);

            // Find the applicant by ID and update the 'tagged' field
            $applicant = Applicant::findOrFail($this->applicantId);
            $applicant->update(['is_tagged' => true]);

            // Flash success message
            session()->flash('message', 'Applicant has been successfully tagged and validated.');

            // Reset form fields
//            $this->reset([
//                'full_address', 'civil_status_id', 'tribe_id', 'sex', 'date_of_birth', 'religion_id',
//                'occupation', 'monthly_income', 'family_income','tagging_date', 'living_situation_id',
//                'case_specification_id', 'government_program_id', 'living_status_id', 'rent_fee',
//                'roof_type_id', 'wall_type_id', 'remarks',
//
//            ]);
            return redirect()->route('applicants');
        } catch (QueryException $e) {
            // Log the error for debugging
            \Log::error('Error tagging applicant: ' . $e->getMessage());

            // Flash error message
            session()->flash('error', 'An error occurred while tagging the applicant. Please try again.');

            // Optionally, redirect back to the form or keep the user on the same page
//            return redirect()->back()->withErrors(['error' => 'An error occurred while tagging the applicant.']);
        }
    }

    public function render()
    {
        return view('livewire.applicant-details')
            ->layout('layouts.app');  // Ensure this matches your Blade layout path
    }
}
