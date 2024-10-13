<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\Dependent;
use App\Models\GovernmentProgram;
use App\Models\ImagesForHousing;
use App\Models\LivingSituation;
use App\Models\LivingStatus;
use App\Models\Purok;
use App\Models\Religion;
use App\Models\RoofType;
use App\Models\Spouse;
use App\Models\TaggedAndValidatedApplicant;
use App\Models\TransactionType;
use App\Models\Tribe;
use App\Models\WallType;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ApplicantDetails extends Component
{
    use WithFileUploads;
    public $applicantId;
    public $applicant;
    public $applicantForSpouse;
    public $transaction_type_id;
    public $transaction_type_name;
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
    public $living_situation_case_specification;
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
    public $landlord;
    public $house_owner;
    public $tagger_name;
    public $remarks;

    // Spouse's details
    public $spouse_first_name;
    public $spouse_middle_name;
    public $spouse_last_name;
    public $spouse_occupation;
    public $spouse_monthly_income;

    // Dependent's details
    public $dependents;
    public $dependent_civil_status_id; // Store selected Civil Status ID
    public $dependent_civil_statuses; // For populating the civil statuses dropdown
//    public $dependent_first_name;
//    public $dependent_middle_name;
//    public $dependent_last_name;
//    public $dependent_sex;
//    public $dependent_date_of_birth;
//    public $dependent_relationship;
//    public $dependent_occupation;
//    public $dependent_monthly_income;
    //
    public $images = [];
    public $renamedFileName = [];

    public function mount($applicantId)
    {
//        $this->dependents = Dependent::all();

        $this->applicantId = $applicantId;
        $this->applicant = Applicant::find($applicantId);

        // Reset dependents array when the component is mounted
        $this->dependents = [];

        $taggedAndValidatedApplicant = TaggedAndValidatedApplicant::with('dependents')->find($applicantId);
        if ($taggedAndValidatedApplicant) {
            $this->dependents = $taggedAndValidatedApplicant->dependents->toArray();
        }

        // Set the default transaction type to 'Walk-in'
        $walkIn = TransactionType::where('type_name', 'Walk-in')->first();
        if ($walkIn) {
            $this->transaction_type_id = $walkIn->id; // This can still be used internally for further logic if needed
            $this->transaction_type_name = $walkIn->type_name; // Set the name to display
        }

        $this->civil_statuses = Cache::remember('civil_statuses', 60*60, function() {
            return CivilStatus::all();  // Cache for 1 hour
        });

        // For Dependents
        $this->dependent_civil_statuses = Cache::remember('civil_statuses', 60*60, function() {
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

    // Add row for another dependent
    public function add()
    {
        // Add a new blank dependent array to the dependents list
        $this->dependents[] = [
            'dependent_first_name' => null,
            'dependent_middle_name' => null,
            'dependent_last_name' => null,
            'dependent_sex' => null,
            'dependent_civil_status_id' => null,
            'dependent_date_of_birth' => null,
            'dependent_occupation' => null,
            'dependent_monthly_income' => null,
            'dependent_relationship' => null,
        ];
    }
    public function remove($index)
    {
        unset($this->dependents[$index]);
    }

    protected function rules()
    {
        return [
            'full_address' => 'nullable|string|max:255',
            'civil_status_id' => 'nullable|exists:civil_statuses,id',
            'tribe_id' => 'required|exists:tribes,id',
            'sex' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date',
            'religion_id' => 'required|exists:religions,id',
            'occupation' => 'required|string|max:255',
            'monthly_income' => 'required|integer',
            'family_income' => 'required|integer',
            'tagging_date' => 'required|date',
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
            'government_program_id' => 'required|exists:government_programs,id',
            'living_status_id' => 'required|exists:living_statuses,id',
            'rent_fee' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,1', // Only required if living_status_id is 1
                'integer'
            ],
            'landlord' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,1',
                'string',
                'max:255'
            ],
            'house_owner' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,5',
                'string',
                'max:255'
            ],
            'roof_type_id' => 'required|exists:roof_types,id',
            'wall_type_id' => 'required|exists:wall_types,id',
            'remarks' => 'nullable|string|max:255',
            'images.*' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',

            // Spouse details
            'spouse_first_name' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 2 && empty($value)) {
                        $fail('Spouse first name is required.');
                    }
                },
            ],
            'spouse_middle_name' => 'nullable|string|max:255',
            'spouse_last_name' => [
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
            'spouse_occupation' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 2 && empty($value)) {
                        $fail('Spouse occupation is required.');
                    }
                },
            ],
            'spouse_monthly_income' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 2 && empty($value)) {
                        $fail('Spouse monthly income is required.');
                    } elseif ($this->civil_status_id == 2 && !is_numeric($value)) {
                        $fail('Spouse monthly income must be a number.');
                    }
                },
            ],

            // Dependent's details
            'dependents.*.dependent_civil_status_id' => 'nullable|exists:civil_statuses,id',
            'dependents.*.dependent_first_name' => 'nullable|string|max:50',
            'dependents.*.dependent_middle_name' => 'nullable|string|max:50',
            'dependents.*.dependent_last_name' => 'nullable|string|max:50',
            'dependents.*.dependent_sex' => 'nullable|in:Male,Female',
            'dependents.*.dependent_date_of_birth' => 'nullable|date',
            'dependents.*.dependent_relationship' => 'nullable|string|max:100',
            'dependents.*.dependent_occupation' => 'nullable|string|max:255',
            'dependents.*.dependent_monthly_income' => 'nullable|integer',
        ];
    }

    public function store()
    {
        // Validate the input data
        $this->validate();

        \Log::info('Creating tagged applicant', ['is_tagged' => true]);

        DB::beginTransaction();

        // Attempt to create the new tagged and validated applicant record
        try {
            TaggedAndValidatedApplicant::create([
                'applicant_id' => $this->applicantId,
                'transaction_type_id' => $this->transaction_type_id,
                'full_address' => $this->full_address ?: null,
                'civil_status_id' => $this->civil_status_id,
                'tribe_id' => $this->tribe_id,
                'sex' => $this->sex,
                'date_of_birth' => $this->date_of_birth,
                'religion_id' => $this->religion_id ?: null,
                'occupation' => $this->occupation ?: null,
                'monthly_income' => $this->monthly_income,
                'family_income' => $this->family_income,
                'tagging_date' => $this->tagging_date,
                'living_situation_id' => $this->living_situation_id,
                'living_situation_case_specification' => $this->living_situation_id != 8 ? $this->living_situation_case_specification : null, // Store only for 1-7, 9
                'case_specification_id' => $this->living_situation_id == 8 ? $this->case_specification_id : null, // Only for 8
                'government_program_id' => $this->government_program_id,
                'living_status_id' => $this->living_status_id,
                'rent_fee' => $this->living_status_id == 1 ? $this->rent_fee : null, // Store rent fee only if living_status_id is 1,
                'landlord' => $this->living_status_id == 1 ? $this->landlord : null, // Store landlord only if living_status_id is 1,
                'house_owner' => $this->living_status_id == 5 ? $this->house_owner : null, // Store house owner only if living_status_id is 5,
                'roof_type_id' => $this->roof_type_id,
                'wall_type_id' => $this->wall_type_id,
                'remarks' => $this->remarks ?: 'N/A',
                // These two are auto-generated
                'is_tagged' => true,
                'tagger_name' => $this->tagger_name,
            ]);

            // Check if civil_status_id is 2 (Married) before creating Spouse record
            if ($this->civil_status_id == '2') {
                Spouse::create([
                    'tagged_and_validated_applicant_id' => $this->applicantId, // Link spouse to the applicant
                    'spouse_first_name' => $this->spouse_first_name,
                    'spouse_middle_name' => $this->spouse_middle_name,
                    'spouse_last_name' => $this->spouse_last_name,
                    'spouse_occupation' => $this->spouse_occupation,
                    'spouse_monthly_income' => $this->spouse_monthly_income,
                ]);
            }

            // Create dependent records associated with the applicant
            foreach ($this->dependents as $dependent) {
                Dependent::create([
                    'tagged_and_validated_applicant_id' => $this->applicantId,
                    'dependent_first_name' => $dependent['dependent_first_name'] ?: null,
                    'dependent_middle_name' => $dependent['dependent_middle_name'] ?: null,
                    'dependent_last_name' => $dependent['dependent_last_name'] ?: null,
                    'dependent_sex' => $dependent['dependent_sex'] ?: null,
                    'dependent_civil_status_id' => $dependent['dependent_civil_status_id'] ?: null,
                    'dependent_date_of_birth' => $dependent['dependent_date_of_birth'] ?: null,
                    'dependent_occupation' => $dependent['dependent_occupation'] ?: null,
                    'dependent_monthly_income' => $dependent['dependent_monthly_income'] ?: null,
                    'dependent_relationship' => $dependent['dependent_relationship'] ?: null,
                ]);
            }

            foreach ($this->images as $index => $image) {
                $renamedFileName = $this->renamedFileName[$index] ?? $image->getClientOriginalName();
                $path = $image->storeAs('images', $renamedFileName, 'public');
                ImagesForHousing::create([
                    'tagged_and_validated_applicant_id' => $this->applicantId,
                    'image_path' => $path,
                    'display_name' => $renamedFileName,
                ]);
            }

            // Find the applicant by ID and update the 'tagged' field
            $applicant = Applicant::findOrFail($this->applicantId);
            $applicant->update(['is_tagged' => true]);

            DB::commit();

            session()->flash('message', 'Applicant has been successfully tagged and validated.');

            return redirect()->route('applicants');
        } catch (QueryException $e) {
            DB::rollBack();
            \Log::error('Error creating applicant or dependents: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while tagging the applicant. Please try again.');
        }
    }

