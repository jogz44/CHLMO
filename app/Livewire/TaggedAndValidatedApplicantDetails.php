<?php

namespace App\Livewire;

use App\Livewire\Logs\ActivityLogs;
use App\Models\Applicant;
use App\Models\Awardee;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\Dependent;
use App\Models\DependentsRelationship;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\LivingStatus;
use App\Models\Purok;
use App\Models\Religion;
use App\Models\RelocationSite;
use App\Models\RoofType;
use App\Models\TaggedAndValidatedApplicant;
use App\Models\TaggedDocumentsSubmission;
use App\Models\TransactionType;
use App\Models\Tribe;
use App\Models\WallType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TaggedAndValidatedApplicantDetails extends Component
{
    use WithFileUploads;

    public $applicant;
    public $taggedAndValidatedApplicant;
    public $isEditing = false, $isLoading = false, $originalData = []; // Add new properties for edit mode

    public $applicantForSpouse;
    public $transaction_type;
    public $first_name, $middle_name, $last_name, $suffix_name, $contact_number, $barangay_id, $barangays, $purok_id, $puroks,
            $date_applied;

    // New fields
    public $full_address, $civil_status_id, $civilStatuses, $religion, $tribe;
    public $living_situation_id, $livingSituations, $case_specification_id, $caseSpecifications, $living_situation_case_specification,
        $government_program_id, $governmentPrograms, $living_status_id, $livingStatuses, $roof_type_id, $roofTypes, $wall_type_id,
        $wallTypes, $sex, $date_of_birth, $occupation, $monthly_income, $years_of_residency, $voters_id_number,
        $tagging_date, $rent_fee, $landlord,
        $house_owner, $tagger_name, $remarks;

    // Live-in partner's details
    public $partner_first_name, $partner_middle_name, $partner_last_name, $partner_occupation, $partner_monthly_income;
    // Spouse's details
    public $spouse_first_name, $spouse_middle_name, $spouse_last_name, $spouse_occupation, $spouse_monthly_income;

    // Dependent's details
    public $dependents = [], $dependent_civil_status_id, $dependent_civilStatuses, $dependent_relationship_id,
        $dependentRelationships, $renamedFileName = [];
    public $showDeleteConfirmationModal = false, $dependentToDelete, $confirmationPassword = '', $deleteError = '';
    public $images = [], $imagesForTagging = [];
    public $selectedImage = null; // This is for the tagging image
    public $selectedAttachment = null; // this is for the awarding attachment

    public $taggedDocuments = [];
    public $selectedDocument = null;

    // Modal states for each group
    public $showPrimaryInfoModal = false, $showDependentsModal = false, $showLivingSituationModal = false,
        $showPhotosModal = false, $newPhotos = [], $photosToDelete = [];
    public $editDependents = [], $editPhotos = [];
    public $confirmingDependentRemoval = false, $dependentIndexToRemove = null, $passwordConfirmation = '';
    // Edit temporary data
    public $editPrimaryInfo = [
        'full_address' => '',
        'civil_status_id' => '',
        'tribe' => '',
        'sex' => '',
        'date_of_birth' => '',
        'religion' => '',
        'occupation' => '',
        'monthly_income' => '',
        'length_of_residency' => '',
        'voters_id_number' => '',
        // Partner fields
        'partner_first_name' => '',
        'partner_middle_name' => '',
        'partner_last_name' => '',
        'partner_occupation' => '',
        'partner_monthly_income' => '',
        // Spouse fields
        'spouse_first_name' => '',
        'spouse_middle_name' => '',
        'spouse_last_name' => '',
        'spouse_occupation' => '',
        'spouse_monthly_income' => '',
    ];

    public $editLivingSituation = [
        'date_tagged' => '',
        'living_situation_id' => '',
        'case_specification_id' => '',
        'living_situation_case_specification' => '',
        'social_welfare_sector' => '',
        'living_status' => '',
        'room_rent_fee' => '',
        'room_landlord' => '',
        'house_rent_fee' => '',
        'house_landlord' => '',
        'lot_rent_fee' => '',
        'lot_landlord' => '',
        'house_owner' => '',
        'relationship_to_house_owner' => '',
        'roof_type' => '',
        'wall_type' => '',
        'transaction_type' => '',
        'remarks' => '',
    ];

    // For assigning relocation site
    public $applicantId, $tagged_and_validated_applicant_id, $relocationSites = [];
    public $showAssignSiteModal = false;
    public $selected_relocation_site_id = '';
    public $assigned_lot, $assigned_block;
    public $lot_size_allocation = '';
    public $allocationUnit = 'square meters'; // Default unit

    // For updating relocation site - Actual Relocation Site -->
    public $showActualSiteModal = false;
    public $actual_relocation_site_id = '';
    public $actual_lot = '';
    public $actual_block = '';
    public $actual_lot_size = '';

    public function mount()
    {
        $this->applicantId = request()->route('applicantId');

        $this->taggedAndValidatedApplicant = TaggedAndValidatedApplicant::with([
            'applicant.person',
            'applicant.address.purok',
            'applicant.address.barangay',
            'livingSituation',
            'caseSpecification',
            'governmentProgram',
            'livingStatus',
            'civilStatus',
            'liveInPartner',
            'spouse',
            'roofType',
            'wallType',
            'taggedDocuments'
        ])->findOrFail($this->applicantId);

        $this->tagged_and_validated_applicant_id = $this->taggedAndValidatedApplicant->id;
        $this->taggedDocuments = $this->taggedAndValidatedApplicant->taggedDocuments;

        // Add this debug
        if($this->taggedDocuments->count() > 0) {
            \Log::info('First document path:', [
                'file_path' => $this->taggedDocuments->first()->file_path,
                'url' => Storage::disk('tagging-house-structure-images')->url($this->taggedDocuments->first()->file_path)
            ]);
        }

        $this->loadFormData();
        $this->resetPrimaryInfoForm();
        $this->resetDependentsForm();
        $this->resetLivingSituationForm();
        $this->resetPhotosData();
    }

    public function getFormattedDateOfBirthProperty(): string
    {
        return $this->date_of_birth
            ? Carbon::parse($this->date_of_birth)->format('F d, Y')
            : 'N/A';
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
        $this->dependentRelationships = Cache::remember('dependentsRelationships', 60*60, function () {
            return DependentsRelationship::all(); // Cache for 1 hour
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
        $this->first_name = $this->taggedAndValidatedApplicant->applicant->person->first_name ?? null;
        $this->middle_name = $this->taggedAndValidatedApplicant->applicant->person->middle_name ?? null;
        $this->last_name = $this->taggedAndValidatedApplicant->applicant->person->last_name ?? null;
        $this->suffix_name = $this->taggedAndValidatedApplicant->applicant->person->suffix_name ?? null;
        $this->contact_number = $this->taggedAndValidatedApplicant->applicant->person->contact_number ?? null;
        $this->transaction_type = $this->taggedAndValidatedApplicant?->applicant->transaction_type ?? null;
        $this->date_applied = optional($this->taggedAndValidatedApplicant->applicant->date_applied)
            ->format('F d, Y') ?? null;
        // Load Address Information - Store IDs instead of names
        $this->barangay_id = $this->taggedAndValidatedApplicant->applicant?->address?->barangay?->id;
        $this->purok_id = $this->taggedAndValidatedApplicant->applicant?->address?->purok?->id;
        $this->full_address = $this->taggedAndValidatedApplicant->full_address ?? null;
        $this->occupation = $this->taggedAndValidatedApplicant->occupation ?? null;
        $this->tribe = $this->taggedAndValidatedApplicant->tribe ?? null;
        $this->sex = $this->taggedAndValidatedApplicant->sex;
        $this->date_of_birth = $this->taggedAndValidatedApplicant->date_of_birth;
        $this->religion = $this->taggedAndValidatedApplicant->religion ?? null;
        $this->monthly_income = $this->taggedAndValidatedApplicant->monthly_income ?? null;
        $this->years_of_residency = $this->taggedAndValidatedApplicant->years_of_residency ?? null;
        $this->voters_id_number = $this->taggedAndValidatedApplicant->voters_id_number ?? null;
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
                'dependent_relationship' => $dependent->dependentRelationship->relationship,
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
    public function viewDocument($documentId): void
    {
        $this->selectedDocument = $this->taggedDocuments->find($documentId);
    }
    public function closeDocument(): void
    {
        $this->selectedDocument = null;
    }

    // Methods for handling Primary information editing
    public function openPrimaryInfoModal(): void
    {
        $this->editPrimaryInfo = [
            'full_address' => $this->taggedAndValidatedApplicant->full_address,
            'civil_status_id' => $this->taggedAndValidatedApplicant->civil_status_id,
            'tribe' => $this->taggedAndValidatedApplicant->tribe,
            'sex' => $this->taggedAndValidatedApplicant->sex,
            'date_of_birth' => $this->taggedAndValidatedApplicant->date_of_birth,
            'religion' => $this->taggedAndValidatedApplicant->religion,
            'occupation' => $this->taggedAndValidatedApplicant->occupation,
            'monthly_income' => $this->taggedAndValidatedApplicant->monthly_income,
            'length_of_residency' => $this->taggedAndValidatedApplicant->years_of_residency,
            'voters_id_number' => $this->taggedAndValidatedApplicant->voters_id_number,
            // Partner fields
            'partner_first_name' => $this->taggedAndValidatedApplicant->liveInPartner->partner_first_name ?? '',
            'partner_middle_name' => $this->taggedAndValidatedApplicant->liveInPartner->partner_middle_name ?? '',
            'partner_last_name' => $this->taggedAndValidatedApplicant->liveInPartner->partner_last_name ?? '',
            'partner_occupation' => $this->taggedAndValidatedApplicant->liveInPartner->partner_occupation ?? '',
            'partner_monthly_income' => $this->taggedAndValidatedApplicant->liveInPartner->partner_monthly_income ?? '',
            // Spouse fields
            'spouse_first_name' => $this->taggedAndValidatedApplicant->spouse->spouse_first_name ?? '',
            'spouse_middle_name' => $this->taggedAndValidatedApplicant->spouse->spouse_middle_name ?? '',
            'spouse_last_name' => $this->taggedAndValidatedApplicant->spouse->spouse_last_name ?? '',
            'spouse_occupation' => $this->taggedAndValidatedApplicant->spouse->spouse_occupation ?? '',
            'spouse_monthly_income' => $this->taggedAndValidatedApplicant->spouse->spouse_monthly_income ?? '',
        ];

        $this->showPrimaryInfoModal = true;
    }

    protected function primaryInfoValidationRules()
    {
        return [
            'editPrimaryInfo.full_address' => 'nullable|string|max:255',
            'editPrimaryInfo.civil_status_id' => 'required|exists:civil_statuses,id',
            'editPrimaryInfo.tribe' => 'required|string|max:255',
            'editPrimaryInfo.sex' => 'required|in:Male,Female',
            'editPrimaryInfo.date_of_birth' => 'required|date',
            'editPrimaryInfo.religion' => 'required|string|max:255',
            'editPrimaryInfo.occupation' => 'required|string|max:255',
            'editPrimaryInfo.monthly_income' => 'required|numeric|min:0',
            'editPrimaryInfo.length_of_residency' => 'required|integer|min:0',
            'editPrimaryInfo.voters_id_number' => 'nullable|string|max:255',

            // Conditional validation for partner details
            'editPrimaryInfo.partner_first_name' => 'required_if:editPrimaryInfo.civil_status_id,2|string|max:255|nullable',
            'editPrimaryInfo.partner_middle_name' => 'nullable|string|max:255',
            'editPrimaryInfo.partner_last_name' => 'required_if:editPrimaryInfo.civil_status_id,2|string|max:255|nullable',
            'editPrimaryInfo.partner_occupation' => 'required_if:editPrimaryInfo.civil_status_id,2|string|max:255|nullable',
            'editPrimaryInfo.partner_monthly_income' => 'required_if:editPrimaryInfo.civil_status_id,2|numeric|min:0|nullable',

            // Conditional validation for spouse details
            'editPrimaryInfo.spouse_first_name' => 'required_if:editPrimaryInfo.civil_status_id,3|string|max:255|nullable',
            'editPrimaryInfo.spouse_middle_name' => 'nullable|string|max:255',
            'editPrimaryInfo.spouse_last_name' => 'required_if:editPrimaryInfo.civil_status_id,3|string|max:255|nullable',
            'editPrimaryInfo.spouse_occupation' => 'required_if:editPrimaryInfo.civil_status_id,3|string|max:255|nullable',
            'editPrimaryInfo.spouse_monthly_income' => 'required_if:editPrimaryInfo.civil_status_id,3|numeric|min:0|nullable',
        ];
    }

    protected $messages = [
        'editPrimaryInfo.civil_status_id.required' => 'The civil status field is required.',
        'editPrimaryInfo.tribe.required' => 'The tribe/ethnicity field is required.',
        'editPrimaryInfo.sex.required' => 'The sex field is required.',
        'editPrimaryInfo.date_of_birth.required' => 'The date of birth field is required.',
        'editPrimaryInfo.religion.required' => 'The religion field is required.',
        'editPrimaryInfo.occupation.required' => 'The occupation field is required.',
        'editPrimaryInfo.monthly_income.required' => 'The monthly income field is required.',
        'editPrimaryInfo.length_of_residency.required' => 'The length of residency field is required.',

        // Partner validation messages
        'editPrimaryInfo.partner_first_name.required_if' => 'Partner\'s first name is required.',
        'editPrimaryInfo.partner_last_name.required_if' => 'Partner\'s last name is required.',
        'editPrimaryInfo.partner_occupation.required_if' => 'Partner\'s occupation is required.',
        'editPrimaryInfo.partner_monthly_income.required_if' => 'Partner\'s monthly income is required.',

        // Spouse validation messages
        'editPrimaryInfo.spouse_first_name.required_if' => 'Spouse\'s first name is required.',
        'editPrimaryInfo.spouse_last_name.required_if' => 'Spouse\'s last name is required.',
        'editPrimaryInfo.spouse_occupation.required_if' => 'Spouse\'s occupation is required.',
        'editPrimaryInfo.spouse_monthly_income.required_if' => 'Spouse\'s monthly income is required.',
    ];

    public function updatePrimaryInfo(): void
    {
        $this->validate($this->primaryInfoValidationRules());

        try {
            DB::beginTransaction();

            // Update primary information
            $this->taggedAndValidatedApplicant->update([
                'full_address' => $this->editPrimaryInfo['full_address'],
                'civil_status_id' => $this->editPrimaryInfo['civil_status_id'],
                'tribe' => $this->editPrimaryInfo['tribe'],
                'sex' => $this->editPrimaryInfo['sex'],
                'date_of_birth' => $this->editPrimaryInfo['date_of_birth'],
                'religion' => $this->editPrimaryInfo['religion'],
                'occupation' => $this->editPrimaryInfo['occupation'],
                'monthly_income' => $this->editPrimaryInfo['monthly_income'],
                'years_of_residency' => $this->editPrimaryInfo['length_of_residency'],
                'voters_id_number' => $this->editPrimaryInfo['voters_id_number'],
            ]);

            // Handle live-in partner information
            if ($this->editPrimaryInfo['civil_status_id'] == 2) {
                $this->taggedAndValidatedApplicant->liveInPartner()->updateOrCreate(
                    ['tagged_and_validated_applicant_id' => $this->taggedAndValidatedApplicant->id],
                    [
                        'partner_first_name' => $this->editPrimaryInfo['partner_first_name'],
                        'partner_middle_name' => $this->editPrimaryInfo['partner_middle_name'],
                        'partner_last_name' => $this->editPrimaryInfo['partner_last_name'],
                        'partner_occupation' => $this->editPrimaryInfo['partner_occupation'],
                        'partner_monthly_income' => $this->editPrimaryInfo['partner_monthly_income'],
                    ]
                );
            } else {
                // Delete partner information if civil status is not live-in
                $this->taggedAndValidatedApplicant->liveInPartner()->delete();
            }

            // Handle spouse information
            if ($this->editPrimaryInfo['civil_status_id'] == 3) {
                $this->taggedAndValidatedApplicant->spouse()->updateOrCreate(
                    ['tagged_and_validated_applicant_id' => $this->taggedAndValidatedApplicant->id],
                    [
                        'spouse_first_name' => $this->editPrimaryInfo['spouse_first_name'],
                        'spouse_middle_name' => $this->editPrimaryInfo['spouse_middle_name'],
                        'spouse_last_name' => $this->editPrimaryInfo['spouse_last_name'],
                        'spouse_occupation' => $this->editPrimaryInfo['spouse_occupation'],
                        'spouse_monthly_income' => $this->editPrimaryInfo['spouse_monthly_income'],
                    ]
                );
            } else {
                // Delete spouse information if civil status is not married
                $this->taggedAndValidatedApplicant->spouse()->delete();
            }

            DB::commit();

            // Log the activity
            $logger = new ActivityLogs();
            $logger->logActivity(
                'Updated primary information for applicant: ' . $this->taggedAndValidatedApplicant->applicant->applicant_id,
                Auth::user()
            );

            // Reset the modal and show success message
            $this->showPrimaryInfoModal = false;
            $this->dispatch('alert', [
                'title' => 'Success!',
                'message' => 'Primary information updated successfully',
                'type' => 'success'
            ]);

            // Refresh the applicant data
            $this->taggedAndValidatedApplicant = $this->taggedAndValidatedApplicant->fresh();
            $this->loadFormData();

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error updating primary information: ' . $e->getMessage());

            $this->dispatch('alert', [
                'title' => 'Error!',
                'message' => 'Failed to update information. Please try again.',
                'type' => 'danger'
            ]);
        }
    }

    public function updatedEditPrimaryInfoCivilStatusId($value): void
    {
        if ($value == 1) { // Single
            $this->resetSpouseAndPartnerFields();
        }
    }

    private function resetSpouseAndPartnerFields(): void
    {
        $fields = [
            'partner_first_name', 'partner_middle_name', 'partner_last_name',
            'partner_occupation', 'partner_monthly_income',
            'spouse_first_name', 'spouse_middle_name', 'spouse_last_name',
            'spouse_occupation', 'spouse_monthly_income'
        ];

        foreach ($fields as $field) {
            $this->editPrimaryInfo[$field] = '';
        }
    }

    // Method to handle civil status changes
    public function updatedEditPrimaryCivilStatusId($value): void
    {
        // If changing to single, reset spouse/partner fields
        if ($value == 1) { // Assuming 1 is single
            $this->spouse_first_name = null;
            $this->spouse_middle_name = null;
            $this->spouse_last_name = null;
            $this->spouse_occupation = null;
            $this->spouse_monthly_income = null;

            $this->partner_first_name = null;
            $this->partner_middle_name = null;
            $this->partner_last_name = null;
            $this->partner_occupation = null;
            $this->partner_monthly_income = null;
        }
    }
    // method to reset form
    public function resetPrimaryInfoForm(): void
    {
        $this->reset('editPrimaryInfo');
        $this->resetValidation();
    }

    // Methods for handling Dependents editing
    public function openDependentsModal(): void
    {
        // Load current dependents into edit array
        $this->editDependents = $this->taggedAndValidatedApplicant->dependents->map(function($dependent) {
            return [
                'id' => $dependent->id,
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

        $this->showDependentsModal = true;
    }
    public function addDependentRow(): void
    {
        $this->editDependents[] = [
            'id' => null, // Important for distinguishing new records
            'dependent_first_name' => '',
            'dependent_middle_name' => '',
            'dependent_last_name' => '',
            'dependent_sex' => '',
            'dependent_civil_status_id' => '',
            'dependent_date_of_birth' => '',
            'dependent_relationship_id' => '',
            'dependent_occupation' => '',
            'dependent_monthly_income' => '',
            'tagged_and_validated_applicant_id' => $this->taggedAndValidatedApplicant->id
        ];
    }
    public function updateDependents(): void
    {
        $this->validate([
            'editDependents.*.dependent_first_name' => 'required|string|max:255',
            'editDependents.*.dependent_middle_name' => 'nullable|string|max:255',
            'editDependents.*.dependent_last_name' => 'required|string|max:255',
            'editDependents.*.dependent_sex' => 'required|in:Male,Female',
            'editDependents.*.dependent_civil_status_id' => 'required|exists:civil_statuses,id',
            'editDependents.*.dependent_date_of_birth' => 'required|date',
            'editDependents.*.dependent_occupation' => 'required|string|max:255',
            'editDependents.*.dependent_monthly_income' => 'required|numeric|min:0',
            'editDependents.*.dependent_relationship_id' => 'required|exists:dependents_relationships,id',
        ]);

        try {
            DB::beginTransaction();

            // Get current dependent IDs
            $currentDependentIds = collect($this->editDependents)
                ->pluck('id')
                ->filter()
                ->toArray();

            // Delete dependents that are no longer in the list
            $this->taggedAndValidatedApplicant->dependents()
                ->whereNotIn('id', $currentDependentIds)
                ->delete();

            // Update or create dependents
            foreach ($this->editDependents as $dependentData) {
                $id = $dependentData['id'] ?? null;
                $dependentData['tagged_and_validated_applicant_id'] = $this->taggedAndValidatedApplicant->id;

                if ($id) {
                    // Update existing dependent
                    Dependent::where('id', $id)->update($dependentData);
                } else {
                    // Create new dependent
                    unset($dependentData['id']); // Remove null id if it exists
                    Dependent::create($dependentData);
                }
            }

            DB::commit();

            // Log the activity
            $logger = new ActivityLogs();
            $logger->logActivity(
                'Updated dependents for applicant: ' . $this->taggedAndValidatedApplicant->applicant->applicant_id,
                Auth::user()
            );

            $this->showDependentsModal = false;
            $this->dispatch('alert', [
                'title' => 'Success!',
                'message' => 'Dependents updated successfully',
                'type' => 'success'
            ]);

            // Refresh the data
            $this->taggedAndValidatedApplicant = $this->taggedAndValidatedApplicant->fresh(['dependents']);
            $this->loadFormData();

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error updating dependents: ' . $e->getMessage());

            $this->dispatch('alert', [
                'title' => 'Error!',
                'message' => 'Failed to update dependents. Please try again.',
                'type' => 'danger'
            ]);
        }
    }
    public function confirmDependentRemoval($index): void
    {
        $this->dependentIndexToRemove = $index;
        $this->confirmingDependentRemoval = true;
        $this->passwordConfirmation = '';
    }
    public function removeDependentRow(): void
    {
        // Validate password
        $this->validate([
            'passwordConfirmation' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('The password is incorrect.');
                    }
                },
            ],
        ]);

        if (is_null($this->dependentIndexToRemove)) {
            return;
        }

        // If password is valid, proceed with removal
        unset($this->editDependents[$this->dependentIndexToRemove]);
        $this->editDependents = array_values($this->editDependents);

        // Reset confirmation state
        $this->confirmingDependentRemoval = false;
        $this->dependentIndexToRemove = null;
        $this->passwordConfirmation = '';

        // Show success message
        $this->dispatch('alert', [
            'title' => 'Success!',
            'message' => 'Dependent removed successfully',
            'type' => 'success'
        ]);
    }
    // Add this method to handle cancellation
    public function cancelDependentRemoval(): void
    {
        $this->confirmingDependentRemoval = false;
        $this->dependentIndexToRemove = null;
        $this->passwordConfirmation = '';
    }
    public function resetDependentsForm(): void
    {
        $this->reset('editDependents');
        $this->resetValidation();
    }
    protected $dependentMessages = [
        'editDependents.*.dependent_first_name.required' => 'The first name field is required.',
        'editDependents.*.dependent_last_name.required' => 'The last name field is required.',
        'editDependents.*.dependent_sex.required' => 'The sex field is required.',
        'editDependents.*.dependent_civil_status_id.required' => 'The civil status field is required.',
        'editDependents.*.dependent_date_of_birth.required' => 'The date of birth field is required.',
        'editDependents.*.dependent_occupation.required' => 'The occupation field is required.',
        'editDependents.*.dependent_monthly_income.required' => 'The monthly income field is required.',
        'editDependents.*.dependent_relationship_id.required' => 'The relationship field is required.',
    ];


    // Methods for handling living situation editing
    // Add validation rules for living situation
    protected function getLivingSituationRules(): array
    {
        $rules = [
            'editLivingSituation.living_situation_id' => 'required|exists:living_situations,id',
            'editLivingSituation.social_welfare_sector' => 'required|exists:government_programs,id',
            'editLivingSituation.living_status' => 'required|exists:living_statuses,id',
            'editLivingSituation.roof_type' => 'required|exists:roof_types,id',
            'editLivingSituation.wall_type' => 'required|exists:wall_types,id',
            'editLivingSituation.remarks' => 'nullable|string|max:255',
        ];

        // Add conditional validation rules based on living status
        switch ($this->editLivingSituation['living_status']) {
            case '1': // Room Rent
                $rules['editLivingSituation.room_rent_fee'] = 'required|numeric|min:0';
                $rules['editLivingSituation.room_landlord'] = 'required|string|max:255';
                break;
            case '2': // House Rent
                $rules['editLivingSituation.house_rent_fee'] = 'required|numeric|min:0';
                $rules['editLivingSituation.house_landlord'] = 'required|string|max:255';
                break;
            case '3': // Lot Rent
                $rules['editLivingSituation.lot_rent_fee'] = 'required|numeric|min:0';
                $rules['editLivingSituation.lot_landlord'] = 'required|string|max:255';
                break;
            case '8': // Living with Others
                $rules['editLivingSituation.house_owner'] = 'required|string|max:255';
                $rules['editLivingSituation.relationship_to_house_owner'] = 'required|string|max:255';
                break;
        }

        // Living Situation specific rules
        if ($this->editLivingSituation['living_situation_id'] == 8) {
            $rules['editLivingSituation.case_specification_id'] = 'required|exists:case_specifications,id';
        } else {
            $rules['editLivingSituation.living_situation_case_specification'] = 'required|string|max:255';
        }

        return $rules;
    }

    // Add custom messages for living situation validation
    protected $livingSituationMessages = [
        'editLivingSituation.living_situation_id.required' => 'The living situation field is required.',
        'editLivingSituation.case_specification_id.required' => 'The case specification field is required.',
        'editLivingSituation.living_situation_case_specification.required' => 'The case specification field is required.',
        'editLivingSituation.social_welfare_sector.required' => 'The social welfare sector field is required.',
        'editLivingSituation.living_status.required' => 'The living status field is required.',
        'editLivingSituation.roof_type.required' => 'The roof type field is required.',
        'editLivingSituation.wall_type.required' => 'The wall type field is required.',
    ];

    public function openLivingSituationModal(): void
    {
        $this->editLivingSituation = [
            'date_tagged' => $this->taggedAndValidatedApplicant->tagging_date,
            'living_situation_id' => $this->taggedAndValidatedApplicant->living_situation_id,
            'case_specification_id' => $this->taggedAndValidatedApplicant->case_specification_id,
            'living_situation_case_specification' => $this->taggedAndValidatedApplicant->living_situation_case_specification,
            'social_welfare_sector' => $this->taggedAndValidatedApplicant->government_program_id,
            'living_status' => $this->taggedAndValidatedApplicant->living_status_id,
            'roof_type' => $this->taggedAndValidatedApplicant->roof_type_id,
            'wall_type' => $this->taggedAndValidatedApplicant->wall_type_id,
            'remarks' => $this->taggedAndValidatedApplicant->remarks,
            // Add all status-specific fields
            'room_rent_fee' => $this->taggedAndValidatedApplicant->room_rent_fee,
            'room_landlord' => $this->taggedAndValidatedApplicant->room_landlord,
            'house_rent_fee' => $this->taggedAndValidatedApplicant->house_rent_fee,
            'house_landlord' => $this->taggedAndValidatedApplicant->house_landlord,
            'lot_rent_fee' => $this->taggedAndValidatedApplicant->lot_rent_fee,
            'lot_landlord' => $this->taggedAndValidatedApplicant->lot_landlord,
            'house_owner' => $this->taggedAndValidatedApplicant->house_owner,
            'relationship_to_house_owner' => $this->taggedAndValidatedApplicant->relationship_to_house_owner,
        ];

        $this->showLivingSituationModal = true;
    }

    public function updatedEditLivingSituationLivingSituationId($value): void
    {
        // Instead of resetting all fields, only reset fields that don't correspond to the current status
        switch ($value) {
            case '1': // Room Rent
                // Keep room fields, reset others
                $this->editLivingSituation['house_rent_fee'] = null;
                $this->editLivingSituation['house_landlord'] = null;
                $this->editLivingSituation['lot_rent_fee'] = null;
                $this->editLivingSituation['lot_landlord'] = null;
                $this->editLivingSituation['house_owner'] = null;
                $this->editLivingSituation['relationship_to_house_owner'] = null;
                break;
            case '2': // House Rent
                $this->editLivingSituation['room_rent_fee'] = null;
                $this->editLivingSituation['room_landlord'] = null;
                $this->editLivingSituation['lot_rent_fee'] = null;
                $this->editLivingSituation['lot_landlord'] = null;
                $this->editLivingSituation['house_owner'] = null;
                $this->editLivingSituation['relationship_to_house_owner'] = null;
                break;
            case '3': // Lot Rent
                $this->editLivingSituation['room_rent_fee'] = null;
                $this->editLivingSituation['room_landlord'] = null;
                $this->editLivingSituation['house_rent_fee'] = null;
                $this->editLivingSituation['house_landlord'] = null;
                $this->editLivingSituation['house_owner'] = null;
                $this->editLivingSituation['relationship_to_house_owner'] = null;
                break;
            case '8': // Living with Others
                $this->editLivingSituation['room_rent_fee'] = null;
                $this->editLivingSituation['room_landlord'] = null;
                $this->editLivingSituation['house_rent_fee'] = null;
                $this->editLivingSituation['house_landlord'] = null;
                $this->editLivingSituation['lot_rent_fee'] = null;
                $this->editLivingSituation['lot_landlord'] = null;
                break;
        }
    }

    public function updateLivingSituation(): void
    {
        $this->validate($this->getLivingSituationRules(), $this->livingSituationMessages);

        try {
            DB::beginTransaction();

            $updateData = [
                'living_situation_id' => $this->editLivingSituation['living_situation_id'],
                'government_program_id' => $this->editLivingSituation['social_welfare_sector'],
                'living_status_id' => $this->editLivingSituation['living_status'],
                'roof_type_id' => $this->editLivingSituation['roof_type'],
                'wall_type_id' => $this->editLivingSituation['wall_type'],
                'remarks' => $this->editLivingSituation['remarks'],
            ];

            // Handle living situation specific fields
            if ($this->editLivingSituation['living_situation_id'] == 8) {
                $updateData['case_specification_id'] = $this->editLivingSituation['case_specification_id'];
                $updateData['living_situation_case_specification'] = null;
            } else {
                $updateData['case_specification_id'] = null;
                $updateData['living_situation_case_specification'] = $this->editLivingSituation['living_situation_case_specification'];
            }

            // Handle living status specific fields
            switch ($this->editLivingSituation['living_status']) {
                case '1':
                    $updateData += [
                        'room_rent_fee' => $this->editLivingSituation['room_rent_fee'],
                        'room_landlord' => $this->editLivingSituation['room_landlord'],
                    ];
                    break;
                case '2':
                    $updateData += [
                        'house_rent_fee' => $this->editLivingSituation['house_rent_fee'],
                        'house_landlord' => $this->editLivingSituation['house_landlord'],
                    ];
                    break;
                case '3':
                    $updateData += [
                        'lot_rent_fee' => $this->editLivingSituation['lot_rent_fee'],
                        'lot_landlord' => $this->editLivingSituation['lot_landlord'],
                    ];
                    break;
                case '8':
                    $updateData += [
                        'house_owner' => $this->editLivingSituation['house_owner'],
                        'relationship_to_house_owner' => $this->editLivingSituation['relationship_to_house_owner'],
                    ];
                    break;
            }

            $this->taggedAndValidatedApplicant->update($updateData);

            DB::commit();

            // Log the activity
            $logger = new ActivityLogs();
            $logger->logActivity(
                'Updated living situation for applicant: ' . $this->taggedAndValidatedApplicant->applicant->applicant_id,
                Auth::user()
            );

            $this->showLivingSituationModal = false;
            $this->dispatch('alert', [
                'title' => 'Success!',
                'message' => 'Living situation updated successfully',
                'type' => 'success'
            ]);

            // Refresh the data
            $this->taggedAndValidatedApplicant = $this->taggedAndValidatedApplicant->fresh();
            $this->loadFormData();

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error updating living situation: ' . $e->getMessage());

            $this->dispatch('alert', [
                'title' => 'Error!',
                'message' => 'Failed to update living situation. Please try again.',
                'type' => 'danger'
            ]);
        }
    }

    public function resetLivingSituationForm(): void
    {
        $this->reset('editLivingSituation');
        $this->resetValidation();
    }

    // Methods for handling Photos editing
    protected function rules()
    {
        return [
            'newPhotos.*' => 'image|max:20048' // 2MB Max
        ];
    }

    protected $photosValidationMessages = [
        'newPhotos.*.image' => 'File :index must be an image.',
        'newPhotos.*.max' => 'File :index must not be larger than 2MB.',
    ];

    public function openPhotosModal(): void
    {
        $this->resetPhotosData();
        $this->showPhotosModal = true;
    }

    public function removePhoto($documentId): void
    {
        try {
            $document = TaggedDocumentsSubmission::findOrFail($documentId);

            // Add to photos to delete array
            $this->photosToDelete[] = [
                'id' => $document->id,
                'file_path' => $document->file_path
            ];

            // Remove from current documents array
            $this->taggedDocuments = $this->taggedDocuments->filter(function($doc) use ($documentId) {
                return $doc->id !== $documentId;
            });

        } catch (\Exception $e) {
            $this->dispatch('alert', [
                'title' => 'Error!',
                'message' => 'Failed to remove photo. Please try again.',
                'type' => 'danger'
            ]);
        }
    }

    public function removeNewPhoto($index): void
    {
        unset($this->newPhotos[$index]);
        $this->newPhotos = array_values($this->newPhotos);
    }

    public function updatePhotos(): void
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Delete marked photos
            foreach ($this->photosToDelete as $photo) {
                $document = TaggedDocumentsSubmission::find($photo['id']);
                if ($document) {
                    // Delete file from storage
                    Storage::disk('tagging-house-structure-images')->delete($photo['file_path']);
                    // Delete record
                    $document->delete();
                }
            }

            // Store new photos
            foreach ($this->newPhotos as $photo) {
                $fileName = time() . '_' . $photo->getClientOriginalName();
                $filePath = $photo->storeAs('documents', $fileName, 'tagging-house-structure-images');

                TaggedDocumentsSubmission::create([
                    'tagged_applicant_id' => $this->taggedAndValidatedApplicant->id,
                    'file_path' => $filePath,
                    'file_name' => $fileName,
                    'file_type' => $photo->getClientOriginalExtension(),
                    'file_size' => $photo->getSize(),
                ]);
            }

            DB::commit();

            // Log the activity
            $logger = new ActivityLogs();
            $logger->logActivity(
                'Updated photos for applicant: ' . $this->taggedAndValidatedApplicant->applicant->applicant_id,
                Auth::user()
            );

            $this->showPhotosModal = false;
            $this->dispatch('alert', [
                'title' => 'Success!',
                'message' => 'Photos updated successfully',
                'type' => 'success'
            ]);

            // Refresh the data
            $this->taggedAndValidatedApplicant = $this->taggedAndValidatedApplicant->fresh(['taggedDocuments']);
            $this->loadFormData();

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error updating photos: ' . $e->getMessage());

            $this->dispatch('alert', [
                'title' => 'Error!',
                'message' => 'Failed to update photos. Please try again.',
                'type' => 'danger'
            ]);
        }
    }

    private function resetPhotosData(): void
    {
        $this->reset(['newPhotos', 'photosToDelete']);
        $this->resetValidation();
    }

    // Add to handle temporary file cleanup
    public function cleanupOldUploads(): void
    {
        $storage = Storage::disk('livewire-tmp');

        // Delete files older than 24 hours
        foreach ($storage->allFiles() as $filePathname) {
            // Get the last modified time of the file
            try {
                if (now()->diffInHours($storage->lastModified($filePathname)) > 24) {
                    $storage->delete($filePathname);
                }
            } catch (\Exception $e) {
                logger()->error('Error cleaning up old upload: ' . $e->getMessage());
            }
        }
    }

    // Assigning Relocation Site
    public function openAssignSiteModal(): void
    {
        // Get only relocation sites that aren't full
        $this->relocationSites = RelocationSite::where('is_full', false)
            ->with('awardees') // Eager load awardees to prevent N+1 queries
            ->get()
            ->map(function ($site) {
                $availableSpace = $site->total_no_of_lots
                    - $site->community_facilities_road_lots_open_space
                    - $site->awardees()->sum('assigned_relocation_lot_size');

                return [
                    'id' => $site->id,
                    'name' => $site->relocation_site_name,
                    'available_space' => $availableSpace
                ];
            })
            ->filter(function ($site) {
                return $site['available_space'] > 0;
            })
            ->values() // Re-index the array after filtering
            ->toArray(); // Convert to array explicitly

        $this->selected_relocation_site_id = ''; // Reset selection
        $this->assigned_lot = '';
        $this->assigned_block = '';
        $this->lot_size_allocation = '';
        $this->allocationUnit = 'square meters'; // Reset to default unit

        $this->showAssignSiteModal = true;
    }

    // Method for assigning the relocation site and create awardee record
    public function assignRelocationSite()
    {
        $this->validate([
            'selected_relocation_site_id' => 'required|exists:relocation_sites,id',
            'assigned_lot' => 'required|string|max:100',
            'assigned_block' => 'required|string|max:100',
            'lot_size_allocation' => 'required|numeric|min:1'
        ]);

        try {
            DB::beginTransaction();

            // Fetch the relocation site and calculate available space
            $relocationSite = RelocationSite::findOrFail($this->selected_relocation_site_id);

            // Check available space
            $availableSpace = $relocationSite->getRemainingLotSize();

            if ($this->lot_size_allocation > $availableSpace) {
                $this->addError('lot_size_allocation', 'Requested lot size exceeds available space');
                return;
            }

            // Create new awardee record
            Awardee::create([
                'tagged_and_validated_applicant_id' => $this->tagged_and_validated_applicant_id,
                'assigned_relocation_site_id' => $this->selected_relocation_site_id,
                'assigned_lot' => $this->assigned_lot,
                'assigned_block' => $this->assigned_block,
                'assigned_relocation_lot_size' => $this->lot_size_allocation,
                'unit' => $this->allocationUnit,
                'has_assigned_relocation_site' => true,
                'documents_submitted' => false,
                'is_awarded' => false,
                'is_blacklisted' => false
            ]);

            // Update relocation site status
            $relocationSite->refresh(); // Refresh the model to get latest data
            $relocationSite->updateFullStatus();

            DB::commit();

            // Log the activity
            $logger = new ActivityLogs();
            $logger->logActivity(
                'Assigned relocation site to tagged and validated applicant ID: ' . $this->tagged_and_validated_applicant_id,
                Auth::user()
            );

            $this->showAssignSiteModal = false;
            $this->reset(['selected_relocation_site_id', 'lot_size_allocation', 'assigned_lot', 'assigned_block']);

            $this->dispatch('alert', [
                'title' => 'Success!',
                'message' => 'Relocation site assigned successfully',
                'type' => 'success'
            ]);

            // Redirect back to the same page to refresh it
            return redirect()->route('tagged-and-validated-applicant-details', ['applicantId' => $this->tagged_and_validated_applicant_id]);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error assigning relocation site: ' . $e->getMessage());

            $this->dispatch('alert', [
                'title' => 'Error!',
                'message' => 'Failed to assign relocation site. Please try again.',
                'type' => 'danger'
            ]);
        }
    }

    // Method to get available space for selected site
    public function getAvailableSpace()
    {
        if (!$this->selected_relocation_site_id) {
            return 0;
        }

        $site = RelocationSite::find($this->selected_relocation_site_id);
        if (!$site) {
            return 0;
        }

        return ($site->total_no_of_lots - $site->community_facilities_road_lots_open_space) -
            $site->awardees()->sum('assigned_relocation_lot_size');
    }

    // For updating relocation site - Actual Relocation Site
    public function openActualSiteModal(): void
    {
        $awardee = $this->taggedAndValidatedApplicant->awardees->first();

        // Load relocation sites
        $this->relocationSites = RelocationSite::select('id', 'relocation_site_name')
            ->get()
            ->map(function ($site) {
                return [
                    'id' => $site->id,
                    'name' => $site->relocation_site_name
                ];
            })
            ->toArray();

        // Initialize with current values if they exist
        $this->actual_relocation_site_id = $awardee->actual_relocation_site_id ?? '';
        $this->actual_lot_size = $awardee->actual_relocation_lot_size ?? '';
        $this->actual_lot = $awardee->actual_lot ?? '';
        $this->actual_block = $awardee->actual_block ?? '';

        $this->showActualSiteModal = true;
    }

    public function updateActualSite()
    {
        $this->validate([
            'actual_relocation_site_id' => 'required|exists:relocation_sites,id',
            'actual_lot' => 'required|string|max:100',
            'actual_block' => 'required|string|max:100',
            'actual_lot_size' => 'required|numeric|min:1'
        ]);

        try {
            DB::beginTransaction();

            // Get the awardee record
            $awardee = $this->taggedAndValidatedApplicant->awardees->first();

            // Update the awardee with actual site information
            $awardee->update([
                'actual_relocation_site_id' => $this->actual_relocation_site_id,
                'actual_lot' => $this->actual_lot,
                'actual_block' => $this->actual_block,
                'actual_relocation_lot_size' => $this->actual_lot_size,
            ]);

            // Update status for both assigned and actual relocation sites
            $awardee->assignedRelocationSite->updateFullStatus();
            if ($awardee->actualRelocationSite) {
                $awardee->actualRelocationSite->updateFullStatus();
            }

            DB::commit();

            // Log the activity
            $logger = new ActivityLogs();
            $logger->logActivity(
                'Assigned actual relocation site to awardee ID: ' . $awardee->id,
                Auth::user()
            );

            $this->showActualSiteModal = false;
            $this->reset(['actual_relocation_site_id', 'actual_lot_size', 'actual_lot', 'actual_block']);
            $this->dispatch('alert', [
                'title' => 'Success!',
                'message' => 'Actual relocation site updated successfully',
                'type' => 'success'
            ]);

            // Redirect back to the same page to refresh it
            return redirect()->route('tagged-and-validated-applicant-details', ['applicantId' => $this->tagged_and_validated_applicant_id]);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error updating actual relocation site: ' . $e->getMessage());

            $this->dispatch('alert', [
                'title' => 'Error!',
                'message' => 'Failed to update actual relocation site. Please try again.',
                'type' => 'danger'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.tagged-and-validated-applicant-details', [
            'taggedAndValidatedApplicant' => $this->taggedAndValidatedApplicant,
        ])->layout('layouts.app');
    }
}
