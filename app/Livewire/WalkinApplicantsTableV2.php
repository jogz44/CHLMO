<?php
//
//namespace App\Livewire;
//
//use App\Models\Applicant;
//use App\Models\Barangay;
//use App\Models\Purok;
//use Livewire\Component;
//use Livewire\WithPagination;
//
//class WalkinApplicantsTableV2 extends Component
//{
//    use WithPagination;
//
//    public $applicants;
//
//    protected $listeners = ['applicantAdded' => 'loadApplicants'];
//
//    public $search = '';
//    public $barangay = null;
//    public $purok = null;
//
//    protected $paginationTheme = 'tailwind';
//    public function mount()
//    {
//        $this->loadApplicants();
//    }
//    public function loadApplicants()
//    {
//        $this->applicants = Applicant::all(); // Fetch all applicants
//    }
//
//    public function updatingSearch()
//    {
//        $this->resetPage();
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
//        $applicant->tagged = true;
//        $applicant->save();
//
//        // Optionally, show a success message
//        session()->flash('message', 'Applicant tagged successfully.');
//    }
//
//    public function render()
//    {
//        // Fetch applicants with relationships and filtering
//        $applicants = Applicant::with(['address.barangay', 'address.purok', 'taggedAndValidated'])
//            ->when($this->barangay, function($query) {
//                $query->whereHas('address', function($q) {
//                    $q->where('barangay_id', $this->barangay);
//                });
//            })
//            ->when($this->purok, function($query) {
//                $query->whereHas('address', function($q) {
//                    $q->where('purok_id', $this->purok);
//                });
//            })
//            ->where(function ($query) {
//                $query->where('first_name', 'like', '%' . $this->search . '%')
//                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
//                    ->orWhere('contact_number', 'like', '%' . $this->search . '%');
//            })
//            ->paginate(8);
//
//        $barangays = Barangay::all();
//        $puroks = Purok::all();
//
//        return view('livewire.walkin-applicants-table-v2', compact('applicants', 'barangays', 'puroks'));
//    }
//}
