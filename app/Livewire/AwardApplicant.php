<?php
//
//namespace App\Livewire;
//
//use App\Models\Address;
//use App\Models\Applicant;
//use App\Models\Awardee;
//use App\Models\Barangay;
//use App\Models\LotList;
//use App\Models\LotSizeUnit;
//use App\Models\Purok;
//use App\Models\TaggedAndValidatedApplicant;
//use Illuminate\Support\Facades\Auth;
//use Livewire\Component;
//
//class AwardApplicant extends Component
//{
//    public $isLoading = false;
//    // For awarding modal
//    public $grant_date;
//    public $taggedAndValidatedApplicantId; // ID of the applicant being awarded
//    public $purok_id;
//    public $puroks = []; // Initialize as an empty array
//    public $barangay_id;
//    public $barangays = []; // Initialize as an empty array
//    public $lot_id;
//    public $lots = []; // Initialize as an empty array
//    public $lot_size;
//    public $lot_size_unit_id;
//    public $lotSizeUnits = []; // Initialize as an empty array
//
//    public function mount()
//    {
//        // Set today's date as the default value for date_applied
//        $this->grant_date = now()->toDateString(); // YYYY-MM-DD format
//
//        // Initialize dropdowns
//        $this->barangays = Barangay::all();
//        $this->puroks = Purok::all();
//        // Fetch related LotSizeUnits
//        $this->lots = LotList::all(); // Fetch all lot size units
//        $this->lotSizeUnits = LotSizeUnit::all(); // Fetch all lot size units
//    }
//    public function updatingBarangay()
//    {
//        $this->resetPage();
//    }
//    public function updatingPurok()
//    {
//        $this->resetPage();
//    }
//    public function updatedBarangayId($barangayId): void
//    {
//        // Fetch the puroks based on the selected barangay
//        $this->puroks = Purok::where('barangay_id', $barangayId)->get();
//        $this->lots = LotList::where('barangay_id', $barangayId)->get();
//
//        $this->purok_id = null; // Reset selected purok when barangay changes
//        $this->lot_id = null; // Reset selected lot when barangay changes
//
//        $this->isLoading = false; // Reset loading state
//
//        logger()->info('Retrieved Puroks', [
//            'barangay_id' => $barangayId,
//            'puroks' => $this->puroks,
//            'lots' => $this->lots
//        ]);
//    }
//    protected function rules(): array
//    {
//        return [
//            'grant_date' => 'required|date',
//            'barangay_id' => 'required|exists:barangays,id',
//            'purok_id' => 'required|exists:puroks,id',
//            'lot_id' => 'required|exists:lot_lists,id',
//            'lot_size' => 'required|integer',
//            'lot_size_unit_id' => 'required|exists:lot_size_units,lot_size_unit_short_name',
////            'letter_of_intent_photo' => 'nullable|string|max:255',
////            'voters_id_photo' => 'nullable|string|max:255',
////            'valid_id_photo' => 'nullable|string|max:255',
////            'certificate_of_no_land_holding_photo' => 'nullable|string|max:255',
////            'marriage_certificate_photo' => 'nullable|string|max:255',
////            'birth_certificate_photo' => 'nullable|string|max:255',
//        ];
//    }
//    public function awardApplicant(): void
//    {
//        // Validate the input data
//        $this->validate();
//
//        // Create the address entry first
//        $address = Address::create([
//            'barangay_id' => $this->barangay_id,
//            'purok_id' => $this->purok_id,
//        ]);
//
//        // Create the new awardee record and get the ID of the newly created awardee
//        $awardees = Awardee::create([
//            'tagged_and_validated_applicant_id' => $this->taggedAndValidatedApplicantId,
//            'lot_id' => $this->lot_id,
//            'lot_size' => $this->lot_size,
//            'lot_size_unit_id' => $this->lot_size_unit_id,
//            'grant_date' => $this->date_applied,
//        ]);
//
//        $this->reset(['grant_date', 'award_description', 'taggedAndValidatedApplicantId']);
//
//        // Trigger the alert message
//        $this->dispatch('alert', [
//            'title' => 'Awarding Successful!',
//            'message' => 'Applicant awarded successfully! <br><small>'. now()->calendar() .'</small>',
//            'type' => 'success'
//        ]);
//
//        $this->redirect('transaction-request');
//    }
//    public function resetForm(): void
//    {
//        $this->reset([
//            'lot_id', 'lot_size', 'lot_size_unit_id', 'grant_date',
//        ]);
//    }
//    public function render()
//    {
//        return view('livewire.award-applicant');
//    }
//}
