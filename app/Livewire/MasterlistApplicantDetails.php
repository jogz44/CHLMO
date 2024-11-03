<?php

namespace App\Livewire;

use App\Models\Applicant;
use Livewire\Component;

class MasterlistApplicantDetails extends Component
{
    public $applicantId;
    public $applicant;

    public $first_name, $middle_name, $last_name, $suffix_name, $barangay, $purok, $contact_number, $date_applied;
    public $full_address, $civil_status, $tribe, $sex, $date_of_birth, $religion, $occupation, $monthly_income, $family_income, $tagging_date, $awarding_date;

    public $spouse_first_name, $spouse_middle_name, $spouse_last_name, $spouse_occupation, $spouse_monthly_income,
        $living_situation, $case_specification, $government_program, $living_status, $rent_fee, $roof_type, $wall_type,
        $remarks;

    public $dependents = [];
    public $images = [], $imagesForAwarding = [];

    public $selectedImage = null; // This is for the tagging image
    public $selectedAttachment = null; // this is for the awarding attachment
    public function mount($applicantId): void
    {
        $this->applicantId = $applicantId;
        $this->applicant = Applicant::with([
            'address.purok',
            'address.barangay',
            'transactionType',
            'taggedAndValidated.livingSituation',
            'taggedAndValidated.caseSpecification',
            'taggedAndValidated.awardees.awardeeDocumentsSubmissions',
            'taggedAndValidated.tribe',
            'taggedAndValidated.religion',
            'taggedAndValidated.spouse',
            'taggedAndValidated.dependents.civilStatus',
            'taggedAndValidated.governmentProgram',
            'taggedAndValidated.livingStatus',
            'taggedAndValidated.roofType',
            'taggedAndValidated.wallType',
            'taggedAndValidated.images',

        ])->findOrFail($this->applicantId);

        // Populate the form fields with applicant data
        $this->first_name = $this->applicant->first_name;
        $this->middle_name = $this->applicant->middle_name;
        $this->last_name = $this->applicant->last_name;
        $this->suffix_name = $this->applicant->suffix_name;
        $this->contact_number = $this->applicant->contact_number;

        // Access the barangay and purok through the address relation
        $this->barangay = $this->applicant->address?->barangay?->name ?? '--';
        $this->purok = $this->applicant->address?->purok?->name ?? '--';
        $this->full_address = $this->applicant->address?->full_address ?? '--';
        $this->date_applied = optional($this->applicant->date_applied)
            ->format('F d, Y') ?? '--';

        // Access all these fields
        $this->civil_status = $this->applicant->taggedAndValidated?->civilStatus?->civil_status ?? '--';
        $this->tribe = $this->applicant->taggedAndValidated?->tribe?->tribe_name ?? '--';
        $this->sex = $this->applicant->taggedAndValidated?->sex ?? '--';
        $this->date_of_birth = optional($this->applicant->taggedAndValidated?->date_of_birth)
            ->format('F d, Y') ?? '--';
        $this->religion = $this->applicant->taggedAndValidated?->religion?->religion_name ?? '--';
        $this->occupation = $this->applicant->taggedAndValidated?->occupation ?? '--';
        $this->monthly_income = $this->applicant->taggedAndValidated?->monthly_income ?? '--';
        $this->family_income = $this->applicant->taggedAndValidated?->family_income ?? '--';
        $this->tagging_date = optional($this->applicant->taggedAndValidated?->tagging_date)
            ->format('F d, Y') ?? '--';

        // Access spouse details
        $this->spouse_first_name = $this->applicant->taggedAndValidated?->spouse?->spouse_first_name ?? '--';
        $this->spouse_middle_name = $this->applicant->taggedAndValidated?->spouse?->spouse_middle_name ?? '--';
        $this->spouse_last_name = $this->applicant->taggedAndValidated?->spouse?->spouse_last_name ?? '--';
        $this->spouse_occupation = $this->applicant->taggedAndValidated?->spouse?->spouse_occupation ?? '--';
        $this->spouse_monthly_income = $this->applicant->taggedAndValidated?->spouse?->spouse_monthly_income ?? '--';

        $this->dependents = $this->applicant->taggedAndValidated?->dependents ?? [];

        $this->awarding_date = $this->applicant->taggedAndValidated?->awardees
            ->first()?->grant_date?->format('F d, Y') ?? '--';

        $this->living_situation = $this->applicant->taggedAndValidated?->livingSituation?->living_situation_description ?? '--';
//        $this->case_specification = $this->applicant->taggedAndValidated?->caseSpecification?->case_specification_name ?? '--';
//        $this->living_situation_case_specification = $this->applicant->taggedAndValidated?->living_situation_case_specification ?? '--';
        $this->case_specification = $this->applicant->taggedAndValidated?->caseSpecification?->case_specification_name
            ?? $this->applicant->taggedAndValidated?->living_situation_case_specification
            ?? '--';

        $this->government_program = $this->applicant->taggedAndValidated?->governmentProgram?->program_name ?? '--';
        $this->living_status = $this->applicant->taggedAndValidated?->livingStatus?->living_status_name ?? '--';
        $this->rent_fee = $this->applicant->taggedAndValidated?->rent_fee ?? '--';

        // House Materials
        $this->roof_type = $this->applicant->taggedAndValidated?->roofType?->roof_type_name ?? '--';
        $this->wall_type = $this->applicant->taggedAndValidated?->wallType?->wall_type_name ?? '--';
        // Remarks
        $this->remarks = $this->applicant->taggedAndValidated?->remarks ?? '--';

        $this->images = $this->applicant->taggedAndValidated?->images ?? [];

        $this->imagesForAwarding = $this->applicant->taggedAndValidated?->awardees?->flatMap(function ($awardee) {
                return $awardee->awardeeDocumentsSubmissions()
                    ->get()
                    ->map(function ($submission) {
                        return $submission->file_name;
                    })->filter();
            }) ?? collect();
    }
    // For tagging pictures
    public function viewImage($imageId): void
    {
        $this->selectedImage = $this->applicant->taggedAndValidated->images->find($imageId);
    }
    public function closeImage(): void
    {
        $this->selectedImage = null;
    }
    // For Awarding pictures
    public function viewAttachment($fileName): void
    {
        $this->selectedAttachment = $fileName;
    }
    public function closeAttachment(): void
    {
        $this->selectedAttachment = null;
    }
    public function render()
    {
        return view('livewire.masterlist-applicant-details', [
            'applicant' => $this->applicant
        ])->layout('layouts.app');
    }
}
