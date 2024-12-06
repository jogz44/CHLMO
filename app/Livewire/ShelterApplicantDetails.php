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
use App\Models\ProfiledApplicantsDocumentsSubmission;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Scheduling\Schedule;
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
    public $full_address, $barangay_name, $purok_name;
    public $government_program_id; // Store selected Government Program ID
    public $governmentPrograms; // For populating the government programs dropdown
    public $shelter_living_situation_id, $case_specification_id, $caseSpecifications, $living_situation_case_specification;
    public $shelterLivingSituations = [];
    public $date_tagged;
    public $remarks;
    public $applicantForSpouse;
    public $spouse_first_name;
    public $spouse_middle_name;
    public $spouse_last_name;
    public $partner_first_name, $partner_middle_name, $partner_last_name;
    public $photos = [], $renamedFileName = [], $structure_status_id, $structureStatuses;

    // For uploading of files
    public $isFilePondUploadComplete = false, $isFilePonduploading = false, $selectedApplicant, $files,
        $applicantToPreview, $isUploading = false, $attachmentLists = [], $awardeeId, $documents = [], $newFileImages = [];
    public $houseStructureImages = [];
    protected $listeners = ['fileUploadFinished' => 'handleFileUploadFinished'];

    public function mount($profileNo)
    {
        $this->civil_statuses = Cache::remember('civil_statuses', 60 * 60, function () {
            return CivilStatus::all();  // Cache for 1 hour
        });


        $this->shelterLivingSituations = Cache::remember('shelterLivingSituations', 60 * 60, function () {
            return LivingSituation::all();  // Cache for 1 hour
        });

        $this->caseSpecifications = Cache::remember('caseSpecifications', 60 * 60, function () {
            return CaseSpecification::all();  // Cache for 1 hour
        });

        $this->governmentPrograms = Cache::remember('governmentPrograms', 60 * 60, function () {
            return GovernmentProgram::all();  // Cache for 1 hour
        });
        $this->structureStatuses = Cache::remember('structureStatuses', 60 * 60, function () {
            return StructureStatusType::all();  // Cache for 1 hour
        });


        // Fetch the applicant
        $this->applicant = ShelterApplicant::find($profileNo);

        if ($this->applicant) {
            $this->first_name = $this->applicant->person->first_name;
            $this->middle_name = $this->applicant->person->middle_name;
            $this->last_name = $this->applicant->person->last_name;
            $this->suffix_name = $this->applicant->suffix_name;

            // Fetch the related origin of request and request date
            $this->origin_name = $this->applicant->originOfRequest->name ?? 'N/A';
            $this->barangay_name = $this->applicant->address->barangay->name ?? 'N/A';
            $this->purok_name = $this->applicant->address->purok->name ?? 'N/A';
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

            $this->houseStructureImages = [];
            $this->isFilePondUploadComplete = false;
            $this->isFilePonduploading = false;

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
            'occupation' => 'required|string|max:255',
            'year_of_residency' => 'required|integer',
            'structure_status_id' => 'required|exists:structure_status_types,id',
            'contact_number' => [
                'required',
                'regex:/^09\d{9}$/'
            ],
            'shelter_living_situation_id' => 'required|exists:shelter_living_situations,id',
            'living_situation_case_specification' => [
                'nullable', // Allow it to be null if not required
                'required_if:shelter_living_situation_id,1,2,3,4,5,6,7,9',
                'string',
                'max:255'
            ],
            'case_specification_id' => [
                'nullable', // Allow it to be null if not required
                'required_if:shelter_living_situation_id,8', // Only required if living_situation_id is 8
                'exists:case_specifications,id'
            ],
            'date_tagged' => 'required|date',
            'government_program_id' => 'required|exists:government_programs,id',
            'remarks' => 'nullable|string|max:255',
            'houseStructureImages.*' => 'required|mimes:jpeg,png,jpg|max:10240', // Validate each image
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
                        }
                    }
                },
            ],

        ];
    }

    public function updatedHouseStructureImages()
    {
        if (!is_array($this->houseStructureImages)) {
            $this->houseStructureImages = [$this->houseStructureImages];
        }

        try {
            Log::info('Files being uploaded:', [
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
            Log::error('Upload validation error:', [
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
            'houseStructureImages.*' => 'required|mimes:jpeg,png,jpg|max:10240', // Validate each image
        ]);
    }

    public function store()
    {
        $this->validate();
        // dd('Validation passed');
        DB::beginTransaction();
        Log::info('Transaction started.');


        try {
            $taggedApplicant = ProfiledTaggedApplicant::create([
                'profile_no' => $this->profileNo,
                'civil_status_id' => $this->civil_status_id,
                'tribe' => $this->tribe,
                'sex' => $this->sex,
                'age' => $this->age,
                'religion' => $this->religion,
                'occupation' => $this->occupation ?: null,
                'year_of_residency' => $this->year_of_residency,
                'contact_number' => $this->contact_number ?: null,
                'full_address' => $this->full_address ?: null,
                'date_tagged' => now(),
                'shelter_living_situation_id' => $this->shelter_living_situation_id,
                'living_situation_case_specification' => $this->shelter_living_situation_id != 8 ? $this->living_situation_case_specification : null, // Store only for 1-7, 9
                'case_specification_id' => $this->shelter_living_situation_id == 8 ? $this->case_specification_id : null, // Only for 8
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

            // // Save each uploaded photo
            // foreach ($this->photos as $photo) {
            //     $path = $photo->store('housing-images', 'public'); // Adjust the storage path as needed

            //     ShelterImagesForHousing::create([
            //         'profiled_tagged_applicant_id' => $taggedApplicant->id, // Assuming this links the image to the applicant
            //         'image_path' => $path,
            //         'display_name' => $photo->getClientOriginalName(),
            //     ]);
            // }

            logger()->info('Starting document submission for applicant', [
                'profiled_tagged_applicant_id' => $taggedApplicant->id,
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
                    if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                        try {
                            $fileName = time() . '_' . $image->getClientOriginalName();

                            // Store file using custom disk
                            $filePath = $image->storeAs(
                                '',
                                $fileName,
                                'tagging-house-structure-images'
                            );

                            Log::info('Stored image:', [
                                'name' => $fileName,
                                'path' => $filePath
                            ]);

                            ProfiledApplicantsDocumentsSubmission::create([
                                'profiled_tagged_applicant_id' => $taggedApplicant->id,
                                'file_path' => $filePath,
                                'file_name' => $fileName,
                                'file_type' => $image->getClientOriginalExtension(),
                                'file_size' => $image->getSize(),
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Failed to store image:', [
                                'error' => $e->getMessage(),
                                'file' => $fileName ?? 'unknown'
                            ]);
                            throw $e;
                        }
                    }
                }
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

    private function storeAttachment($fileInput): void
    {
        $this->isFilePonduploading = false;

        // Validate and store files
        $this->validate([
            'houseStructureImages.*' => 'required|image|max:2048',
        ]);

        // Ensure files are an array and filter out any non-file entries
        $files = array_filter($this->houseStructureImages, function($file) {
            return $file instanceof \Illuminate\Http\UploadedFile;
        });

        // Store each document
        foreach ($files as $file) {
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'tagging-house-structure-images');

            ProfiledApplicantsDocumentsSubmission::create([
                'profiled_tagged_applicant_id' => $this -> profiledTaggedApplicantId,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => $file->extension(),
                'file_size' => $file->getSize(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.shelter-applicant-details')
            ->layout('layouts.adminshelter');
    }
}
