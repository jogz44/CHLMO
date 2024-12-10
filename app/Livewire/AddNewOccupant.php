<?php

namespace App\Livewire;

use App\Livewire\Logs\ActivityLogs;
use App\Models\Address;
use App\Models\Applicant;
use App\Models\Awardee;
use App\Models\AwardeeTransferHistory;
use App\Models\Barangay;
use App\Models\Blacklist;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\Dependent;
use App\Models\DependentsRelationship;
use App\Models\GovernmentProgram;
use App\Models\LiveInPartner;
use App\Models\LivingSituation;
use App\Models\LivingStatus;
use App\Models\People;
use App\Models\Purok;
use App\Models\RoofType;
use App\Models\Spouse;
use App\Models\StructureStatusType;
use App\Models\TaggedAndValidatedApplicant;
use App\Models\TaggedDocumentsSubmission;
use App\Models\WallType;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddNewOccupant extends Component
{
    public $previousAwardeeData;
    public $isTransfer = false;

    use WithFileUploads;
    public $applicantId, $applicant, $taggedApplicant;
    public $applicantForSpouse;

    // Form fields
    public $first_name, $middle_name, $last_name, $suffix_name, $contact_number,
        $relationship, $reason_for_transfer,
        $barangay_id, $barangays = [], $purok_id, $puroks = [], $full_address, $transaction_type, $civil_status_id,
        $civil_statuses, $religion, $tribe, $living_situation_id, $livingSituations, $case_specification_id,
        $caseSpecifications, $living_situation_case_specification, $non_informal_settler_case_specification, $government_program_id, $governmentPrograms,
        $living_status_id, $livingStatuses, $roof_type_id, $roofTypes, $wall_type_id, $wallTypes, $structure_status_id,
        $structureStatuses, $sex, $date_of_birth, $occupation, $monthly_income, $tagging_date, $room_rent_fee, $room_landlord,
        $house_rent_fee, $house_landlord, $lot_rent_fee, $lot_landlord, $house_owner, $relationship_to_house_owner,
        $tagger_name, $years_of_residency, $voters_id_number, $remarks;

    // Live-in partner's details
    public $partner_first_name, $partner_middle_name, $partner_last_name, $partner_occupation, $partner_monthly_income;
    // Spouse's details
    public $spouse_first_name, $spouse_middle_name, $spouse_last_name, $spouse_occupation, $spouse_monthly_income;

    // Dependent's details
    public $dependents = [], $dependent_civil_status_id, $dependent_civil_statuses, $dependent_relationship_id, $dependentRelationships; // For preview purposes
    public $renamedFileName = [];
    public $showConfirmationModal = false;

    // For uploading of files
    public $isFilePondUploadComplete = false, $isFilePonduploading = false, $selectedApplicant, $files,
        $applicantToPreview, $isUploading = false, $attachmentLists = [], $awardeeId, $documents = [], $newFileImages = [];
    public $houseStructureImages = [];
    protected $listeners = ['fileUploadFinished' => 'handleFileUploadFinished'];

    public $previousSpecifications = [];
    public $previousNonInformalSpecifications = [];
    public $showSuggestions = false;

    public function handleFileUploadFinished(): void
    {
        $this->isFilePondUploadComplete = true;
    }

    public function mount($applicantId = null): void
    {
        // Check if this is a transfer case
        $this->previousAwardeeData = session('transfer_data');
        $this->isTransfer = !empty($this->previousAwardeeData);

        // Initialize the dependents array
        $this->dependents = [];

        // Initialize cache for all dropdown data
        $this->puroks = Cache::remember('puroks', 60*60, function() {
            return Purok::all();
        });

        $this->barangays = Cache::remember('barangays', 60*60, function() {
            return Barangay::all();
        });

        $this->civil_statuses = Cache::remember('civil_statuses', 60*60, function() {
            return CivilStatus::all();
        });

        $this->dependent_civil_statuses = Cache::remember('civil_statuses', 60*60, function() {
            return CivilStatus::all();
        });

        $this->dependentRelationships = Cache::remember('relationships', 60*60, function() {
            return DependentsRelationship::all();
        });

        $this->livingSituations = Cache::remember('livingSituations', 60*60, function() {
            return LivingSituation::all();
        });

        $this->caseSpecifications = Cache::remember('caseSpecifications', 60*60, function() {
            return CaseSpecification::all();
        });

        $this->governmentPrograms = Cache::remember('governmentPrograms', 60*60, function() {
            return GovernmentProgram::all();
        });

        $this->livingStatuses = Cache::remember('livingStatuses', 60*60, function() {
            return LivingStatus::all();
        });

        $this->roofTypes = Cache::remember('roofTypes', 60*60, function() {
            return RoofType::all();
        });

        $this->wallTypes = Cache::remember('wallTypes', 60*60, function() {
            return WallType::all();
        });

        $this->structureStatuses = Cache::remember('structureStatuses', 60*60, function() {
            return StructureStatusType::all();
        });

        // Clear any existing transfer session data when accessing directly
        if (!request()->has('transfer')) {
            session()->forget('transfer_data');
            $this->isTransfer = false;
            $this->previousAwardeeData = null;
        } else {
            // Only load transfer data if specifically accessing via transfer
            $this->previousAwardeeData = session('transfer_data');
            $this->isTransfer = !empty($this->previousAwardeeData);
        }

        // Reset transfer-specific fields
        if (!$this->isTransfer) {
            $this->relationship = null;
            $this->reason_for_transfer = null;
        }

        // Set default values
        $this->tagger_name = Auth::user()->full_name;
        $this->houseStructureImages = [];
        $this->isFilePondUploadComplete = false;
        $this->isFilePonduploading = false;

        // Handle specific applicant if ID is provided
        if ($applicantId) {
            $this->applicantId = $applicantId;
            $this->applicant = Applicant::with(['person'])->findOrFail($applicantId);
            $person = $this->applicant->person;

            // Load dependents for this specific tagged applicant if it exists
            $taggedAndValidatedApplicant = TaggedAndValidatedApplicant::where('applicant_id', $applicantId)
                ->with('dependents')
                ->first();

            if ($taggedAndValidatedApplicant && $taggedAndValidatedApplicant->dependents) {
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
        }

        // Get unique case specifications from the database
        $this->previousSpecifications = TaggedAndValidatedApplicant::whereNotNull('living_situation_case_specification')
            ->distinct()
            ->pluck('living_situation_case_specification')
            ->toArray();

        $this->previousNonInformalSpecifications = TaggedAndValidatedApplicant::whereNotNull('non_informal_settler_case_specification')
            ->distinct()
            ->pluck('non_informal_settler_case_specification')
            ->toArray();
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
            'dependent_monthly_income' => 0,
            'dependent_relationship_id' => null,
        ];
    }

    public function remove($index): void
    {
        unset($this->dependents[$index]);
    }

    public function updatedBarangayId($barangayId): void
    {
        // Fetch the puroks based on the selected barangay
        $this->puroks = Purok::where('barangay_id', $barangayId)->get();
        $this->purok_id = null; // Reset selected purok when barangay changes
        $this->isLoading = false; // Reset loading state
        logger()->info('Retrieved Puroks', [
            'barangay_id' => $barangayId,
            'puroks' => $this->puroks
        ]);
    }
    protected function rules(): array
    {
        $rules = [
            // people table
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'suffix_name' => 'nullable|string|max:50',
            'contact_number' => [
                'required',
                'regex:/^09\d{9}$/'
            ],
            // tagged_and_validated_applicants table
            /** from the applicants table */
            'barangay_id' => 'required|exists:barangays,id',
            'purok_id' => 'required|exists:puroks,id',
            'transaction_type' => 'nullable|string|max:100|default:Walk-in',
            /** from the applicants table */

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
                'required_if:living_situation_id,1,2,3,4,5,6,7',
                'string',
                'max:255'
            ],
            'case_specification_id' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_situation_id,8', // Only required if living_situation_id is 8
                'exists:case_specifications,id'
            ],
            'non_informal_settler_case_specification' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_situation_id,9',
                'string',
                'max:255'
            ],
            'government_program_id' => 'required|exists:government_programs,id',
            'living_status_id' => 'required|exists:living_statuses,id',
            'room_rent_fee' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,1', // Only required if living_status_id is 1
                'integer'
            ],
            'room_landlord' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,1',
                'string',
                'max:255'
            ],
            'house_rent_fee' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,2', // Only required if living_status_id is 2
                'integer'
            ],
            'house_landlord' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,2',
                'string',
                'max:255'
            ],
            'lot_rent_fee' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,3', // Only required if living_status_id is 3
                'integer'
            ],
            'lot_landlord' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,3',
                'string',
                'max:255'
            ],
            'house_owner' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,8',
                'string',
                'max:255'
            ],
            'relationship_to_house_owner' => [
                'nullable', // Allow it to be null if not required
                'required_if:living_status_id,8',
                'string',
                'max:255'
            ],
            'roof_type_id' => 'required|exists:roof_types,id',
            'wall_type_id' => 'required|exists:wall_types,id',
            'structure_status_id' => 'required|exists:structure_status_types,id',
            'years_of_residency' => [
                'required',
                'integer',
            ],
            'voters_id_number' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
            'houseStructureImages.*' => 'required|image|max:2048', // Validate each image

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

        if ($this->isTransfer) {
            $rules['relationship'] = 'required|string|max:255';
            $rules['reason_for_transfer'] = 'required|string|max:255';
            // more fields here
        }

        return $rules;
    }

    public function updatedHouseStructureImages(): void
    {
        if (!is_array($this->houseStructureImages)) {
            $this->houseStructureImages = [$this->houseStructureImages];
        }

        try {
            \Log::info('Files being uploaded:', [
                'count' => count($this->houseStructureImages),
                'files' => collect($this->houseStructureImages)->map(fn($file) => [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ])
            ]);

            $this->validate([
                'houseStructureImages.*' => 'image|max:2048'
            ]);

            $this->isFilePondUploadComplete = true;
        } catch (\Exception $e) {
            \Log::error('Upload validation error:', [
                'error' => $e->getMessage()
            ]);
            $this->isFilePondUploadComplete = false;
            throw $e;
        }
    }

    public function removeUpload($property, $fileName, $load): void
    {
        if (Storage::disk('tagging-house-structure-images')->exists($fileName)) {
            Storage::disk('tagging-house-structure-images')->delete($fileName);
        }

        // Also remove temporary files if they exist
        $tempPath = storage_path('livewire-tmp/' . $fileName);
        if (file_exists($tempPath)) {
            try {
                unlink($tempPath);
            } catch (\Exception $e) {
                Log::error('Failed to delete temporary file: ' . $e->getMessage());
            }
        }
        $load('');
    }

    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $tmpPath = storage_path('livewire-tmp');
            // Delete files older than 24 hours
            foreach (glob("$tmpPath/*") as $file) {
                if (time() - filemtime($file) > 24 * 3600) {
                    unlink($file);
                }
            }
        })->daily();
    }

    public function updatedAwardeeUpload(): void
    {
        $this->isFilePondUploadComplete = true;
        $this->validate([
            'houseStructureImages.*' => 'required|image|max:2048', // Validate each image
        ]);
    }

    protected function getValidationData(): array
    {
        return [
            // people table
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'suffix_name' => $this->suffix_name,
            'contact_number' => $this->contact_number,
            'barangay_id' => $this->barangay_id,
            'purok_id' => $this->purok_id,
            'transaction_type' => $this->transaction_type,
            'applicantId' => $this->applicantId,
            'full_address' => $this->full_address,
            'civil_status_id' => $this->civil_status_id,
            'tribe' => $this->tribe,
            'sex' => $this->sex,
            'date_of_birth' => $this->date_of_birth,
            'religion' => $this->religion,
            'occupation' => $this->occupation,
            'monthly_income' => $this->monthly_income,
            'tagging_date' => $this->tagging_date,
            'living_situation_id' => $this->living_situation_id,
            'living_situation_case_specification' => $this->living_situation_case_specification,
            'case_specification_id' => $this->case_specification_id,
            'non_informal_settler_case_specification' => $this->non_informal_settler_case_specification,
            'government_program_id' => $this->government_program_id,
            'living_status_id' => $this->living_status_id,
            'room_rent_fee' => $this->room_rent_fee,
            'room_landlord' => $this->room_landlord,
            'house_rent_fee' => $this->house_rent_fee,
            'house_landlord' => $this->house_landlord,
            'lot_rent_fee' => $this->lot_rent_fee,
            'lot_landlord' => $this->lot_landlord,
            'house_owner' => $this->house_owner,
            'relationship_to_house_owner' => $this->relationship_to_house_owner,
            'roof_type_id' => $this->roof_type_id,
            'wall_type_id' => $this->wall_type_id,
            'structure_status_id' => $this->structure_status_id,
            'years_of_residency' => $this->years_of_residency,
            'voters_id_number' => $this->voters_id_number,
            'remarks' => $this->remarks,
            'dependents' => $this->dependents,
            // Live-in partner details
            'partner_first_name' => $this->partner_first_name ?? null,
            'partner_middle_name' => $this->partner_middle_name ?? null,
            'partner_last_name' => $this->partner_last_name ?? null,
            'partner_occupation' => $this->partner_occupation ?? null,
            'partner_monthly_income' => $this->partner_monthly_income ?? null,
            // Spouse details
            'spouse_first_name' => $this->spouse_first_name ?? null,
            'spouse_middle_name' => $this->spouse_middle_name ?? null,
            'spouse_last_name' => $this->spouse_last_name ?? null,
            'spouse_occupation' => $this->spouse_occupation ?? null,
            'spouse_monthly_income' => $this->spouse_monthly_income ?? null,
            // House structure images
            'houseStructureImages' => $this->houseStructureImages ?? []
        ];
    }

    public function store()
    {
        Log::info('Store method triggered', [
            'is_transfer' => $this->isTransfer,
            'form_data' => $this->getValidationData()  // Log all form data
        ]);


        try {
            $validatedData = $this->validate($this->rules());
            Log::info('Validation passed');

            DB::beginTransaction();
            Log::info('Transaction started');

            // 1. Create person record
            $person = People::create([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'suffix_name' => $this->suffix_name,
                'contact_number' => $this->contact_number,
                'application_type' => 'Housing Applicant'
            ]);
            Log::info('Person record created', ['person_id' => $person->id]);

            // 2. Create address record
            $address = Address::create([
                'barangay_id' => $this->barangay_id,
                'purok_id' => $this->purok_id,
                'full_address' => $this->full_address
            ]);
            Log::info('Address record created', ['address_id' => $address->id]);

            // 3. Create applicant record (always create for consistency)
            $applicant = Applicant::create([
                'applicant_id' => Applicant::generateApplicantId(),
                'person_id' => $person->id,
                'user_id' => auth()->id(),
                'address_id' => $address->id,
                'date_applied' => now(),
                'initially_interviewed_by' => auth()->user()->full_name,
                'transaction_type' => $this->isTransfer ? 'Transfer' : 'Tagged Applicant',
                'is_tagged' => true
            ]);
            Log::info('Applicant record created', ['applicant_id' => $applicant->id]);

            // 4. Create Tagged and Validated Applicant (without applicant fields)
            $taggedApplicant = TaggedAndValidatedApplicant::create([
                'applicant_id' => $applicant->id,  // Add this line to link to the new applicant
                'civil_status_id' => $this->civil_status_id,
                'tribe' => $this->tribe,
                'sex' => $this->sex,
                'date_of_birth' => $this->date_of_birth,
                'religion' => $this->religion ?: null,
                'occupation' => $this->occupation ?: null,
                'monthly_income' => $this->monthly_income,
                'tagging_date' => $this->tagging_date,
                'living_situation_id' => $this->living_situation_id,
                'living_situation_case_specification' => $this->living_situation_id != 8 && $this->living_situation_id != 9?
                    $this->living_situation_case_specification : null,
                'case_specification_id' => $this->living_situation_id == 8 ?
                    $this->case_specification_id : null,
                'non_informal_settler_case_specification' => $this->living_situation_id == 9 ?
                    $this->non_informal_settler_case_specification : null,
                'government_program_id' => $this->government_program_id,
                'living_status_id' => $this->living_status_id,
                'room_rent_fee' => $this->living_status_id == 1 ? $this->room_rent_fee : null,
                'room_landlord' => $this->living_status_id == 1 ? $this->room_landlord : null,
                'house_rent_fee' => $this->living_status_id == 2 ? $this->house_rent_fee : null,
                'house_landlord' => $this->living_status_id == 2 ? $this->house_landlord : null,
                'lot_rent_fee' => $this->living_status_id == 3 ? $this->lot_rent_fee : null,
                'lot_landlord' => $this->living_status_id == 3 ? $this->lot_landlord : null,
                'house_owner' => $this->living_status_id == 5 ? $this->house_owner : null,
                'relationship_to_house_owner' => $this->living_status_id == 5 ?
                    $this->relationship_to_house_owner : null,
                'roof_type_id' => $this->roof_type_id,
                'wall_type_id' => $this->wall_type_id,
                'structure_status_id' => $this->structure_status_id,
                'years_of_residency' => $this->years_of_residency ?: 'N/A',
                'voters_id_number' => $this->voters_id_number ?: 'N/A',
                'remarks' => $this->remarks ?: 'N/A',
                'is_tagged' => true,
                'tagger_name' => $this->tagger_name,
            ]);

            // Check for Live-in Partner
            if ($this->civil_status_id == '2') {
                Log::info('Creating live-in partner record');
                LiveInPartner::create([
                    'tagged_and_validated_applicant_id' => $taggedApplicant->id,
                    'partner_first_name' => $this->partner_first_name,
                    'partner_middle_name' => $this->partner_middle_name,
                    'partner_last_name' => $this->partner_last_name,
                    'partner_occupation' => $this->partner_occupation,
                    'partner_monthly_income' => $this->partner_monthly_income,
                ]);
                Log::info('Live-in partner record created successfully');
            }

            // Check for Spouse
            if ($this->civil_status_id == '3') {
                Log::info('Creating spouse record');
                Spouse::create([
                    'tagged_and_validated_applicant_id' => $taggedApplicant->id,
                    'spouse_first_name' => $this->spouse_first_name,
                    'spouse_middle_name' => $this->spouse_middle_name,
                    'spouse_last_name' => $this->spouse_last_name,
                    'spouse_occupation' => $this->spouse_occupation,
                    'spouse_monthly_income' => $this->spouse_monthly_income,
                ]);
                Log::info('Spouse record created successfully');
            }

            // Create dependent records
            if (!empty($this->dependents)) {
                Log::info('Creating dependent records', ['dependent_count' => count($this->dependents)]);
                $dependentData = [];
                foreach ($this->dependents as $dependent) {
                    $dependentData[] = [
                        'tagged_and_validated_applicant_id' => $taggedApplicant->id,
                        'dependent_first_name' => $dependent['dependent_first_name'] ?: null,
                        'dependent_middle_name' => $dependent['dependent_middle_name'] ?: null,
                        'dependent_last_name' => $dependent['dependent_last_name'] ?: null,
                        'dependent_sex' => $dependent['dependent_sex'] ?: null,
                        'dependent_civil_status_id' => $dependent['dependent_civil_status_id'] ?: null,
                        'dependent_date_of_birth' => $dependent['dependent_date_of_birth'] ?: null,
                        'dependent_occupation' => $dependent['dependent_occupation'] ?: null,
                        'dependent_monthly_income' => $dependent['dependent_monthly_income'] ?? null,
                        'dependent_relationship_id' => $dependent['dependent_relationship_id'] ?: null,
                    ];
                }
                Dependent::insert($dependentData);
                Log::info('Dependent records created successfully');
            }

            // Handle file uploads
            if (!empty($this->houseStructureImages)) {
                Log::info('Processing house structure images', ['image_count' => count($this->houseStructureImages)]);
                foreach ($this->houseStructureImages as $image) {
                    try {
                        $this->storeAttachment($image, $taggedApplicant->id);
                        Log::info('Image stored successfully', [
                            'original_name' => $image->getClientOriginalName(),
                            'size' => $image->getSize()
                        ]);
                    } catch (\Exception $e) {
                        Log::error('Failed to store image', [
                            'error' => $e->getMessage(),
                            'file' => $image->getClientOriginalName() ?? 'unknown'
                        ]);
                        throw $e;
                    }
                }
            }

            // Handle transfer specific logic
            if ($this->isTransfer && $this->previousAwardeeData) {
                // Find the existing awardee record
                $existingAwardee = Awardee::findOrFail($this->previousAwardeeData['previous_awardee_id']);

                Log::info('Transfer process - Found existing awardee', [
                    'existing_awardee_id' => $existingAwardee->id,
                    'old_tagged_validated_id' => $existingAwardee->tagged_and_validated_applicant_id,
                    'new_tagged_validated_id' => $taggedApplicant->id
                ]);

                // Store the old tagged and validated applicant ID
                $previousAwardeeName = $existingAwardee->taggedAndValidatedApplicant->applicant->person->full_name;

                // Create transfer history
                AwardeeTransferHistory::create([
                    'previous_awardee_id' => $existingAwardee->id,
                    'transfer_date' => now(),
                    'transfer_reason' => $this->reason_for_transfer,
                    'relationship' => $this->relationship,
                    'processed_by' => auth()->id(),
                    'remarks' => "Transfer from {$previousAwardeeName} to {$person->full_name}"
                ]);

                // Update the existing awardee record with new occupant's information
                $existingAwardee->update([
                    'tagged_and_validated_applicant_id' => $taggedApplicant->id,
                    'previous_awardee_name' => $previousAwardeeName,
                    'transfer_date' => now(),
                    'transfer_reason' => $this->reason_for_transfer,
                    'transferred_by' => auth()->id(),
                    'is_blacklisted' => false
                ]);

                // Create blacklist entry
                Blacklist::create([
                    'awardee_id' => $existingAwardee->id,
                    'user_id' => auth()->id(),
                    'date_blacklisted' => now(),
                    'blacklist_reason_description' => 'Transfer of Rights - Property transferred to new occupant',
                    'updated_by' => auth()->user()->full_name
                ]);
            }

            DB::commit();
            Log::info('Transaction committed');

            // Success message and redirect
            $this->dispatch('alert', [
                'title' => $this->isTransfer ? 'Transfer successful!' : 'New occupant added!',
                'message' => $this->isTransfer ?
                    'Transfer has been successfully processed.' :
                    'New occupant has been successfully added.',
                'type' => 'success'
            ]);

            return redirect()->route($this->isTransfer ? 'awardee-list' : 'transaction-request');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in store method', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->handleError($e);
        }
    }

    private function handleError(\Exception $e): void
    {
        Log::error('Error in store process', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        $this->dispatch('alert', [
            'title' => 'Error',
            'message' => 'An error occurred while processing your request. Please try again.',
            'type' => 'error'
        ]);
    }

    protected function handleDatabaseError(QueryException $e): void
    {
        if ($e->getCode() === '22003') {
            $this->dispatch('alert', [
                'title' => 'Invalid Amount',
                'message' => 'The amount entered is too large. Please enter a smaller value.',
                'type' => 'warning'
            ]);
        } else {
            $this->dispatch('alert', [
                'title' => 'Database Error',
                'message' => 'Unable to save the information. Please try again or contact support.',
                'type' => 'error'
            ]);
        }
    }

    /**
     * Store individual attachment
     */
    private function storeAttachment($image, $taggedApplicantId): void
    {
        if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $fileName = time() . '_' . $image->getClientOriginalName();
            // Changed from 'public/tagging-house-structure-images' to just 'tagging-house-structure-images'
            $filePath = $image->storeAs('documents', $fileName, 'tagging-house-structure-images');

            TaggedDocumentsSubmission::create([
                'tagged_applicant_id' => $taggedApplicantId,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => $image->getClientOriginalExtension(),
                'file_size' => $image->getSize(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.add-new-occupant', [
        ])->layout('layouts.app');  // Ensure this matches your Blade layout path
    }
}
