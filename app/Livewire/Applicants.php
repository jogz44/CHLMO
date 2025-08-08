<?php

namespace App\Livewire;

use AllowDynamicProperties;
use App\Exports\ApplicantsDataExport;
use App\Models\Address;
use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\People;
use App\Models\Purok;
use App\Models\TaggedAndValidatedApplicant;
use App\Models\TransactionType;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Collection\Collection;
use App\Livewire\Logs\ActivityLogs;

class Applicants extends Component
{
    use WithPagination;
    public $paginationTheme = 'tailwind', $search = '';

    public $isModalOpen = false, $isLoading = false;
    public $date_applied, $transaction_type,
        $person_id, $first_name, $middle_name, $last_name, $suffix_name, $contact_number, $barangay_id, $barangays = [],
        $purok_id, $puroks = [], $interviewer;

    // Filter properties:
    public $applicantId, $startDate, $endDate, $selectedTaggingStatus, $selectedPurok_id, $puroksFilter = [],
        $selectedBarangay_id, $barangaysFilter = [], $taggingStatuses;

    public $selectedApplicantId, $edit_person_id, $edit_first_name, $edit_middle_name, $edit_last_name, $edit_suffix_name, $edit_date_applied,
            $edit_contact_number, $edit_barangay_id, $edit_purok_id;

    // For checking duplicate applicants
    public $showHousingDuplicateWarning = false, $housingDuplicateData = null, $proceedWithDuplicate = false;

