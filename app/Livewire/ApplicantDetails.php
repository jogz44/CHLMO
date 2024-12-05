<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\AwardeeDocumentsSubmission;
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
use App\Models\TaggedDocumentsSubmission;
use App\Models\TransactionType;
use App\Models\Tribe;
use App\Models\WallType;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Livewire\Logs\ActivityLogs;

class ApplicantDetails extends Component
{
    use WithFileUploads;
    public $applicantId, $applicant, $taggedApplicant;
    public $applicantForSpouse;
    public $transaction_type;
    public $first_name, $middle_name, $last_name, $suffix_name, $contact_number, $barangay, $purok;

    // New fields
    public $full_address, $civil_status_id, $civil_statuses, $religion, $tribe;
    public $living_situation_id, $livingSituations, $case_specification_id, $caseSpecifications,
        $living_situation_case_specification, $non_informal_settler_case_specification, $government_program_id, $governmentPrograms, $living_status_id,
        $livingStatuses, $roof_type_id, $roofTypes, $wall_type_id, $wallTypes, $structure_status_id, $structureStatuses,
        $sex, $date_of_birth, $occupation, $monthly_income, $tagging_date, $room_rent_fee, $room_landlord,
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

    public function handleFileUploadFinished(): void
    {
        $this->isFilePondUploadComplete = true;
    }

    public function mount($applicantId): void
    {
        $this->applicantId = $applicantId;
        $this->applicant = Applicant::with(['person'])->findOrFail($applicantId);
        $person = $this->applicant->person;

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

        $this->transaction_type = $this->applicant->transaction_type ?? '';

        // Set today's date as the default value for tagged_date
        $this->tagging_date = now()->toDateString(); // YYYY-MM-DD format

        // Set interviewer
        $this->tagger_name = Auth::user()->full_name;

        $this->houseStructureImages = [];
        $this->isFilePondUploadComplete = false;
        $this->isFilePonduploading = false;
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
        // Validate the input data
        $this->validate();

        Log::info('Creating tagged applicant', ['is_tagged' => true]);

        \Log::info('Store method called', [
            'applicantId' => $this->applicantId,
            'houseStructureImages' => count($this->houseStructureImages),
            'all_input' => $this->all(),
            'validation_data' => $this->getValidationData()
        ]);

        DB::beginTransaction();

        // Attempt to create the new tagged and validated applicant record
        try {
            $taggedApplicant = TaggedAndValidatedApplicant::create([
                'applicant_id' => $this->applicantId,
                'transaction_type' => $this->applicant->transaction_type,
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
                'living_situation_case_specification' => $this->living_situation_id != 8 && $this->living_situation_id != 9 ? $this->living_situation_case_specification : null, // Store only for 1-7
                'case_specification_id' => $this->living_situation_id == 8 ? $this->case_specification_id : null, // Only for 8
                'non_informal_settler_case_specification' => $this->living_situation_id == 9 ? $this->non_informal_settler_case_specification : null, // Only for 9
                'government_program_id' => $this->government_program_id,
                'living_status_id' => $this->living_status_id,
                'room_rent_fee' => $this->living_status_id == 1 ? $this->room_rent_fee : null, // Store rent fee only if living_status_id is 1,
                'room_landlord' => $this->living_status_id == 1 ? $this->room_landlord : null, // Store landlord only if living_status_id is 1,
                'house_rent_fee' => $this->living_status_id == 2 ? $this->house_rent_fee : null, // Store rent fee only if living_status_id is 2,
                'house_landlord' => $this->living_status_id == 2 ? $this->house_landlord : null, // Store landlord only if living_status_id is 2,
                'lot_rent_fee' => $this->living_status_id == 3 ? $this->lot_rent_fee : null, // Store rent fee only if living_status_id is 3,
                'lot_landlord' => $this->living_status_id == 3 ? $this->lot_landlord : null, // Store landlord only if living_status_id is 3,
                'house_owner' => $this->living_status_id == 5 ? $this->house_owner : null, // Store house owner only if living_status_id is 5,
                'relationship_to_house_owner' => $this->living_status_id == 5 ? $this->relationship_to_house_owner : null,
                'roof_type_id' => $this->roof_type_id,
                'wall_type_id' => $this->wall_type_id,
                'structure_status_id' => $this->structure_status_id,
                'years_of_residency' => $this->years_of_residency ?: 'N/A',
                'voters_id_number' => $this->voters_id_number ?: 'N/A',
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
                    'dependent_monthly_income' => $dependent['dependent_monthly_income'] ?? null,
                    'dependent_relationship_id' => $dependent['dependent_relationship_id'] ?: null,
                ]);
            }

            Dependent::insert($dependentData);

            logger()->info('Starting document submission for applicant', [
                'tagged_applicant_id' => $taggedApplicant->id,
            ]);

            $this->isFilePonduploading = false;

            // Validate and store files
            $this->validate([
                'houseStructureImages.*' => 'required|image|max:2048',
            ]);

            // Ensure files are an array and filter out any non-file entries
            $files = array_filter($this->houseStructureImages, function($file) {
                return $file instanceof \Illuminate\Http\UploadedFile;
            });

            if (!empty($this->houseStructureImages)) {
                foreach ($this->houseStructureImages as $image) {
                    try {
                        $this->storeAttachment($image, $taggedApplicant->id);
                    } catch (\Exception $e) {
                        \Log::error('Failed to store image:', [
                            'error' => $e->getMessage(),
                            'file' => $image->getClientOriginalName() ?? 'unknown'
                        ]);
                        throw $e;
                    }
                }
            }

            // Find the applicant by ID and update the 'tagged' field
            $applicant = Applicant::findOrFail($this->applicantId);
            $applicant->update(['is_tagged' => true]);

            DB::commit();

            // Log the activity
            $logger = new ActivityLogs();
            $user = Auth::user();
            $logger->logActivity('Uploaded house structure images during tagging', $user);

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
            // Check for numeric range error (SQL state 22003)
            if ($e->getCode() === '22003') {
                $this->dispatch('alert', [
                    'title' => 'Invalid Amount',
                    'message' => 'The rent fee amount is too large. Please enter a smaller amount (maximum allowed is ₱999,999.99).',
                    'type' => 'warning'
                ]);
            } else {
                // For other database errors
                $this->dispatch('alert', [
                    'title' => 'Something went wrong!',
                    'message' => 'Unable to save the information. Please try again or contact support if the problem persists.',
                    'type' => 'danger'
                ]);
            }
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
        return view('livewire.applicant-details', [
        ])->layout('layouts.app');  // Ensure this matches your Blade layout path
    }
}
