<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\ProfiledTaggedApplicant;
use App\Models\Shelter\Grantee;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\Barangay;
use App\Models\LivingSituation;
use App\Models\GovernmentProgram;
use App\Models\Shelter\OriginOfRequest;
use App\Models\Shelter\ShelterLiveInPartner;
use App\Models\Shelter\ShelterSpouse;
use App\Models\Shelter\Material;
use App\Models\Purok;
use App\Models\Religion;
use App\Models\Tribe;
use App\Models\Shelter\DeliveredMaterial;
use App\Models\Shelter\PurchaseOrder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RisDataExport;

class GranteeDetails extends Component
{
    public $isEditing = false, $isLoading = false;
    public $grantee;
    public $shelterApplicant;
    public $profiledTagged;
    public $selectedPO;
    public $poNumbers = [];

    public $first_name;
    public $middle_name;
    public $last_name;
    public $originOfRequest, $request_origin_id, $origin_name;
    public $age, $sex, $occupation, $contact_number, $barangay_id, $purok_id, $full_address, $year_of_residency;
    public $puroks = [], $tribe, $religion,
        $spouse_first_name, $spouse_middle_name, $spouse_last_name,
        $partner_first_name, $partner_middle_name, $partner_last_name;
    public $marriedStatusId = 3; // ID for married status
    public $liveInPartnerStatusId = 2; // ID for live-in partner status


    public $date_request;
    public $civil_status_id, $civilStatuses, $date_tagged,
        $living_situation_id, $livingSituations, $case_specification_id, $caseSpecifications, $living_situation_case_specification,
        $government_program_id, $governmentPrograms, $remarks;

    public $materialUnitId, $material_id, $purchaseOrderId, $materialUnits = [], $purchaseOrders = [];
    public $quantity, $date_of_delivery, $date_of_ris;
    public $photo = [], $photoForGranting = [];
    public $selectedImage = null; // This is for the tagging image
    public $selectedAttachment = null; // this is for the awarding attachment
    public $materials = [
        ['material_id' => '', 'quantity' => '', 'purchase_order_id' => '']
    ];

