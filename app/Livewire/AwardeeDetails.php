<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Awardee;
use App\Models\Barangay;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\LivingStatus;
use App\Models\Purok;
use App\Models\Religion;
use App\Models\RoofType;
use App\Models\TransactionType;
use App\Models\Tribe;
use App\Models\WallType;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AwardeeDetails extends Component
{
    public $isEditing = false, $isLoading = false;

    public $awardee, $taggedApplicant, $applicant;
    // Applicant information
    public $transaction_type_id, $transactionTypes, $first_name, $middle_name, $last_name, $suffix_name, $barangay_id, $purok_id, $full_address, $contact_number;
    public $puroks = [], $tribe_id, $sex, $date_of_birth, $religion_id, $occupation, $monthly_income, $family_income,
            $spouse_first_name, $spouse_middle_name, $spouse_last_name, $spouse_occupation, $spouse_monthly_income,
            $partner_first_name, $partner_middle_name, $partner_last_name, $partner_occupation, $partner_monthly_income;

    // Tagged applicant details
    public $civil_status_id, $civilStatuses, $date_applied, $tagging_date, $grant_date,
            $living_situation_id, $livingSituations, $living_status_id, $livingStatuses, $case_specification_id, $caseSpecifications, $living_situation_case_specification,
            $government_program_id, $governmentPrograms, $rent_fee, $landlord, $house_owner, $roof_type_id, $roofTypes, $wall_type_id, $wallTypes,
            $remarks;
    // Dependent's details
    public $dependents = [];
    public $images = [], $imagesForAwarding = [];
    public $selectedImage = null; // This is for the tagging image
    public $selectedAttachment = null; // this is for the awarding attachment

    // For deleting a dependent in Editing mode
    public $showDeleteModal = false, $deletingIndex = null, $confirmationPassword = '', $deleteError = '';
    // Track deleted dependents
    public $deletedDependentIds = [];
    public function mount($applicantId): void
    {
        $this->awardee = Awardee::with([
            'taggedAndValidatedApplicant.applicant.transactionType',
            'taggedAndValidatedApplicant.civilStatus',
            'taggedAndValidatedApplicant.tribe',
            'taggedAndValidatedApplicant.religion',
            'taggedAndValidatedApplicant.livingSituation',
            'taggedAndValidatedApplicant.caseSpecification',
            'taggedAndValidatedApplicant.governmentProgram',
            'taggedAndValidatedApplicant.livingStatus',
            'taggedAndValidatedApplicant.roofType',
            'taggedAndValidatedApplicant.wallType',
            'taggedAndValidatedApplicant.spouse',
            'taggedAndValidatedApplicant.liveInPartner',
            'taggedAndValidatedApplicant.dependents',
            'address.purok',
            'address.barangay',
            'lot',
            'lotSizeUnit'
        ])->findOrFail($applicantId);

        $this->taggedApplicant = $this->awardee->taggedAndValidatedApplicant;
        $this->applicant = $this->taggedApplicant->applicant;
        $this->loadFormData();
    }
    public function loadFormData(): void
    {
        // Load Applicant Information
        $this->transaction_type_id = $this->applicant?->transactionType?->transaction_type_id ?? '--';
        $this->transactionTypes = TransactionType::all();
        $this->first_name = $this->applicant->first_name ?? '--';
        $this->middle_name = $this->applicant->middle_name ?? '--';
        $this->last_name = $this->applicant->last_name ?? '--';
        $this->suffix_name = $this->applicant->suffix_name ?? '--';
        $this->contact_number = $this->applicant?->contact_number ?? '--';
        $this->date_applied = optional($this->applicant?->date_applied)
            ->format('F d, Y') ?? '--';

        // Load Tagged and Validated Applicant Information
        $this->civil_status_id = $this->taggedApplicant?->civil_status_id ?? '--';
        $this->tribe_id = $this->taggedApplicant?->tribe_id ?? '--';
        $this->sex = $this->taggedApplicant?->sex ?? '--';
        $this->date_of_birth = optional($this->taggedApplicant?->date_of_birth)
            ->format('F d, Y') ?? '--';
        $this->religion_id = $this->taggedApplicant?->religion_id ?? '--';
        $this->occupation = $this->taggedApplicant?->occupation ?? '--';
        $this->monthly_income = $this->taggedApplicant?->monthly_income ?? '--';
        $this->family_income = $this->taggedApplicant?->family_income ?? '--';
        $this->tagging_date = optional($this->taggedApplicant?->tagging_date)
            ->format('F d, Y') ?? '--';

        // Load live-in partner information
        $this->partner_first_name = $this->taggedApplicant?->liveInPartner?->partner_first_name ?? '--';
        $this->partner_middle_name = $this->taggedApplicant?->liveInPartner?->partner_middle_name ?? '--';
        $this->partner_last_name = $this->taggedApplicant?->liveInPartner?->partner_last_name ?? '--';
        $this->partner_occupation = $this->taggedApplicant?->liveInPartner?->partner_occupation ?? '--';
        $this->partner_monthly_income = $this->taggedApplicant?->liveInPartner?->partner_monthly_income ?? '--';

        // Load spouse information
        $this->spouse_first_name = $this->taggedApplicant?->spouse?->spouse_first_name ?? '--';
        $this->spouse_middle_name = $this->taggedApplicant?->spouse?->spouse_middle_name ?? '--';
        $this->spouse_last_name = $this->taggedApplicant?->spouse?->spouse_last_name ?? '--';
        $this->spouse_occupation = $this->taggedApplicant?->spouse?->spouse_occupation ?? '--';
        $this->spouse_monthly_income = $this->taggedApplicant?->spouse?->spouse_monthly_income ?? '--';

        $this->grant_date = optional($this->awardee->grant_date)->format('F d, Y') ?? '--';

        // Convert the collection to an array when loading
        $this->dependents = $this->taggedApplicant->dependents->map(function($dependent) {
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
        // Load civil statuses here
        $this->civilStatuses = CivilStatus::all();
        // Load living situation
        $this->living_situation_id = $this->taggedApplicant?->living_situation_id ?? null;
        $this->livingSituations = LivingSituation::all();

        // Load case specification data
        if ($this->taggedApplicant?->living_situation_id == 8) {
            $this->case_specification_id = $this->taggedApplicant?->case_specification_id ?? null;
        } else {
            $this->living_situation_case_specification = $this->taggedApplicant?->living_situation_case_specification ?? '';
        }
        $this->caseSpecifications = CaseSpecification::all();

        // government programs
        $this->government_program_id = $this->taggedApplicant?->government_program_id ?? '--';
        $this->governmentPrograms = GovernmentProgram::all();

        $this->living_status_id = $this->taggedApplicant?->living_status_id ?? '--';
        $this->livingStatuses = LivingStatus::all();

        $this->roof_type_id = $this->taggedApplicant?->roof_type_id ?? '--';
        $this->roofTypes = RoofType::all();

        $this->wall_type_id = $this->taggedApplicant?->wall_type_id ?? '--';
        $this->wallTypes = WallType::all();

        $this->remarks = $this->taggedApplicant?->remarks ?? '--';

        if ($this->living_status_id == 1){
            // Renting
            $this->rent_fee = $this->taggedApplicant?->rent_fee ?? '--';
            $this->landlord = $this->taggedApplicant?->landlord ?? '--';
        } elseif ($this->living_status_id == 5){
            // Just staying in someone's house
            $this->house_owner = $this->taggedApplicant?->house_owner ?? '--';
        }

        // Load Address Information - Store IDs instead of names
        $this->barangay_id = $this->awardee->address?->barangay?->id;
        $this->purok_id = $this->awardee->address?->purok?->id;
        $this->full_address = $this->awardee->address?->full_address ?? '--';
        // Load initial puroks if barangay is selected
        if ($this->barangay_id) {
            $this->puroks = Purok::where('barangay_id', $this->barangay_id)->get();
        }

        $this->images = $this->applicant->taggedAndValidated?->images ?? [];

        $this->imagesForAwarding = $this->applicant->taggedAndValidated?->awardees?->flatMap(function ($awardee) {
            return $awardee->awardeeDocumentsSubmissions()
                ->get()
                ->map(function ($submission) {
                    return $submission->file_name;
                })->filter();
        }) ?? collect();
    }
    // For Awarding pictures
    public function viewAttachment($fileName): void
    {
        $this->selectedAttachment = $fileName;
    }
    public function closeAttachment(): void
    {
        $this->selectedAttachment = null;
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
    public function toggleEdit(): void
    {
        $this->isEditing = !$this->isEditing;
        if (!$this->isEditing) {
            $this->loadFormData(); // Reset form data if canceling edit
        }
    }
    public function rules(): array
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

            // Live-in partner's details
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
                            $fail('Spouse last name is required.');
                        }
                    }
                },
            ],
            'partner_occupation' => [
                function ($attribute, $value, $fail) {
                    if ($this->civil_status_id == 2 && empty($value)) {
                        $fail('Live-in partner\'s occupation is required. Put N/A if none.');
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
            'dependents.*.dependent_civil_status_id' => 'required|exists:civil_statuses,id',
            'dependents.*.dependent_first_name' => 'required|string|max:50',
            'dependents.*.dependent_middle_name' => 'nullable|string|max:50',
            'dependents.*.dependent_last_name' => 'required|string|max:50',
            'dependents.*.dependent_sex' => 'required|in:Male,Female',
            'dependents.*.dependent_date_of_birth' => 'required|date',
            'dependents.*.dependent_relationship' => 'required|string|max:100',
            'dependents.*.dependent_occupation' => 'required|string|max:255',
            'dependents.*.dependent_monthly_income' => 'required|integer',
        ];
    }
    public function saveChanges(): void
    {
        $validatedData = $this->validate();

        // Update Applicant
        $this->applicant->update([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'suffix_name' => $validatedData['suffix_name'],
            'date_applied' => $validatedData['date_applied'],
        ]);

        // Update Tagged Applicant
        $this->taggedApplicant->update([
            'civil_status_id' => $validatedData['civil_status_id'],
            'tribe_id' => $validatedData['tribe_id'],
            'religion_id' => $validatedData['religion_id'],
            'sex' => $validatedData['sex'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'occupation' => $validatedData['occupation'],
            'monthly_income' => $validatedData['monthly_income'],
            'family_income' => $validatedData['family_income'],
            'tagging_date' => $validatedData['tagging_date'],
            'roof_type_id' => $validatedData['roof_type_id'],
            'wall_type_id' => $validatedData['wall_type_id'],

            'living_situation_id' => $validatedData['living_situation_id'],
            'case_specification_id' => $validatedData['case_specification_id'],
            'living_situation_case_specification' => $validatedData['living_situation_case_specification'],
            'government_program_id' => $validatedData['government_program_id'],
            'living_status_id' => $validatedData['living_status_id'],
            'rent_fee' => $validatedData['rent_fee'],
            'remarks' => $validatedData['remarks'],
        ]);

        $this->awardee->address->update([
            'barangay_id' => $validatedData['barangay_id'],
            'purok_id' => $validatedData['purok_id'],
        ]);

        // Save dependents
        $this->taggedApplicant->dependents()->delete(); // Remove existing
        foreach ($this->dependents as $dependent) {
            $this->taggedApplicant->dependents()->create($dependent);
        }

        $this->isEditing = false;
//        session()->flash('message', 'Awardee details updated successfully.');
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

        if ($this->deletingIndex !== null) {
            try {
                $dependentToDelete = $this->dependents[$this->deletingIndex];

                // Delete from database
                if (!empty($dependentToDelete['id'])) {
                    $deleted = $this->taggedApplicant->dependents()
                        ->where('id', $dependentToDelete['id'])
                        ->delete();

                    if ($deleted) {
                        // Only remove from UI if database deletion was successful
                        unset($this->dependents[$this->deletingIndex]);
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
        $this->deletingIndex = $index;
        $this->confirmationPassword = '';
        $this->deleteError = '';
        $this->showDeleteModal = true;
    }
    public function cancelDelete(): void
    {
        $this->showDeleteModal = false;
        $this->deletingIndex = null;
        $this->confirmationPassword = '';
        $this->deleteError = '';
    }

    public function render()
    {
        return view('livewire.awardee-details',[
            'barangays' => Barangay::all(),
            'tribes' => Tribe::all(),
            'religions' => Religion::all(),
            'showRentDetails' => $this->living_status_id == 1,
            'showHouseOwnerDetails' => $this->living_status_id == 5,
        ])->layout('layouts.app');
    }
}
