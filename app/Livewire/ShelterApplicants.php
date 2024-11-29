<?php

namespace App\Livewire;

use App\Models\People;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Exports\ShelterApplicantDataExport;
use App\Models\Shelter\ShelterApplicant;
use Livewire\WithPagination;
use App\Models\Shelter\OriginOfRequest;
use App\Models\ProfiledTaggedApplicant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Collection\Collection;
use App\Livewire\Logs\ActivityLogs;

class ShelterApplicants extends Component
{
    use WithPagination;
    public $search = '';

    public $openModal = false;


    public Collection $shelterApplicantsForExport;
    public Collection $selectedApplicantsForExport;
    public $designTemplate = 'tailwind';

    public $isEditModalOpen = false, $isLoading = false, $startDate, $endDate;
    public $selectedOriginOfRequest = null, $profileNo, $date_request, $first_name, $middle_name, $last_name, $person_id,
        $suffix_name, $request_origin_id, $editingProfileNo = null, $origin_name, $selectedTaggingStatus, $taggingStatuses;

    public $barangay_id, $barangays = [], $purok_id, $puroks = [], $selectedPurok_id, $selectedBarangay_id, $puroksFilter = [], $barangaysFilter = [];

    // FOR CHECKING DUPLICATE APPLICANTS
    public $showShelterDuplicateWarning = false, $shelterDuplicateData = null, $proceedWithDuplicate = false;

    public function openModal()
    {
        $this->resetForm();  // Reset form before opening the modal
        $this->openModal = true;
    }

    public function closeModal()
    {
        $this->openModal = false;
    }

    public function resetForm()
    {
        if (!$this->editingProfileNo) {
            $this->profileNo = '';
        }
        $this->date_request = '';
        $this->first_name = '';
        $this->middle_name = '';
        $this->last_name = '';
        $this->suffix_name = '';
        $this->barangay_id = null;
        $this->purok_id = null;
        $this->request_origin_id = null;
        
    }

    public function openModalEdit($profileNo)
    {
        $applicant = ShelterApplicant::with('person', 'address', 'originOfRequest')->findOrFail($profileNo);

        $this->editingProfileNo = $applicant->id;
        $this->date_request = $applicant->date_request;
        $this->first_name = $applicant->person->first_name ?? null;
        $this->middle_name = $applicant->person->middle_name ?? null;
        $this->last_name = $applicant->person->last_name ?? null;
        $this->suffix_name = $applicant->person->suffix_name ?? null;
        $this->request_origin_id = $applicant->request_origin_id;
        $this->barangay_id = $applicant->address->barangay_id ?? null;
        $this->purok_id = $applicant->address->purok_id ?? null;

        $this->isEditModalOpen = true; // Open the modal
    }


