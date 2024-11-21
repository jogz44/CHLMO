<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\Dependent;
use App\Models\DependentsRelationship;
use App\Models\GovernmentProgram;
use App\Models\ImagesForHousing;
use App\Models\LiveInPartner;
use App\Models\LivingSituation;
use App\Models\LivingStatus;
use App\Models\Purok;
use App\Models\Religion;
use App\Models\RelocationSite;
use App\Models\RoofType;
use App\Models\Spouse;
use App\Models\StructureStatusType;
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
    public $applicantId, $applicant;
    public $applicantForSpouse;
    public $transaction_type_id, $transaction_type_name;
    public $first_name, $middle_name, $last_name, $suffix_name, $contact_number, $barangay, $purok;

    // New fields
    public $full_address, $civil_status_id, $civil_statuses, $religion, $tribe;
    public $living_situation_id, $livingSituations, $case_specification_id, $caseSpecifications,
        $living_situation_case_specification, $government_program_id, $governmentPrograms, $living_status_id,
        $livingStatuses, $roof_type_id, $roofTypes, $wall_type_id, $wallTypes, $structure_status_id, $structureStatuses,
        $sex, $date_of_birth, $occupation, $monthly_income, $tagging_date, $rent_fee, $landlord, $house_owner,
        $relationship_to_house_owner, $tagger_name, $years_of_residency, $remarks;

    // Live-in partner's details
    public $partner_first_name, $partner_middle_name, $partner_last_name, $partner_occupation, $partner_monthly_income;
    // Spouse's details
    public $spouse_first_name, $spouse_middle_name, $spouse_last_name, $spouse_occupation, $spouse_monthly_income;

    // Dependent's details
    public $dependents = [], $dependent_civil_status_id, $dependent_civil_statuses, $dependent_relationship_id, $dependentRelationships,
    $images, $renamedFileName = [];

    public $relocation_lot_id, $relocationSites = [];
    public $shouldAssignRelocation = false;
    public $showRelocationModal = false;
    public $showConfirmationModal = false;

    public function mount($applicantId): void
    {
        $this->applicantId = $applicantId;
        $this->applicant = Applicant::with(['person'])->findOrFail($applicantId);
        $person = $this->applicant->person;

        $this->relocationSites = RelocationSite::all();

        // Clear dependents array before populating it again
        $this->dependents = [];

        // Only load dependents for this specific tagged applicant if it exists
        $taggedAndValidatedApplicant = TaggedAndValidatedApplicant::where('applicant_id', $applicantId)
            ->with('dependents')
            ->first();

        if ($taggedAndValidatedApplicant && $taggedAndValidatedApplicant->dependents) {
            // Transform the dependents collection into the expected array format
            $this->dependents = $taggedAndValidatedApplicant->dependents->map(function($dependent) {
                return [
                    'dependent_first_name' => $dependent->dependent_first_name,
                    'dependent_middle_name' => $dependent->dependent_middle_name,
                    'dependent_last_name' => $dependent->dependent_last_name,
                    'dependent_sex' => $dependent->dependent_sex,
                    'dependent_civil_status_id' => $dependent->dependent_civil_status_id,
                    'dependent_date_of_birth' => $dependent->dependent_date_of_birth,
                    'dependent_occupation' => $dependent->dependent_occupation,
                    'dependent_monthly_income' => $dependent->dependent_monthly_income,
                    'dependent_relationship_id' => $dependent->dependent_relationship_id,
                ];
            })->toArray();
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
        // For Dependents
        $this->dependentRelationships = Cache::remember('relationships', 60*60, function() {
            return DependentsRelationship::all();  // Cache for 1 hour
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
        $this->structureStatuses = Cache::remember('structureStatuses', 60*60, function() {
            return StructureStatusType::all();  // Cache for 1 hour
        });

        // Populate fields with applicant data
        $this->first_name = $person->first_name ?? '';
        $this->middle_name = $person->middle_name ?? '';
        $this->last_name = $person->last_name ?? '';
        $this->suffix_name = $person->suffix_name ?? '';
        $this->contact_number = $person->contact_number ?? '';

        // Access the barangay and purok through the address relation
        $this->barangay = $this->applicant->address->barangay->name ?? '';
        $this->purok = $this->applicant->address->purok->name ?? '';

        // Set today's date as the default value for tagged_date
        $this->tagging_date = now()->toDateString(); // YYYY-MM-DD format

        // Set interviewer
        $this->tagger_name = Auth::user()->full_name();
    }

    // Add row for another dependent
    public function add(): void
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
            'dependent_relationship_id' => null,
        ];
    }
    public function remove($index): void
    {
        unset($this->dependents[$index]);
    }
    public function askAboutRelocation(): void
    {
        $this->dispatch('openQuestionModal');
    }
    public function handleRelocationResponse($response): void
    {
        $this->shouldAssignRelocation = $response;
        if ($response) {
            // If Yes was clicked, show the relocation modal
//            $this->showRelocationModal = true;
            $this->showRelocationModal = true;
            $this->shouldAssignRelocation = true;
        } else {
            // If No was clicked, proceed with storage
//            $this->store();
            $this->showConfirmationModal = true;
        }
    }

    protected function rules(): array
    {
        return [
            // pipe syntax
            'full_address' => 'nullable|string|max:255',
            'civil_status_id' => 'nullable|exists:civil_statuses,id',
            'tribe' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date',
            'religion' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'monthly_income' => 'required|integer',
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
            'relationship_to_house_owner' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,5',
                'string',
                'max:255'
            ],
            'roof_type_id' => 'required|exists:roof_types,id',
            'wall_type_id' => 'required|exists:wall_types,id',
            'structure_status_id' => 'required|exists:structure_status_types,id',
            'relocation_lot_id' => [
                'required_if:shouldAssignRelocation,true',
                'nullable',
                'exists:relocation_sites,id'
            ],
            'years_of_residency' => [
                'required',
                'integer',
                'digits:4', // Ensures it’s exactly 4 digits
                'between:1900,2099' // Restricts the value between 1900 and 2099
            ],
            'remarks' => 'nullable|string|max:255',
            'images' => 'required|image|max:2048',

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
            'partner_occupation' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 2 && empty($value)) {
                        $fail('Live-in partner\'s occupation is required.');
                    }
                },
            ],
            'partner_monthly_income' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 2 && empty($value)) {
                        $fail('Live-in partner\'s monthly income is required.');
                    } elseif ($this->civil_status_id == 2 && !is_numeric($value)) {
                        $fail('Live-in partner\'s monthly income must be a number.');
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
                        } 
                    }
                },
            ],
            'spouse_occupation' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 3 && empty($value)) {
                        $fail('Spouse occupation is required.');
                    }
                },
            ],
            'spouse_monthly_income' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 3 && empty($value)) {
                        $fail('Spouse monthly income is required.');
                    } elseif ($this->civil_status_id == 3 && !is_numeric($value)) {
                        $fail('Spouse monthly income must be a number.');
                    }
                },
            ],

            // Dependent's details
            'dependents.*.dependent_civil_status_id' => 'required|exists:civil_statuses,id',
            'dependents.*.dependent_first_name' => 'required|string|max:50',
            'dependents.*.dependent_middle_name' => 'nullable|string|max:50',
            'dependents.*.dependent_last_name' => 'required|string|max:50',
            'dependents.*.dependent_sex' => 'required|in:Male,Female',
            'dependents.*.dependent_date_of_birth' => 'required|date',
            'dependents.*.dependent_occupation' => 'required|string|max:255',
            'dependents.*.dependent_monthly_income' => 'required|integer|min:0',
            'dependents.*.dependent_relationship_id' => 'required|exists:dependents_relationships,id',
        ];
    }
    public function confirmRelocation(): void
    {
        // Validate relocation data before proceeding
        $this->validate([
            'relocation_lot_id' => 'required|exists:relocation_sites,id',
        ]);
        // If validation passes,
        $this->showConfirmationModal = true;
    }
    public function store()
    {
        // Only proceed if either relocation is not required OR relocation data is provided
        if (!$this->shouldAssignRelocation || ($this->shouldAssignRelocation && $this->relocation_lot_id)) {

            // Validate the input data
            $this->validate();

            \Log::info('Creating tagged applicant', ['is_tagged' => true]);

            DB::beginTransaction();

            // Attempt to create the new tagged and validated applicant record
            try {
                $taggedApplicant = TaggedAndValidatedApplicant::create([
                    'applicant_id' => $this->applicantId,
                    'transaction_type_id' => $this->transaction_type_id,
                    'full_address' => $this->full_address ?: null,
                    'civil_status_id' => $this->civil_status_id,
                    'tribe' => $this->tribe,
                    'sex' => $this->sex,
                    'date_of_birth' => $this->date_of_birth,
                    'religion' => $this->religion ?: null,
                    'occupation' => $this->occupation ?: null,
                    'monthly_income' => $this->monthly_income,
                    'tagging_date' => $this->tagging_date,
                    'living_situation_id' => $this->living_situation_id,
                    'living_situation_case_specification' => $this->living_situation_id != 8 ? $this->living_situation_case_specification : null, // Store only for 1-7, 9
                    'case_specification_id' => $this->living_situation_id == 8 ? $this->case_specification_id : null, // Only for 8
                    'government_program_id' => $this->government_program_id,
                    'living_status_id' => $this->living_status_id,
                    'rent_fee' => $this->living_status_id == 1 ? $this->rent_fee : null, // Store rent fee only if living_status_id is 1,
                    'landlord' => $this->living_status_id == 1 ? $this->landlord : null, // Store landlord only if living_status_id is 1,
                    'house_owner' => $this->living_status_id == 5 ? $this->house_owner : null, // Store house owner only if living_status_id is 5,
                    'relationship_to_house_owner' => $this->living_status_id == 5 ? $this->relationship_to_house_owner : null,
                    'roof_type_id' => $this->roof_type_id,
                    'wall_type_id' => $this->wall_type_id,
                    'structure_status_id' => $this->structure_status_id,
                    'relocation_lot_id' => $this->relocation_lot_id,
                    'years_of_residency' => $this->years_of_residency ?: 'N/A',
                    'remarks' => $this->remarks ?: 'N/A',
                    // These two are auto-generated
                    'is_tagged' => true,
                    'tagger_name' => $this->tagger_name,
                ]);

                // Check if civil_status_id is 2 (Live-in) before creating LiveInPartner record
                if ($this->civil_status_id == '2') {
                    LiveInPartner::create([
                        'tagged_and_validated_applicant_id' => $taggedApplicant->id, // Link live-in partner to the applicant
                        'partner_first_name' => $this->partner_first_name,
                        'partner_middle_name' => $this->partner_middle_name,
                        'partner_last_name' => $this->partner_last_name,
                        'partner_occupation' => $this->partner_occupation,
                        'partner_monthly_income' => $this->partner_monthly_income,
                    ]);
                }

                // Check if civil_status_id is 3 (Married) before creating Spouse record
                if ($this->civil_status_id == '3') {
                    Spouse::create([
                        'tagged_and_validated_applicant_id' => $taggedApplicant->id, // Link spouse to the applicant
                        'spouse_first_name' => $this->spouse_first_name,
                        'spouse_middle_name' => $this->spouse_middle_name,
                        'spouse_last_name' => $this->spouse_last_name,
                        'spouse_occupation' => $this->spouse_occupation,
                        'spouse_monthly_income' => $this->spouse_monthly_income,
                    ]);
                }

                // batching the database for large data
                $dependentData = [];
                // Create dependent records associated with the applicant
                foreach ($this->dependents as $dependent) {
                    $dependentData[] = ([
                        'tagged_and_validated_applicant_id' => $taggedApplicant->id,
                        'dependent_first_name' => $dependent['dependent_first_name'] ?: null,
                        'dependent_middle_name' => $dependent['dependent_middle_name'] ?: null,
                        'dependent_last_name' => $dependent['dependent_last_name'] ?: null,
                        'dependent_sex' => $dependent['dependent_sex'] ?: null,
                        'dependent_civil_status_id' => $dependent['dependent_civil_status_id'] ?: null,
                        'dependent_date_of_birth' => $dependent['dependent_date_of_birth'] ?: null,
                        'dependent_occupation' => $dependent['dependent_occupation'] ?: null,
                        'dependent_monthly_income' => $dependent['dependent_monthly_income'] ?: null,
                        'dependent_relationship_id' => $dependent['dependent_relationship_id'] ?: null,
                    ]);
                }

                Dependent::insert($dependentData);

                if ($this->images) {
                    $path = $this->images->store('images', 'public');
                    ImagesForHousing::create([
                        'tagged_and_validated_applicant_id' => $taggedApplicant->id,
                        'image_path' => $path,
                        'display_name' => $this->images->getClientOriginalName(),
                    ]);
                }

                // Add relocation_lot_id if it was set
//                if ($this->shouldAssignRelocation && $this->relocation_lot_id) {
//                    $data['relocation_lot_id'] = $this->relocation_lot_id;
//                }

                // Find the applicant by ID and update the 'tagged' field
                $applicant = Applicant::findOrFail($this->applicantId);
                $applicant->update(['is_tagged' => true]);

                DB::commit();

                $this->dispatch('alert', [
                    'title' => 'Tagging successful!',
                    'message' => 'Applicant has been successfully tagged and validated. <br><small>'. now()->calendar() .'</small>',
                    'type' => 'success'
                ]);
                $this->dependents = [];

                return redirect()->route('applicants');

            } catch (QueryException $e) {
                DB::rollBack();
                \Log::error('Error creating applicant or dependents: ' . $e->getMessage());
                $this->dispatch('alert', [
                    'title' => 'Something went wrong!',
                    'message' => $e->getMessage() . '<br><small>'. now()->calendar() .'</small>',
                    'type' => 'danger'
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.applicant-details')
            ->layout('layouts.app');  // Ensure this matches your Blade layout path
    }
}