    public function updatingSearch(): void
    {
        // This ensures that the search query is updated dynamically as the user types
        $this->resetPage();
    }
    public function clearSearch(): void
    {
        $this->search = ''; // Clear the search input
    }
    public function resetFilters(): void
    {
        $this->startDate = null;
        $this->endDate = null;
        $this->selectedPurok_id = null;
        $this->selectedBarangay_id = null;
        $this->selectedTaggingStatus = null;

        // Reset pagination and any search terms
        $this->resetPage();
        $this->search = '';
    }
    public function mount()
    {
        // Initialize modal states
        $this->isModalOpen = false;
        $this->showHousingDuplicateWarning = false;

        // Set today's date as the default value for date_applied
        $this->date_applied = now()->toDateString(); // YYYY-MM-DD format

//        $this->startDate = now()->toDateString();
//        $this->endDate = now()->toDateString();

        // Initialize dropdowns
        $this->barangays = Barangay::all();
        $this->puroks = Purok::all();

        // Set interviewer
        $this->interviewer = Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name;

        // Initialize filter options
        $this->puroksFilter = Cache::remember('puroks', 60*60, function() {
            return Purok::all();
        });
        $this->barangaysFilter = Cache::remember('barangays', 60*60, function() {
            return Barangay::all();
        });
        $this->taggingStatuses = ['Tagged', 'Not Tagged']; // Add your statuses here
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
    public function updatedSelectedBarangayId($barangayId)
    {
        // Fetch the puroks based on the selected barangay
        $this->puroksFilter = Purok::where('barangay_id', $barangayId)->get();
        $this->selectedPurok_id = null; // Reset selected purok when barangay changes
        $this->isLoading = false; // Reset loading state
        logger()->info('Retrieved Puroks', [
            'selectedBarangay_id' => $barangayId,
            'puroksFilter' => $this->puroksFilter
        ]);
    }
    protected function rules()
    {
        return [
            'date_applied' => 'required|date',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'suffix_name' => 'nullable|string|max:50',
            'contact_number' => [
                'required',
                'regex:/^09\d{9}$/'
            ],
            'barangay_id' => 'required|exists:barangays,id',
            'purok_id' => 'required|exists:puroks,id',
        ];
    }
    // Add this method to check for duplicates when name fields change
    public function updated($propertyName)
    {
        if (!$this->showHousingDuplicateWarning &&
            in_array($propertyName, ['first_name', 'last_name', 'middle_name']) &&
            $this->first_name && $this->last_name) {

            $people = new People();
            $result = $people->checkExistingApplications(
                $this->first_name,
                $this->last_name,
                $this->middle_name,
                'Housing Applicant'
            );

            if ($result['exists']) {
                $this->housingDuplicateData = $result;
                $this->showHousingDuplicateWarning = true;
            }
        }
    }
    public function closeDuplicateWarning(): void
    {
        $this->showHousingDuplicateWarning = false;
        $this->housingDuplicateData = null;
    }
    public function proceedWithApplication(): void
    {
        // Only mark as safe to proceed, don't store yet
        $this->proceedWithDuplicate = true;
        $this->showHousingDuplicateWarning = false;
        // Remove this line as we don't want to store immediately
        // $this->storeApplicant();
    }

    public function store()
    {
        // Validate the input data
        $this->validate();

        if (!$this->proceedWithDuplicate) {
            $people = new People();
            $result = $people->checkExistingApplications(
                $this->first_name,
                $this->last_name,
                $this->middle_name,
                'Housing Applicant'
            );

            if ($result['exists']) {
                if ($result['applications']['housing']) {
                    $this->addError('duplicate', 'Cannot proceed - Applicant already has a Housing Application');
                    return;
                }

                $this->housingDuplicateData = $result;
                $this->showHousingDuplicateWarning = true;
                return;
            }
        }

        // Only store when form is submitted via "+ ADD APPLICANT" button
        $this->storeApplicant();
    }
    private function storeApplicant(): void
    {
        try {
            // Log the start of the storage process
            logger()->info('Starting applicant storage process', [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name
            ]);

            $people = People::firstOrCreate([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'suffix_name' => $this->suffix_name,
                'contact_number' => $this->contact_number,
                'application_type' => 'Housing Applicant'
            ]);

            // Create the address entry first
            $address = Address::create([
                'barangay_id' => $this->barangay_id,
                'purok_id' => $this->purok_id,
            ]);

            // Generate the unique applicant ID
            $applicantId = Applicant::generateApplicantId();

            // Create the new applicant record
            $applicant = Applicant::create([
                'applicant_id' => $applicantId,
                'person_id' => $people->id,
                'user_id' => Auth::id(),
                'date_applied' => $this->date_applied,
                'initially_interviewed_by' => $this->interviewer,
                'address_id' => $address->id,
                'transaction_type' => 'Walk-in'  // Explicitly set for new applicants
            ]);

             // Log the activity using ActivityLogs
             $logger = new ActivityLogs();
             $user = Auth::user();
             $logger->logActivity('Create Applicant', $user);

            logger()->info('Applicant stored successfully', [
                'applicant_id' => $applicantId
            ]);

            $this->resetForm();
            $this->isModalOpen = false;
            $this->proceedWithDuplicate = false;

            $this->dispatch('alert', [
                'title' => 'Applicant Added!',
                'message' => 'Applicant successfully added at <br><small>'. now()->calendar() .'</small>',
                'type' => 'success'
            ]);

            $this->redirect('applicants');

        } catch (\Exception $e) {
            logger()->error('Error storing applicant', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->addError('general', 'Failed to save applicant. Please try again.');
        }
    }
    public function resetForm(): void
    {
        $this->reset([
            'date_applied', 'person_id', 'first_name', 'middle_name', 'last_name',
            'suffix_name', 'barangay_id', 'purok_id', 'contact_number',
        ]);
    }
    public function edit($id): void
    {
        $applicant = Applicant::findOrFail($id);

        $this->selectedApplicantId = $applicant->id;
        $this->edit_person_id = $applicant->person_id;
        $this->edit_first_name = $applicant->person->first_name;
        $this->edit_middle_name = $applicant->person->middle_name;
        $this->edit_last_name = $applicant->person->last_name;
        $this->edit_suffix_name = $applicant->person->suffix_name;
        $this->edit_contact_number = $applicant->person->contact_number;
        $this->edit_barangay_id = $applicant->address->barangay_id ?? null;
        $this->edit_purok_id = $applicant->address->purok_id ?? null;
        $this->edit_date_applied = $applicant->date_applied->format('Y-m-d');
    }
    public function update(): void
    {
        $this->validate([
            'edit_first_name' => 'required|string|max:255',
            'edit_middle_name' => 'nullable|string|max:255',
            'edit_last_name' => 'required|string|max:255',
            'edit_suffix_name' => 'nullable|string|max:255',
            'edit_contact_number' => 'nullable|string|max:15',
            'edit_barangay_id' => 'required|integer',
            'edit_purok_id' => 'required|integer',
            'edit_date_applied' => 'required|date',
        ]);

        $applicant = Applicant::findOrFail($this->selectedApplicantId);
        $person = $applicant->person;
        $address = $applicant->address;

        $person->first_name = $this->edit_first_name;
        $person->middle_name = $this->edit_middle_name;
        $person->last_name = $this->edit_last_name;
        $person->suffix_name = $this->edit_suffix_name;
        $person->contact_number = $this->edit_contact_number;
        $person->save();

        $applicant->date_applied = $this->edit_date_applied;
        $applicant->save();

        // Update address
        $address = $applicant->address;
        if ($address) {
            $address->barangay_id = $this->edit_barangay_id;
            $address->purok_id = $this->edit_purok_id;
            $address->save(); // Don't forget to save the address
        }
         // Log the activity using ActivityLogs
         $logger = new ActivityLogs();
         $user = Auth::user();
         $logger->logActivity('Edit Applicant Info', $user);

        $this->dispatch('alert', [
            'title' => 'Details Updated!',
            'message' => 'Applicant successfully updated at <br><small>'. now()->calendar() .'</small>',
            'type' => 'success'
        ]);

        $this->redirect('applicants');
    }
    public function tagApplicant($applicantId): void
    {
        // Logic to tag the applicant
        $applicant = Applicant::find($applicantId);
        $applicant->is_tagged = true;
        $applicant->save();
    }
    // Add this export method
    public function export()
    {
        try {
            $filters =  array_filter([
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'barangay_id' => $this->selectedBarangay_id,
                'purok_id' => $this->selectedPurok_id,
                'tagging_status' => $this->selectedTaggingStatus
            ]);

            return Excel::download(
                new ApplicantsDataExport($filters),
                'applicants-' . now()->format('Y-m-d') . '.xlsx'
            );
        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());
            $this->dispatch('alert', [
                'title' => 'Export failed: ',
                'message' => $e->getMessage() . '<br><small>'. now()->calendar() .'</small>',
                'type' => 'danger'
            ]);
            return null;
        }
    }

    public function exportPDF(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        ini_set('default_charset', 'UTF-8');

        // Create filters array matching your Excel export
        $filters = array_filter([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'barangay_id' => $this->selectedBarangay_id,      // Changed from barangay_id
            'purok_id' => $this->selectedPurok_id,            // Changed from purok_id
            'tagging_status' => $this->selectedTaggingStatus  // Added to match Excel export
        ]);

        // Fetch Applicants based on filters
        $query = Applicant::with([
            'person',
            'address.barangay',
            'address.purok',
        ])->where('transaction_type', 'Walk-in');

        // Apply filters
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date_applied', [
                $this->startDate,
                $this->endDate
            ]);
        }

        if ($this->selectedBarangay_id) {    // Changed from barangay_id
            $query->whereHas('address', function($q) {
                $q->where('barangay_id', $this->selectedBarangay_id);
            });
        }

        if ($this->selectedPurok_id) {       // Changed from purok_id
            $query->whereHas('address', function($q) {
                $q->where('purok_id', $this->selectedPurok_id);
            });
        }

        if ($this->selectedTaggingStatus === 'Tagged') {
            $query->where('is_tagged', true);
        } elseif ($this->selectedTaggingStatus === 'Untagged') {
            $query->where('is_tagged', false);
        }

        $applicants = $query->get();

        // Build Subtitle from Filters
        $subtitle = [];

        if ($this->selectedBarangay_id) {
            $barangay = Barangay::find($this->selectedBarangay_id);
            $subtitle[] = "BARANGAY: {$barangay->name}";
        }

        if ($this->selectedPurok_id) {
            $purok = Purok::find($this->selectedPurok_id);
            $subtitle[] = "PUROK: {$purok->name}";
        } else if ($this->selectedBarangay_id) {
            $subtitle[] = "PUROK: All Purok";
        }

        if ($this->startDate && $this->endDate) {
            $startDate = Carbon::parse($this->startDate)->format('m/d/Y');
            $endDate = Carbon::parse($this->endDate)->format('m/d/Y');
            $subtitle[] = "Date From: {$startDate} To: {$endDate}";
        }

        if ($this->selectedTaggingStatus) {
            $subtitle[] = "Status: {$this->selectedTaggingStatus}";
        }

        $subtitleText = implode(' | ', $subtitle);

        $title = 'WALK-IN APPLICANTS';

        $html = view('pdfs.applicants', [
            'applicants' => $applicants,
            'subtitle' => $subtitleText,
            'title' => $title,
        ])->render();

        // Load the PDF with the generated HTML
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('legal', 'portrait');

        // Stream the PDF for download
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'applicants.pdf');
    }

    public function render()
    {
        $query = Applicant::with(['address.purok', 'address.barangay', 'taggedAndValidated', 'person'])
            ->where(function($query) {
                // Split search input into words
                $searchWords = explode(' ', strtolower($this->search));

                foreach ($searchWords as $word) {
                    $query->where(function($subQuery) use ($word) {
                        $subQuery->whereHas('person', function($q) use ($word) {
                            $q->whereRaw('LOWER(first_name) LIKE ?', ["%{$word}%"])
                            ->orWhereRaw('LOWER(middle_name) LIKE ?', ["%{$word}%"])
                            ->orWhereRaw('LOWER(last_name) LIKE ?', ["%{$word}%"])
                            ->orWhereRaw('LOWER(suffix_name) LIKE ?', ["%{$word}%"])
                            ->orWhereRaw('LOWER(contact_number) LIKE ?', ["%{$word}%"]);
                        })
                        ->orWhereRaw('LOWER(applicant_id) LIKE ?', ["%{$word}%"])
                        ->orWhereHas('address.purok', function ($q) use ($word) {
                            $q->whereRaw('LOWER(name) LIKE ?', ["%{$word}%"]);
                        })
                        ->orWhereHas('address.barangay', function ($q) use ($word) {
                            $q->whereRaw('LOWER(name) LIKE ?', ["%{$word}%"]);
                        });
                    });
                }
            });

        // Apply filters
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date_applied', [$this->startDate, $this->endDate]);
        }

        if ($this->selectedPurok_id) {
            $query->whereHas('address', function ($q) {
                $q->where('purok_id', $this->selectedPurok_id);
            });
        }

        if ($this->selectedBarangay_id) {
            $query->whereHas('address', function ($q) {
                $q->where('barangay_id', $this->selectedBarangay_id);
            });
        }

        if ($this->selectedTaggingStatus !== null) {
            $query->where('is_tagged', $this->selectedTaggingStatus === 'Tagged');
        }

        $applicants = $query->orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.applicants', [
            'puroks' => $this->puroks,
            'puroksFilter' => $this->puroksFilter,
            'applicants' => $applicants
        ]);
    }

}
