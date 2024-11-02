<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Awardee;
use App\Models\Barangay;
use App\Models\CivilStatus;
use App\Models\Purok;
use App\Models\Religion;
use App\Models\Tribe;
use Livewire\Component;

class AwardeeDetails extends Component
{
    public $isEditing = false, $isLoading = false;

    public $awardee, $taggedApplicant, $applicant;
    // Applicant information
    public $first_name, $middle_name, $last_name, $suffix_name, $barangay_id, $purok_id, $full_address, $contact_number;
    public $puroks = [];

    // Tagged applicant details
    public $civil_status_id;
    public function mount($applicantId): void
    {
        $this->awardee = Awardee::with([
            'taggedAndValidatedApplicant.applicant',
            'taggedAndValidatedApplicant.civilStatus',
            'taggedAndValidatedApplicant.tribe',
            'taggedAndValidatedApplicant.religion',
            'taggedAndValidatedApplicant.livingSituation',
            'taggedAndValidatedApplicant.caseSpecification',
            'taggedAndValidatedApplicant.governmentProgram',
            'taggedAndValidatedApplicant.livingStatus',
            'taggedAndValidatedApplicant.roofType',
            'taggedAndValidatedApplicant.wallType',
            'taggedAndValidatedApplicant.spouse',
            'taggedAndValidatedApplicant.dependents',
            'address.purok',
            'address.barangay',
            'lot',
            'lotSizeUnit'
        ])->findOrFail($applicantId);

        $this->taggedApplicant = $this->awardee->taggedAndValidatedApplicant;
        $this->applicant = $this->taggedApplicant->applicant;

        $this->loadFormData();
    }
    public function loadFormData(): void
    {
        // Load Applicant Information
        $this->first_name = $this->applicant->first_name ?? '--';
        $this->middle_name = $this->applicant->middle_name ?? '--';
        $this->last_name = $this->applicant->last_name ?? '--';
        $this->suffix_name = $this->applicant->suffix_name ?? '--';
        $this->contact_number = $this->applicant?->contact_number ?? '--';
        // Load Tagged and Validated Applicant Information
        $this->civil_status_id = $this->taggedApplicant?->civil_status_id ?? '--';
        // Load Address Information - Store IDs instead of names
        $this->barangay_id = $this->awardee->address?->barangay?->id;
        $this->purok_id = $this->awardee->address?->purok?->id;
        $this->full_address = $this->awardee->address?->full_address ?? '--';
        // Load initial puroks if barangay is selected
        if ($this->barangay_id) {
            $this->puroks = Purok::where('barangay_id', $this->barangay_id)->get();
        }
    }
    public function updatedBarangayId($barangayId): void
    {
        $this->isLoading = true;

        try {
            if ($barangayId){
                $this->puroks = Purok::where('barangay_id', $barangayId)->get();
            } else{
                $this->puroks = [];
            }
            $this->purok_id = null; // Reset selected puroks when barangay changes
        } catch (\Exception $e){
            logger()->error('Error fetching puroks', [
                'barangay_id' => $barangayId,
                'error' => $e->getMessage()
            ]);
        }
        $this->isLoading = false;
    }
    public function toggleEdit(): void
    {
        $this->isEditing = !$this->isEditing;
        if (!$this->isEditing) {
            $this->loadFormData(); // Reset form data if canceling edit
        }
    }
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255', 'middle_name' => 'nullable|string|max:255', 'last_name' => 'required|string|max:255', 'suffix_name' => 'nullable|string|max:255',

            'civil_status_id' => 'required|exists:civil_statuses,id',
            'barangay_id' => 'required|exists:barangays,id', 'purok_id' => 'required|exists:puroks,id',
        ];
    }
    public function saveChanges()
    {
        $validatedData = $this->validate();

        // Update Applicant
        $this->applicant->update([
            'first_name' => $validatedData['first_name'],
            'middle_name' => $validatedData['middle_name'],
            'last_name' => $validatedData['last_name'],
            'suffix_name' => $validatedData['suffix_name'],
        ]);

        // Update Tagged Applicant
        $this->taggedApplicant->update([
            'civil_status_id' => $validatedData['civil_status_id'],
        ]);

        $this->awardee->address->update([
            'barangay_id' => $validatedData['barangay_id'],
            'purok_id' => $validatedData['purok_id'],
        ]);

        $this->isEditing = false;
//        session()->flash('message', 'Awardee details updated successfully.');
    }

    public function render()
    {
        return view('livewire.awardee-details',[
            'barangays' => Barangay::all(),
            'civilStatuses' => CivilStatus::all(),
            'tribes' => Tribe::all(),
            'religions' => Religion::all(),
        ])->layout('layouts.app');
    }
}