//    public function store()
//    {
//        // Validate the input data
//        $this->validate();
//
//        \Log::info('Creating tagged applicant', ['is_tagged' => true]);
//
//        // Attempt to create the new tagged and validated applicant record
//        try {
//            // Create the tagged applicant
//            $taggedApplicant = TaggedAndValidatedApplicant::create([
//                'applicant_id' => $this->applicantId,
//                'transaction_type_id' => $this->transaction_type_id,
//                'full_address' => $this->full_address ?: null,
//                'civil_status_id' => $this->civil_status_id,
//                'tribe_id' => $this->tribe_id,
//                'sex' => $this->sex,
//                'date_of_birth' => $this->date_of_birth,
//                'religion_id' => $this->religion_id ?: null,
//                'occupation' => $this->occupation ?: null,
//                'monthly_income' => $this->monthly_income,
//                'family_income' => $this->family_income,
//                'tagging_date' => $this->tagging_date,
//                'living_situation_id' => $this->living_situation_id,
//                'living_situation_case_specification' => $this->living_situation_id != 8 ? $this->living_situation_case_specification : null,
//                'case_specification_id' => $this->living_situation_id == 8 ? $this->case_specification_id : null,
//                'government_program_id' => $this->government_program_id,
//                'living_status_id' => $this->living_status_id,
//                'rent_fee' => $this->living_status_id == 1 ? $this->rent_fee : null,
//                'landlord' => $this->living_status_id == 1 ? $this->landlord : null,
//                'house_owner' => $this->living_status_id == 5 ? $this->house_owner : null,
//                'roof_type_id' => $this->roof_type_id,
//                'wall_type_id' => $this->wall_type_id,
//                'remarks' => $this->remarks ?: 'N/A',
//                'is_tagged' => true,
//                'tagger_name' => $this->tagger_name,
//            ]);
//
//            // Initialize spouse and dependent arrays
//            $spouseData = null;
//            $dependentData = [];
//
//            // Check if civil_status_id is 2 (Married) before creating Spouse record
//            if ($this->civil_status_id == '2') {
//                $spouseData = Spouse::create([
//                    'tagged_and_validated_applicant_id' => $this->applicantId,
//                    'spouse_first_name' => $this->spouse_first_name,
//                    'spouse_middle_name' => $this->spouse_middle_name,
//                    'spouse_last_name' => $this->spouse_last_name,
//                    'spouse_occupation' => $this->spouse_occupation,
//                    'spouse_monthly_income' => $this->spouse_monthly_income,
//                ]);
//            }
//
//            // Validate each dependent
//            foreach ($this->dependents as $dependent) {
//                $this->validate([
//                    'dependent_first_name' => 'nullable|string|max:50',
//                    'dependent_middle_name' => 'nullable|string|max:50',
//                    'dependent_last_name' => 'nullable|string|max:50',
//                    'dependent_sex' => 'nullable|in:Male,Female',
//                    'dependent_date_of_birth' => 'nullable|date',
//                    'dependent_relationship' => 'nullable|string|max:100',
//                    'dependent_occupation' => 'nullable|string|max:255',
//                    'dependent_monthly_income' => 'nullable|integer',
//                ]);
//            }
//
//            // Store images if any
//            if ($this->images) {
//                foreach ($this->images as $index => $image) {
//                    $renamedFileName = $this->renamedFileName[$index] ?? $image->getClientOriginalName();
//                    $path = $image->storeAs('images', $renamedFileName, 'public');
//
//                    ImagesForHousing::create([
//                        'tagged_and_validated_applicant_id' => $this->applicantId,
//                        'image_path' => $path,
//                        'display_name' => $renamedFileName,
//                    ]);
//                }
//            }
//
//            // Find the applicant by ID and update the 'tagged' field
//            $applicant = Applicant::findOrFail($this->applicantId);
//            $applicant->update(['is_tagged' => true]);
//
//            // Prepare data for debugging
//            $dataToDebug = [
//                'taggedApplicant' => $taggedApplicant,
//                'spouse' => $spouseData,
//                'dependents' => $dependentData,
//            ];
//
//            // Dump the relevant data
//            dd($dataToDebug);
//
//            // Flash success message
//            session()->flash('message', 'Applicant has been successfully tagged and validated.');
//
//            return redirect()->route('applicants');
//        } catch (QueryException $e) {
//            session()->flash('error', 'An error occurred while tagging the applicant. Please try again.');
//        }
//    }


    public function render()
    {
        return view('livewire.applicant-details')
            ->layout('layouts.app');  // Ensure this matches your Blade layout path
    }
}
