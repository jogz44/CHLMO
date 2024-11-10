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
    public $showDeleteConfirmationModal = false, $dependentToDelete, $confirmationPassword = '', $deleteError = '';
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
        $this->first_name = $this->taggedAndValidatedApplicant->applicant->first_name ?? null;
        $this->transactionTypes = TransactionType::all();
        $this->middle_name = $this->taggedAndValidatedApplicant->applicant->middle_name ?? null;
        $this->last_name = $this->taggedAndValidatedApplicant->applicant->last_name ?? null;
        $this->suffix_name = $this->taggedAndValidatedApplicant->applicant->suffix_name ?? null;
        $this->contact_number = $this->taggedAndValidatedApplicant->applicant->contact_number ?? null;
        $this->transaction_type_id = $this->taggedAndValidatedApplicant?->applicant->transactionType?->transaction_type_id ?? null;
        $this->date_applied = optional($this->taggedAndValidatedApplicant->applicant->date_applied)
            ->format('F d, Y') ?? null;
        // Load Address Information - Store IDs instead of names
        $this->barangay_id = $this->taggedAndValidatedApplicant->applicant?->address?->barangay?->id;
        $this->purok_id = $this->taggedAndValidatedApplicant->applicant?->address?->purok?->id;
        $this->full_address = $this->taggedAndValidatedApplicant->full_address ?? null;
        $this->occupation = $this->taggedAndValidatedApplicant->occupation ?? null;
        $this->monthly_income = $this->taggedAndValidatedApplicant->family_income ?? null;
        $this->family_income = $this->taggedAndValidatedApplicant->family_income ?? null;
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
                'dependent_relationship' => $dependent->dependent_relationship,
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
    public function addDependent(): void
    {
        $this->dependents[] = [
            'dependent_first_name' => '',
            'dependent_middle_name' => '',
            'dependent_last_name' => '',
            'dependent_sex' => '',
            'dependent_civil_status_id' => '',
            'dependent_date_of_birth' => '',
            'dependent_relationship' => '',
            'dependent_occupation' => '',
            'dependent_monthly_income' => 0,
        ];
    }
    public function removeDependent(): void
    {
        if (!Hash::check($this->confirmationPassword, auth()->user()->password)) {
            $this->deleteError = 'Incorrect password';
            return;
        }

        if ($this->dependentToDelete !== null) {
            try {
                $dependentToDelete = $this->dependents[$this->dependentToDelete];

                // Delete from database
                if (!empty($dependentToDelete['id'])) {
                    $deleted = $this->taggedAndValidatedApplicant->dependents()
                        ->where('id', $dependentToDelete['id'])
                        ->delete();

                    if ($deleted) {
                        // Only remove from UI if database deletion was successful
                        unset($this->dependents[$this->dependentToDelete]);
                        $this->dependents = array_values($this->dependents);

                        // Show success message (optional)
//                        session()->flash('message', 'Dependent successfully deleted.');
                        $this->dispatch('alert', [
                            'title' => 'Dependent deleted!',
                            'message' => 'Dependent has been successfully deleted. <br><small>'. now()->calendar() .'</small>',
                            'type' => 'success'
                        ]);
                    } else {
                        $this->dispatch('alert', [
                            'title' => 'Deletion failed!',
                            'message' => 'Something went wrong. Try again. <br><small>'. now()->calendar() .'</small>',
                            'type' => 'danger'
                        ]);
                        return;
                    }
                }

                $this->cancelDelete();

            } catch (\Exception $e) {
                logger('Error deleting dependent:', ['error' => $e->getMessage()]);
                $this->deleteError = 'Error deleting dependent. Please try again.';
                return;
            }
        }
    }
    public function confirmDelete($index): void
    {
        $this->dependentToDelete = $index;
        $this->confirmationPassword = '';
        $this->deleteError = '';
        $this->showDeleteConfirmationModal = true;
    }
    public function cancelDelete(): void
    {
        $this->showDeleteConfirmationModal = false;
        $this->dependentToDelete = '';
        $this->confirmationPassword = '';
        $this->deleteError = '';
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
    public function update(): void
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'suffix_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:15',
            'barangay_id' => 'required|integer',
            'purok_id' => 'required|integer',
            'date_applied' => 'required|date',
            'transaction_type_id' => 'required|integer',

            'full_address' => 'nullable|string|max:255',
            'civil_status_id' => 'required|integer',
            'tribe_id' => 'required|integer',
            'sex' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date',
            'religion_id' => 'required|integer',
            'occupation' => 'required|string|max:255',
            'monthly_income' => 'required|integer',
            'family_income' => 'required|integer',
            'tagging_date' => 'required|date',
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
            'living_status_id' => 'required|integer',
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
            'roof_type_id' => 'required|integer',
            'wall_type_id' => 'required|integer',
            'remarks' => 'nullable|string|max:255',
            'images.*' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',

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
                        } elseif ($value !== $this->last_name) {
                            $fail('The spouse\'s last name must match the applicant\'s last name.');
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
            'dependents.*.dependent_civil_status_id' => 'required|integer',
            'dependents.*.dependent_first_name' => 'required|string|max:50',
            'dependents.*.dependent_middle_name' => 'nullable|string|max:50',
            'dependents.*.dependent_last_name' => 'required|string|max:50',
            'dependents.*.dependent_sex' => 'required|in:Male,Female',
            'dependents.*.dependent_date_of_birth' => 'required|date',
            'dependents.*.dependent_relationship' => 'required|string|max:100',
            'dependents.*.dependent_occupation' => 'required|string|max:255',
            'dependents.*.dependent_monthly_income' => 'required|integer',
        ]);

        dd([
            'form_data' => $this->all(),
            'original_applicant' => $this->taggedAndValidatedApplicant
        ]);

        $this->taggedAndValidatedApplicant->applicant->first_name = $this->first_name;
        $this->taggedAndValidatedApplicant->applicant->middle_name = $this->middle_name;
        $this->taggedAndValidatedApplicant->applicant->last_name = $this->last_name;
        $this->taggedAndValidatedApplicant->applicant->suffix_name = $this->suffix_name;
        $this->taggedAndValidatedApplicant->applicant->contact_number = $this->contact_number;
        $this->taggedAndValidatedApplicant->applicant->date_applied = $this->date_applied;
        $this->taggedAndValidatedApplicant->applicant->transactionType->transaction_type_id = $this->transaction_type_id;

        // Update address
        $address = $this->taggedAndValidatedApplicant->address;
        if ($address) {
            $address->barangay_id = $this->barangay_id;
            $address->purok_id = $this->purok_id;
            $address->save(); // Don't forget to save the address
        }
        $this->taggedAndValidatedApplicant->full_address = $this->full_address;
        $this->taggedAndValidatedApplicant->civilStatus->civil_status_id = $this->civil_status_id;
        $this->taggedAndValidatedApplicant->tribe->tribe_id = $this->tribe_id;
        $this->taggedAndValidatedApplicant->sex = $this->sex;
        $this->taggedAndValidatedApplicant->date_of_birth = $this->date_of_birth;
        $this->taggedAndValidatedApplicant->religion->religion_id = $this->religion_id;
        $this->taggedAndValidatedApplicant->occupation = $this->occupation;
        $this->taggedAndValidatedApplicant->monthly_income = $this->monthly_income;
        $this->taggedAndValidatedApplicant->family_income = $this->family_income;
        // Live-in partner
        $this->taggedAndValidatedApplicant->liveInPartner->partner_first_name = $this->partner_first_name;
        $this->taggedAndValidatedApplicant->liveInPartner->partner_middle_name = $this->partner_middle_name;
        $this->taggedAndValidatedApplicant->liveInPartner->partner_last_name = $this->partner_last_name;
        $this->taggedAndValidatedApplicant->liveInPartner->partner_occupation = $this->partner_occupation;
        $this->taggedAndValidatedApplicant->liveInPartner->partner_monthly_income = $this->partner_monthly_income;
        // spouse
        $this->taggedAndValidatedApplicant->spouse->spouse_first_name = $this->spouse_first_name;
        $this->taggedAndValidatedApplicant->spouse->spouse_middle_name = $this->spouse_middle_name;
        $this->taggedAndValidatedApplicant->spouse->spouse_last_name = $this->spouse_last_name;
        $this->taggedAndValidatedApplicant->spouse->spouse_occupation = $this->spouse_occupation;
        $this->taggedAndValidatedApplicant->spouse->spouse_monthly_income = $this->spouse_monthly_income;

        $existingDependents = $this->taggedAndValidatedApplicant->dependents;
        foreach ($this->dependents as $updatedDependent){
            $dependent = $existingDependents->firstWhere('id', $updatedDependent['id']);
            if ($dependent){
                // Update existing dependent
                $dependent->dependent_first_name = $updatedDependent['dependent_first_name'];
                $dependent->dependent_middle_name = $updatedDependent['dependent_middle_name'];
                $dependent->dependent_last_name = $updatedDependent['dependent_last_name'];
                $dependent->dependent_sex = $updatedDependent['dependent_sex'];
                $dependent->dependent_civil_status_id = $updatedDependent['dependent_civil_status_id'];
                $dependent->dependent_date_of_birth = $updatedDependent['dependent_date_of_birth'];
                $dependent->dependent_relationship = $updatedDependent['dependent_relationship'];
                $dependent->dependent_occupation = $updatedDependent['dependent_occupation'];
                $dependent->dependent_monthly_income = $updatedDependent['dependent_monthly_income'];
                $dependent->save();
            } else {
                // Create new dependent
                $newDependent = new Dependent([
                    'dependent_first_name' => $updatedDependent['dependent_first_name'],
                    'dependent_middle_name' => $updatedDependent['dependent_middle_name'],
                    'dependent_last_name' => $updatedDependent['dependent_last_name'],
                    'dependent_sex' => $updatedDependent['dependent_sex'],
                    'dependent_civil_status_id' => $updatedDependent['dependent_civil_status_id'],
                    'dependent_date_of_birth' => $updatedDependent['dependent_date_of_birth'],
                    'dependent_relationship' => $updatedDependent['dependent_relationship'],
                    'dependent_occupation' => $updatedDependent['dependent_occupation'],
                    'dependent_monthly_income' => $updatedDependent['dependent_monthly_income'],
                ]);
                $this->taggedAndValidatedApplicant->dependents()->save($newDependent);
            }
        }
        $this->taggedAndValidatedApplicant->tagging_date = $this->tagging_date;
        $this->taggedAndValidatedApplicant->livingSituation->living_situation_id = $this->living_situation_id;
        $this->taggedAndValidatedApplicant->living_situation_case_specification = $this->living_situation_case_specification;
        $this->taggedAndValidatedApplicant->caseSpecification->case_specification_id = $this->case_specification_id;
        $this->taggedAndValidatedApplicant->governmentProgram->government_program_id = $this->government_program_id;
        $this->taggedAndValidatedApplicant->living_status_id = $this->living_status_id;
        $this->taggedAndValidatedApplicant->rent_fee = $this->rent_fee;
        $this->taggedAndValidatedApplicant->landlord = $this->landlord;
        $this->taggedAndValidatedApplicant->house_owner = $this->house_owner;
        $this->taggedAndValidatedApplicant->roofType->roof_type_id = $this->roof_type_id;
        $this->taggedAndValidatedApplicant->wallType->wall_type_id = $this->wall_type_id;
        $this->taggedAndValidatedApplicant->remarks = $this->remarks;

        // Save the updated applicant
        dd($this->taggedAndValidatedApplicant);
        $this->taggedAndValidatedApplicant->save();

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
        return view('livewire.tagged-and-validated-applicant-details', [
            'taggedAndValidatedApplicant' => $this->taggedAndValidatedApplicant,
        ])->layout('layouts.app');
    }
}