    public function closeEditApplicantModal()
    {
        $this->isEditModalOpen = false;
    }
    public function updated($propertyName)
    {
        if (
            !$this->showShelterDuplicateWarning &&
            in_array($propertyName, ['first_name', 'last_name', 'middle_name', 'suffix_name']) &&
            $this->first_name && $this->last_name
        ) {

            $people = new People();
            $result = $people->checkExistingApplications(
                $this->first_name,
                $this->last_name,
                $this->middle_name,
                $this->suffix_name,
                'Shelter Applicant'
            );

            if ($result['exists']) {
                $this->shelterDuplicateData = $result;
                $this->showShelterDuplicateWarning = true;
            }
        }
    }
    public function closeDuplicateWarning(): void
    {
        $this->showShelterDuplicateWarning = false;
        $this->shelterDuplicateData = null;
    }
    public function proceedWithApplication(): void
    {
        $this->proceedWithDuplicate = true;
        $this->showShelterDuplicateWarning = false;
        $this->storeShelterApplicant();
    }
    public function submitForm()
    {
        $this->validate([
            'date_request' => 'required|date',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'barangay_id' => 'required|exists:barangays,id',
            'purok_id' => 'required|exists:puroks,id',
            'request_origin_id' => 'required|exists:origin_of_requests,id',
        ]);
        
        if (!$this->proceedWithDuplicate) {
            $people = new People();
            $result = $people->checkExistingApplications(
                $this->first_name,
                $this->last_name,
                $this->middle_name,
                $this->suffix_name,                         
                'Shelter Applicant'
            );

            if ($result['exists']) {
                if ($result['applications']['shelter']) {
                    $this->addError('duplicate', 'Cannot proceed - Applicant already has a Shelter Application');
                    return;
                }

                $this->shelterDuplicateData = $result;
                $this->showShelterDuplicateWarning = true;
                return;
            }
        }

        $this->storeShelterApplicant();
    }
    private function storeShelterApplicant(): void
    {
        try {   
            logger()->info('Starting shelter applicant storage process', [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name
            ]);

            if ($this->editingProfileNo) {
                $this->updateExistingApplicant();
            } else {
                $this->createNewApplicant();
            }

            $this->resetForm();
            $this->closeModal();
            $this->proceedWithDuplicate = false;

            $this->redirect('shelter-transaction-applicants');
        } catch (\Exception $e) {
            logger()->error('Error storing shelter applicant', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->addError('general', 'Failed to save applicant. Please try again.');
        }
    }
    private function updateExistingApplicant(): void
{
    $applicant = ShelterApplicant::findOrFail($this->editingProfileNo);

    // Update the ShelterApplicant
    $applicant->update([
        'date_request' => $this->date_request,
        'suffix_name' => $this->suffix_name,
        'request_origin_id' => $this->request_origin_id,
    ]);

    // Update the Address
    if ($applicant->address) {
        $applicant->address->update([
            'barangay_id' => $this->barangay_id,
            'purok_id' => $this->purok_id,
        ]);
    }

      // Update related 'person' record
    $applicant->person()->update([
        'first_name' => $this->first_name,
        'middle_name' => $this->middle_name,
        'last_name' => $this->last_name,
        'suffix_name' => $this->suffix_name,
    ]);

    $logger = new ActivityLogs();
    $user = Auth::user();
    $logger->logActivity('Updated a Shelter Applicant', $user);

    $this->dispatch('alert', [
        'title' => 'Applicant Updated!',
        'message' => 'Applicant details updated successfully!',
        'type' => 'success',
    ]);
}



    private function createNewApplicant(): void
    {
        try {
            DB::beginTransaction();

            // Generate profile number first
            $profileNo = ShelterApplicant::generateProfileNo();

            // Create person record
            $people = People::create([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'suffix_name' => $this->suffix_name,
                'application_type' => 'Shelter Applicant',
            ]);

            
            // Create the address entry first
            $address = Address::create([
                'barangay_id' => $this->barangay_id,
                'purok_id' => $this->purok_id,
            ]);

            // Create shelter applicant record
            ShelterApplicant::create([
                'user_id' => Auth::id(),
                'profile_no' => $profileNo,
                'person_id' => $people->id,
                'address_id' => $address->id,
                'date_request' => $this->date_request,
                'suffix_name' => $this->suffix_name,
                'request_origin_id' => $this->request_origin_id,
                'is_tagged' => false,
            ]);

            DB::commit();

            // Log the activity
            $logger = new ActivityLogs();
            $user = Auth::user();
            $logger->logActivity('Created New Shelter Applicant', $user);

            $this->dispatch('alert', [
                'title' => 'Applicant Added!',
                'message' => "Applicant added successfully with Profile No: {$profileNo}! <br><small>" . now()->calendar() . '</small>',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            logger()->error('Error creating shelter applicant', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    public function mount()
    {
        $this->date_request = now()->toDateString();

        $this->startDate = null;
        $this->endDate = null;
        $this->search = ''; // Ensure search is empty initially
        $this->taggingStatuses = ['Tagged', 'Not Tagged'];

        // Initialize dropdowns
        $this->barangays = Barangay::all();
        $this->puroks = Purok::all();
        $this->barangaysFilter = Cache::remember('barangays', 60*60, function() {
            return Barangay::all();
        });
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
    // Reset pagination when search changes
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // Clear search input
    public function clearSearch()
    {
        $this->search = '';
    }

    // Reset filters
    public function resetFilters()
    {
        $this->startDate = null;
        $this->endDate = null;
        $this->search = '';
        $this->selectedOriginOfRequest = null;
        $this->selectedTaggingStatus = null;
        $this->selectedPurok_id = null;
        $this->selectedBarangay_id = null;
        $this->resetPage();
    }

    // Triggered when search or other filters are updated
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function tagApplicant($profileNo)
    {
        // Tag the applicant
        $applicant = ShelterApplicant::find($profileNo);
        $applicant->is_tagged = true;
        $applicant->save();
    }

    //  export method
    public function export()
    {
        try {
            $filters = array_filter([
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'barangay_id' => $this->selectedBarangay_id,
                'purok_id' => $this->selectedPurok_id,
                'request_origin_id' => $this->selectedOriginOfRequest,
                'is_tagged' => $this->selectedTaggingStatus,
            ]);

            return Excel::download(
                new ShelterApplicantDataExport($filters),
                'shelter-applicants-' . now()->format('Y-m-d') . '.xlsx'
            );
        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage());
            $this->dispatch('alert', [
                'title' => 'Export failed: ',
                'message' => $e->getMessage(),
                'type' => 'danger',
            ]);
        }
    }

    public function exportPDF(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        ini_set('default_charset', 'UTF-8');

        // Fetch Applicants based on filters
        $query = ShelterApplicant::with([
            'person',
            'address.barangay',
            'address.purok',
            'originOfRequest',
        ]);

        // Create filters array matching your Excel export
        $filters = array_filter([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'barangay_id' => $this->selectedBarangay_id,      // Changed from barangay_id
            'purok_id' => $this->selectedPurok_id,            // Changed from purok_id
            'request_origin_id' => $this->selectedOriginOfRequest,
            'is_tagged' => $this->selectedTaggingStatus
        ]);

        // Fetch Applicants based on filters
        $query = ShelterApplicant::with([
            'person',
            'originOfRequest',
            'address.barangay',
            'address.purok',
        ]);

        
        // Apply filters
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date_request', [
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

        if ($this->selectedOriginOfRequest) {  // Changed from request_origin_id
            $query->where('request_origin_id', $this->selectedOriginOfRequest);
        }

        
        if ($this->selectedTaggingStatus) {   // Added to match Excel export
            $query->where('is_tagged', $this->selectedTaggingStatus);
        }
        

        $shelterApplicants = $query->get();

        // Build Subtitle from Filters
        $subtitle = [];

        if ($this->selectedOriginOfRequest) {
            $originOfRequest = OriginOfRequest::find($this->selectedOriginOfRequest);
            $subtitle[] = "ORIGIN OF REQUEST: {$originOfRequest->name}";
        }

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
            $subtitle[] = "Date Request From: {$startDate} To: {$endDate}";
        }

        $subtitleText = implode(' | ', $subtitle);

        $html = view('pdfs.shelter-applicants', [
            'shelterApplicants' => $shelterApplicants,
            'subtitle' => $subtitleText,
        ])->render();

        // Load the PDF with the generated HTML
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('legal', 'portrait');

        // Stream the PDF for download
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'shelter-applicants.pdf');
    }

    public function render()
    {
        // Fetch applicants with their related data
        $query = ShelterApplicant::with(['originOfRequest', 'profiledTagged', 'person',  'address.barangay', 'address.purok',])
            ->where(function ($query) {
                $query->whereHas('person', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('suffix_name', 'like', '%' . $this->search . '%');
                })
                    ->orWhere('request_origin_id', 'like', '%' . $this->search . '%')
                    ->orWhere('profile_no', 'like', '%' . $this->search . '%')
                    ->orWhereHas('address.purok', function ($query) {
                        $query->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->orWhereHas('address.barangay', function ($query) {
                        $query->where('name', 'like', '%'.$this->search.'%');
                    });
            });

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date_request', [$this->startDate, $this->endDate]);
        }
        if ($this->selectedOriginOfRequest) {
            $query->where('request_origin_id', $this->selectedOriginOfRequest);
        }
        if ($this->selectedTaggingStatus !== null) {
            $query->where('is_tagged', $this->selectedTaggingStatus === 'Tagged');
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

        $applicants = $query->orderBy('date_request', 'desc')->paginate(5);
        $OriginOfRequests = OriginOfRequest::all();

        // // Return the view with the filtered applicants
        return view('livewire.shelter-applicants', [
            'applicants' => $applicants,
            'puroks' => $this->puroks,
            'puroksFilter' => $this->puroksFilter,
            'OriginOfRequests' => $OriginOfRequests,
        ]);
    }
}