    public function mount($profileNo): void
    {
        $this->grantee = Grantee::with([
            'profiledTaggedApplicant.civilStatus',
            'profiledTaggedApplicant.originOfRequest',
            'profiledTaggedApplicant.livingSituation',
            'profiledTaggedApplicant.caseSpecification',
            'profiledTaggedApplicant.governmentProgram',
            'profiledTaggedApplicant.shelterSpouse',
            'profiledTaggedApplicant.shelterLiveInPartner',
            'profiledTaggedApplicant.address.purok',
            'profiledTaggedApplicant.address.barangay',
        ])->findOrFail($profileNo);
        $this->grantee = Grantee::with(['deliveredMaterials.material'])->findOrFail($profileNo);
        $this->profiledTagged = $this->grantee->profiledTaggedApplicant;
        $this->shelterApplicant = $this->profiledTagged->shelterApplicant;
        $this->loadFormData();
    }
    public function loadFormData(): void
    {
        // Load Applicant Information
        $this->first_name = $this->shelterApplicant->person->first_name ?? '--';
        $this->middle_name = $this->shelterApplicant->person->middle_name ?? '--';
        $this->last_name = $this->shelterApplicant->person->last_name ?? '--';
        $this->request_origin_id = $this->shelterApplicant->originOfRequest->name ?? '--';
        $this->date_request = $this->shelterApplicant?->date_request
            ? $this->shelterApplicant->date_request->format('Y-m-d')
            : '--';

        // Load Tagged and Validated Applicant Information
        $this->civil_status_id = $this->profiledTagged?->civil_status_id ?? '--';
        $this->tribe = $this->profiledTagged?->tribe ?? '--';
        $this->age = $this->profiledTagged?->age ?? '--';
        $this->sex = $this->profiledTagged?->sex ?? '--';
        $this->year_of_residency = $this->profiledTagged?->year_of_residency ?? '--';
        $this->contact_number = $this->profiledTagged?->contact_number ?? '--';
        $this->religion = $this->profiledTagged?->religion ?? '--';
        $this->occupation = $this->profiledTagged?->occupation ?? '--';
        $this->date_tagged = optional($this->profiledTagged?->date_tagged)
            ->format('Y-m-d') ?? '--';

        // Load live-in partner information
        $this->partner_first_name = $this->profiledTagged?->shelterLiveInPartner?->partner_first_name ?? '--';
        $this->partner_middle_name = $this->profiledTagged?->shelterLiveInPartner?->partner_middle_name ?? '--';
        $this->partner_last_name = $this->profiledTagged?->shelterLiveInPartner?->partner_last_name ?? '--';

        // Load spouse information
        $this->spouse_first_name = $this->profiledTagged?->shelterSpouse?->spouse_first_name ?? '--';
        $this->spouse_middle_name = $this->profiledTagged?->shelterSpouse?->spouse_middle_name ?? '--';
        $this->spouse_last_name = $this->profiledTagged?->shelterSpouse?->spouse_last_name ?? '--';

        $this->date_of_delivery = optional($this->grantee->date_of_delivery)->format('F d, Y') ?? '--';
        $this->date_of_ris = optional($this->grantee->date_of_ris)->format('F d, Y') ?? '--';

        // Load delivered materials and map over them
        $this->materials = $this->grantee->deliveredMaterials->map(function ($deliveredMaterial) {
            return [
                'material_id' => $deliveredMaterial->material_id,  // material ID from deliveredMaterial
                'grantee_quantity' => $deliveredMaterial->grantee_quantity,  // Quantity given to the grantee
                'purchase_order_id' => $deliveredMaterial->material->purchaseOrder->po_number,  // Purchase order ID from deliveredMaterial
                'material_unit_id' => $deliveredMaterial->material->material_unit_id,  // material_unit_id from Material model
            ];
        })->toArray();


        // Load civil statuses here
        $this->civilStatuses = CivilStatus::all();
        // Load living situation
        $this->living_situation_id = $this->profiledTagged?->living_situation_id ?? null;
        $this->livingSituations = LivingSituation::all();

        // Load case specification data
        if ($this->profiledTagged?->living_situation_id == 8) {
            $this->case_specification_id = $this->profiledTagged?->case_specification_id ?? null;
        } else {
            $this->living_situation_case_specification = $this->profiledTagged?->living_situation_case_specification ?? '';
        }
        $this->caseSpecifications = CaseSpecification::all();

        // government programs
        $this->government_program_id = $this->profiledTagged?->government_program_id ?? '--';
        $this->governmentPrograms = GovernmentProgram::all();

        $this->remarks = $this->profiledTagged?->remarks ?? '--';

        // Load Address Information - Store IDs instead of names
        $this->barangay_id = $this->profiledTagged?->shelterApplicant->address?->barangay?->id;
        $this->purok_id = $this->profiledTagged?->shelterApplicant->address?->purok?->id;
        $this->full_address = $this->profiledTagged?->full_address ?? '--';
        // Load initial puroks if barangay is selected
        if ($this->barangay_id) {
            $this->puroks = Purok::where('barangay_id', $this->barangay_id)->get();
        }

        $this->photo = $this->shelterApplicant->profiledTagged?->photo ?? [];

        $this->photoForGranting = $this->shelterApplicant->profiledTagged
            ? collect([$this->shelterApplicant->profiledTagged])->flatMap(function ($profiledTagged) {
                return $profiledTagged->granteeDocumentsSubmission()
                    ->get()
                    ->map(function ($submission) {
                        return $submission->file_name;
                    })->filter();
            })
            : collect();

        $this->poNumbers = $this->grantee->deliveredMaterials
            ->pluck('material.purchaseOrder.po_number')
            ->unique()
            ->toArray();
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
    public function getPoNumber($purchaseOrderId)
    {
        $purchaseOrder = PurchaseOrder::find($purchaseOrderId);
        return $purchaseOrder ? $purchaseOrder->po_number : null;
    }

    public function updatedBarangayId($barangayId): void
    {
        $this->isLoading = true;

        try {
            if ($barangayId) {
                $this->puroks = Purok::where('barangay_id', $barangayId)->get();
            } else {
                $this->puroks = [];
            }
            $this->purok_id = null; // Reset selected puroks when barangay changes
        } catch (\Exception $e) {
            logger()->error('Error fetching puroks', [
                'barangay_id' => $barangayId,
                'error' => $e->getMessage()
            ]);
        }
        $this->isLoading = false;
    }

    public function updatedSelectedPO($value)
    {
        Log::info('Updated selectedPO: ' . $value); // Add this for debugging
        if ($value) {
            $this->export($value);
        }
    }
    public function export($poNumber)
    {
        Log::info('Exporting PO: ' . $poNumber);

        return Excel::download(
            new RisDataExport($this->grantee, $poNumber),
            "Acknowledgement_Receipt_{$poNumber}.xlsx"
        );
    }

    public function render()
    {
        $materialsList = Material::all(); // Fetch all materials for the dropdown
        $OriginOfRequests = OriginOfRequest::all();
        return view('livewire.grantee-details', [
            'grantee' => $this->grantee,
            'OriginOfRequests' => $OriginOfRequests,
            'barangays' => Barangay::all(),
            'poNumbers' => $this->poNumbers,
            'materialsList' => $materialsList, // Add materials list for the dropdown
        ])
            ->layout('layouts.adminshelter');
    }
}
