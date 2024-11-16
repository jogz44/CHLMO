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

class Applicants extends Component
{
    use WithPagination;
    public $paginationTheme = 'tailwind', $search = '';

    public $isModalOpen = false, $isLoading = false;
    public $date_applied, $transaction_type_id;
    public $transactionTypes = [];
    public $person_id, $first_name, $middle_name, $last_name, $suffix_name, $contact_number, $barangay_id, $barangays = [],
        $purok_id, $puroks = [], $interviewer;

    // Filter properties:
    public $applicantId, $startDate, $endDate, $selectedTaggingStatus, $selectedPurok_id, $puroksFilter = [],
        $selectedBarangay_id, $barangaysFilter = [], $selectedTransactionType_id, $transactionTypesFilter = [],
        $taggingStatuses;

    public $selectedApplicantId, $edit_person_id, $edit_first_name, $edit_middle_name, $edit_last_name, $edit_suffix_name, $edit_date_applied,
        $edit_transaction_type_id, $edit_contact_number, $edit_barangay_id, $edit_purok_id;

    // For export
    public Collection $applicantsForExport;
    public Collection $selectedApplicantsForExport;
    public $designTemplate = 'tailwind';

    public function updatingSearch(): void
    {
        // This ensures that the search query is updated dynamically as the user types
        $this->resetPage();
    }
    public function clearSearch()
    {
        $this->search = ''; // Clear the search input
    }

    public function resetFilters(): void
    {
        $this->startDate = null;
        $this->endDate = null;
        $this->selectedPurok_id = null;
        $this->selectedBarangay_id = null;
        $this->selectedTransactionType_id = null;
        $this->selectedTaggingStatus = null;

        // Reset pagination and any search terms
        $this->resetPage();
        $this->search = '';
    }
    public function mount()
    {
//        dd('Component mounted');

        // Set today's date as the default value for date_applied
        $this->date_applied = now()->toDateString(); // YYYY-MM-DD format

        // Initialize dropdowns
        $this->barangays = Barangay::all();
        $this->puroks = Purok::all();
        $this->transactionTypes = TransactionType::all();

        // Set interviewer
        $this->interviewer = Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name;

        // Initialize filter options
        $this->puroksFilter = Cache::remember('puroks', 60*60, function() {
            return Purok::all();
        });
        $this->barangaysFilter = Cache::remember('barangays', 60*60, function() {
            return Barangay::all();
        });
        $this->transactionTypesFilter = Cache::remember('transactionTypes', 60*60, function() {
            return TransactionType::all();
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
            'transaction_type_id' => 'required|exists:transaction_types,id',
        ];
    }
    public function store()
    {
        // Validate the input data
        $this->validate();

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

        // Create the new applicant record and get the ID of the newly created applicant
        $applicant = Applicant::create([
            'applicant_id' => $applicantId,
            'person_id' => $people->id,
            'user_id' => Auth::id(),
            'date_applied' => $this->date_applied,
            'transaction_type_id' => $this->transaction_type_id,
            'initially_interviewed_by' => $this->interviewer,
            'address_id' => $address->id,

        ]);

        $this->resetForm();
        $this->isModalOpen = false; // Close the modal

        // Trigger the alert message
        $this->dispatch('alert', [
            'title' => 'Applicant Added!',
            'message' => 'Applicant successfully added at <br><small>'. now()->calendar() .'</small>',
            'type' => 'success'
        ]);

        $this->redirect('applicants');
    }

    public function resetForm(): void
    {
        $this->reset([
            'date_applied', 'transaction_type_id', 'person_id', 'first_name', 'middle_name', 'last_name',
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
        $this->edit_transaction_type_id = $applicant->transaction_type_id;
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
            'edit_transaction_type_id' => 'required|integer',
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
        $applicant->transaction_type_id = $this->edit_transaction_type_id;
        $applicant->save();

        // Update address
        $address = $applicant->address;
        if ($address) {
            $address->barangay_id = $this->edit_barangay_id;
            $address->purok_id = $this->edit_purok_id;
            $address->save(); // Don't forget to save the address
        }

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
                'transaction_type_id' => $this->selectedTransactionType_id,
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

        // Fetch Applicants based on filters
        $query = Applicant::with([
            'person',
            'address.barangay',
            'address.purok',
            'transactionType'
        ]);

        // Create filters array matching your Excel export
        $filters = array_filter([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'barangay_id' => $this->selectedBarangay_id,      // Changed from barangay_id
            'purok_id' => $this->selectedPurok_id,            // Changed from purok_id
            'transaction_type_id' => $this->selectedTransactionType_id,  // Changed from transaction_type_id
            'tagging_status' => $this->selectedTaggingStatus  // Added to match Excel export
        ]);

        // Fetch Applicants based on filters
        $query = Applicant::with([
            'person',
            'address.barangay',
            'address.purok',
            'transactionType'
        ]);

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

        if ($this->selectedTransactionType_id) {  // Changed from transaction_type_id
            $query->where('transaction_type_id', $this->selectedTransactionType_id);
        }

        if ($this->selectedTaggingStatus) {   // Added to match Excel export
            $query->where('tagging_status', $this->selectedTaggingStatus);
        }

        $applicants = $query->get();

        // Build Subtitle from Filters
        $subtitle = [];

        if ($this->selectedBarangay_id) {     // Changed from barangay_id
            $barangay = Barangay::find($this->selectedBarangay_id);
            $subtitle[] = "BARANGAY: {$barangay->name}";
        }

        if ($this->selectedPurok_id) {        // Changed from purok_id
            $purok = Purok::find($this->selectedPurok_id);
            $subtitle[] = "PUROK: {$purok->name}";
        } else if ($this->selectedBarangay_id) {   // Changed from barangay_id
            $subtitle[] = "PUROK: All Purok";
        }

        if ($this->startDate && $this->endDate) {
            $startDate = Carbon::parse($this->startDate)->format('m/d/Y');
            $endDate = Carbon::parse($this->endDate)->format('m/d/Y');
            $subtitle[] = "Date From: {$startDate} To: {$endDate}";
        }

        $subtitleText = implode(' | ', $subtitle);

        $html = view('pdfs.applicants', [
            'applicants' => $applicants,
            'subtitle' => $subtitleText,
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
        $query = Applicant::with(['address.purok', 'address.barangay', 'taggedAndValidated', 'transactionType', 'person'])
            ->where(function($query) {
                $query->whereHas('person', function($q) {
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                        ->orWhere('middle_name', 'like', '%'.$this->search.'%')
                        ->orWhere('last_name', 'like', '%'.$this->search.'%')
                        ->orWhere('suffix_name', 'like', '%'.$this->search.'%')
                        ->orWhere('contact_number', 'like', '%'.$this->search.'%');
                })
                    ->orWhere('applicant_id', 'like', '%'.$this->search.'%')
                    ->orWhereHas('address.purok', function ($query) {
                        $query->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->orWhereHas('address.barangay', function ($query) {
                        $query->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->orWhereHas('transactionType', function ($query) {
                        $query->where('type_name', 'like', '%' . $this->search . '%');
                    });
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

        if ($this->selectedTransactionType_id) {
            $query->whereHas('transactionType', function ($q) {
                $q->where('transaction_type_id', $this->selectedTransactionType_id);
            });
        }

//        $applicants = $query->paginate(5); // Apply pagination after filtering
        $applicants = $query->orderBy('created_at', 'desc')->paginate(5);

        // Pass data to the view
        return view('livewire.applicants', [
            'puroks' => $this->puroks,
            'puroksFilter' => $this->puroksFilter,
            'applicants' => $applicants
        ]);
    }
}