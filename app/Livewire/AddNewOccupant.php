<?php

namespace App\Livewire;

use App\Models\Barangay;
use App\Models\Purok;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class AddNewOccupant extends Component
{
    // Required fields in adding an occupant
    public
        $isLoading = false, $first_name, $middle_name, $last_name, $suffix_name, $barangay_id, $purok_id, $barangays = [], $puroks = [], $full_address,
        $civil_status_id, $civil_statuses, $contact_number, $tribe_id, $tribes = [], $sex, $date_of_birth, $religion_id, $religions = [],
        $occupation, $monthly_income, $family_income, $transaction_type_id, $transaction_type_name, $interviewer, $taggingStatuses;

    // Spouse's details
    public $spouse_first_name, $spouse_middle_name, $spouse_last_name, $spouse_occupation, $spouse_monthly_income;

    // Dependent's details
    public $dependents = [], $dependent_civil_status_id, $dependent_civil_statuses;

    // Additional fields
    public $tagging_date, $living_situation_id, $livingSituations, $case_specification_id, $caseSpecifications, $living_situation_case_specification,
        $government_program_id, $governmentPrograms, $living_status_id, $livingStatuses, $roof_type_id, $roofTypes, $wall_type_id, $wallTypes,
        $rent_fee, $landlord, $house_owner, $tagger_name, $remarks;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->tagging_date = now()->toDateString(); // YYYY-MM-DD format

        $this->barangays = Barangay::all();
        $this->puroks = Purok::all();

        // Set the default transaction type to 'Request'
        $walkIn = TransactionType::where('type_name', 'Request')->first();
        if ($walkIn) {
            $this->transaction_type_id = $walkIn->id; // This can still be used internally for further logic if needed
            $this->transaction_type_name = $walkIn->type_name; // Set the name to display
        }

        // Set interviewer
        $this->interviewer = Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name;
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
        return [
            'date_applied' => 'required|date',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'suffix_name' => 'nullable|string|max:50',
            'contact_number' => 'nullable|string|max:15',
            'barangay_id' => 'required|exists:barangays,id',
            'purok_id' => 'required|exists:puroks,id',

            'full_address' => 'nullable|string|max:255',
        ];
    }

    public function addOccupant(){

    }

    public function render()
    {
        return view('livewire.add-new-occupant');
    }
}
