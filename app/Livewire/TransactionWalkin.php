<?php
//
//namespace App\Livewire;
//
//use AllowDynamicProperties;
//use App\Models\Address;
//use App\Models\Applicant;
//use App\Models\Barangay;
//use App\Models\Purok;
//use App\Models\TransactionType;
//use Illuminate\Support\Carbon;
//use Illuminate\Support\Facades\Auth;
//use Livewire\Component;
//use Livewire\WithPagination;
//
//class TransactionWalkin extends Component
//{
//    use WithPagination;
//
//    // Define public properties for the form fields
//    public $isModalOpen = false; // Manage modal visibility
//    public $isLoading = false;
//    public $date_applied;
//    public $transaction_type_id;
//    public $transactionTypes = []; // Initialize as an empty array
//    public $first_name;
//    public $middle_name;
//    public $last_name;
//    public $suffix_name;
//    public $contact_number;
//    public $barangay_id; // Update this property name
//
//    public $purok_id; // Update this property name
//    public $puroks = [];
//    public $interviewer;
//
//    public $barangays = []; // Initialize as an empty array
//
//    // Filter properties
//    public $search = '';
//    public $barangay;
//    public $purok;
//
//    protected $paginationTheme = 'tailwind';
//    public $applicants;
//    public function mount()
//    {
////        dd('Component mounted');
//
//        $this->applicants = collect(); // Initialize as a collection
//
//        // Set today's date as the default value for date_applied
//        $this->date_applied = now()->toDateString(); // YYYY-MM-DD format
//
//        // Initialize dropdowns
//        $this->barangays = Barangay::all();
//        $this->transactionTypes = TransactionType::all();
//
//        // Set default transaction type to 'Walk-in'
//        $walkIn = TransactionType::where('type_name', 'Walk-in')->first();
//        if ($walkIn) {
//            $this->transaction_type_id = $walkIn->id;
//        }
//
//        // Set interviewer
//        $this->interviewer = Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name;
//
//        // Load applicants on mount
//        $this->loadApplicants();
//    }
//
//    public function updatedBarangayId($barangayId)
//    {
//        // Fetch the puroks based on the selected barangay
//        $this->puroks = Purok::where('barangay_id', $barangayId)->get();
//        $this->purok_id = null; // Reset selected purok when barangay changes
//        $this->isLoading = false; // Reset loading state
//        logger()->info('Retrieved Puroks', [
//            'barangay_id' => $barangayId,
//            'puroks' => $this->puroks
//        ]);
//    }
//
////    protected function rules()
////    {
////        return [
////            'date_applied' => 'required|date',
////            'transaction_type_id' => 'required|exists:transaction_types,id',
////            'first_name' => 'required|string|max:50',
////            'middle_name' => 'nullable|string|max:50',
////            'last_name' => 'required|string|max:50',
////            'suffix_name' => 'nullable|string|max:50',
////            'contact_number' => 'nullable|string|max:15',
////            'barangay_id' => 'required|exists:barangays,id',
////            'purok_id' => 'required|exists:puroks,id',
////        ];
////    }
////
////    public function store()
////    {
////        // Validate the input data
////        $this->validate();
////
////        // Create the address entry first
////        $address = Address::create([
////            'barangay_id' => $this->barangay_id,
////            'purok_id' => $this->purok_id,
////        ]);
////
////        // Generate the unique applicant ID
////        $applicantId = Applicant::generateApplicantId();
////
////        // Create the new applicant record and get the ID of the newly created applicant
////        $applicant = Applicant::create([
////            'user_id' => Auth::id(),
////            'date_applied' => $this->date_applied,
////            'transaction_type_id' => $this->transaction_type_id,
////            'first_name' => $this->first_name,
////            'middle_name' => $this->middle_name,
////            'last_name' => $this->last_name,
////            'suffix_name' => $this->suffix_name,
////            'contact_number' => $this->contact_number,
////            'initially_interviewed_by' => $this->interviewer,
////            'address_id' => $address->id,
////            'applicant_id' => $applicantId,
////        ]);
////
////        $this->resetForm();
////        $this->isModalOpen = false; // Close the modal
////
////        // Load applicants directly in the WalkinApplicantsTable component
//////        $this->emitTo('walkin-applicants-table-v2', 'loadApplicants');
////
////        // Flash a success message
////        session()->flash('message', 'Applicant successfully added.');
////        $this->loadApplicants(); // Reload applicants after adding
////    }
////
////    public function resetForm()
////    {
////        $this->reset([
////            'date_applied',
////            'transaction_type_id',
////            'first_name',
////            'middle_name',
////            'last_name',
////            'suffix_name',
////            'barangay_id',
////            'purok_id',
////            'contact_number',
////            'interviewer',
////        ]);
////    }
//
//    public function loadApplicants()
//    {
//        $this->applicants = Applicant::all(); // Fetch all applicants
//    }
//
//    public function updatingSearch($value)
//    {
////        $this->resetPage();
//        logger("Search term updated: " . $value);
//    }
//
//    public function updatingBarangay()
//    {
//        $this->resetPage();
//    }
//
//    public function updatingPurok()
//    {
//        $this->resetPage();
//    }
//
//    public function edit($applicantId)
//    {
//        // Open edit modal, or redirect to an edit page
//        return redirect()->route('applicant.edit', ['id' => $applicantId]);
//    }
//
//    public function tagApplicant($applicantId)
//    {
//        // Logic to tag the applicant
//        $applicant = Applicant::find($applicantId);
//        $applicant->is_tagged = true;
//        $applicant->save();
//
//        // Optionally, show a success message
//        session()->flash('message', 'Applicant tagged successfully.');
//    }
//
//    public function resetFilters()
//    {
//        $this->reset(['search', 'barangay', 'purok']);
//        $this->resetPage();
//    }
//
//    public function render()
//    {
////        dd($this->search);
////        $this->search = 'John';
//
////         Fetch applicants with relationships and filtering
//        $applicants = Applicant::with(['address.barangay', 'address.purok', 'taggedAndValidated'])
//            ->when($this->barangay, function ($query) {
//                $query->whereHas('address', function ($q) {
//                    $q->where('barangay_id', $this->barangay);
//                });
//            })
//            ->when($this->purok, function ($query) {
//                $query->whereHas('address', function ($q) {
//                    $q->where('purok_id', $this->purok);
//                });
//            })
//            ->where(function ($query) {
//                $query->where('first_name', 'like', '%' . $this->search . '%')
//                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
//                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ['%' . $this->search . '%'])
//                    ->orWhere('contact_number', 'like', '%' . $this->search . '%');
//            })->paginate(10);
//
////        // Fetch barangays and puroks
////        $barangays = Barangay::all();
////        $puroks = Purok::all();
//
//        // Assuming transactionTypes are already set in your component
//        $transactionTypes = $this->transactionTypes;
//
//        return view('livewire.transaction-walkin', [
//            'transactionTypes' => $transactionTypes,
//            'barangays' => Barangay::all(),
//            'puroks' => Purok::all(),
//            'applicants' => $applicants,
//        ]);
//    }
//}
