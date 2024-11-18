<?php

namespace App\Livewire;

use App\Models\Awardee;
use App\Models\AwardeeTransferHistory;
use App\Models\Blacklist;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AwardeeList extends Component
{
    use WithPagination;
    public $showTransferModal = false, $showConfirmationModal = false, $selectedAwardeeId, $eligibleDependents = [],
        $selectedDependentId, $selectedDependent;
    public function confirmTransfer($dependentId): void
    {
        $this->selectedDependentId = $dependentId;

        // Get the dependent's details for display in confirmation modal
        $awardee = Awardee::with(['taggedAndValidatedApplicant.dependents'])->find($this->selectedAwardeeId);
        $this->selectedDependent = $awardee->taggedAndValidatedApplicant->dependents
            ->where('id', $dependentId)
            ->first();

        $this->showConfirmationModal = true;
    }
    public function cancelTransfer(): void
    {
        $this->showConfirmationModal = false;
        $this->selectedDependentId = null;
        $this->selectedDependent = null;
    }
    public function proceedWithTransfer(): void
    {
        try {
            logger()->info('Starting transfer process', [
                'selectedDependentId' => $this->selectedDependentId,
                'selectedAwardeeId' => $this->selectedAwardeeId
            ]);

            $this->transferAward($this->selectedDependentId);

            $this->showConfirmationModal = false;
            $this->showTransferModal = false;
            $this->reset(['selectedAwardeeId', 'eligibleDependents', 'selectedDependentId', 'selectedDependent']);

            $this->dispatch('transfer-completed')->self();

        } catch (\Exception $e) {
            logger()->error('Transfer process failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('error', 'Failed to transfer award: ' . $e->getMessage());
        }
    }

    public function openTransferModal($awardeeId): void
    {
        $this->selectedAwardeeId = $awardeeId;
        $this->loadEligibleDependents();
        $this->showTransferModal = true;
    }
    public function loadEligibleDependents(): void
    {
        // Get the awardee's dependents who are children or parents
        $awardee = Awardee::with([
            'taggedAndValidatedApplicant.dependents' => function ($query) {
                $query->whereHas('dependentRelationship', function ($query) {
                    $query->whereIn('relationship', [
                        'Child (Biological)',
                        'Mother',
                        'Father'
                    ]);
                });
            },
            'taggedAndValidatedApplicant.dependents.dependentRelationship'  // Eager load the relationship
        ])->findOrFail($this->selectedAwardeeId);

        $this->eligibleDependents = $awardee->taggedAndValidatedApplicant->dependents;
    }

    public function transferAward($dependentId): void
    {
        try {
            DB::beginTransaction();

            // Get the current awardee
            $currentAwardee = Awardee::with([
                'taggedAndValidatedApplicant.dependents.dependentRelationship',
            ])->findOrFail($this->selectedAwardeeId);

            // Get the dependent
            $dependent = $currentAwardee->taggedAndValidatedApplicant->dependents()
                ->with('dependentRelationship')
                ->where('id', $dependentId)
                ->firstOrFail();

            // Create blacklist record
            $blacklist = new Blacklist([
                'awardee_id' => $currentAwardee->id,
                'user_id' => auth()->id(),
                'blacklist_reason_description' => 'Deceased - Award transferred to ' . $dependent->dependent_first_name . ' ' . $dependent->dependent_last_name,
                'date_blacklisted' => now(),
                'updated_by' => auth()->id()
            ]);
            $blacklist->save();

            // Update current awardee
            $currentAwardee->update([
                'is_blacklisted' => true
            ]);

            // Create transfer history only
            $transferHistory = AwardeeTransferHistory::create([
                'previous_awardee_id' => $currentAwardee->id,
                'transfer_date' => now(),
                'transfer_reason' => 'Death of previous awardee',
                'relationship' => $dependent->dependentRelationship->relationship, // Get relationship from the relationship table
                'processed_by' => auth()->id(),
                'remarks' => $dependent->dependent_first_name . ' ' . $dependent->dependent_last_name
            ]);

            DB::commit();
            logger()->info('Transfer completed successfully', [
                'transfer_to' => $dependent->dependent_first_name . ' ' . $dependent->dependent_last_name
            ]);

            session()->flash('message', 'Award successfully transferred to ' . $dependent->dependent_first_name . ' ' . $dependent->dependent_last_name);

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Transfer failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            throw $e;
        }
    }

    public function render()
    {
        $awardees = Awardee::with([
            'taggedAndValidatedApplicant.applicant.person',
            'address',
            'relocationLot',
            'lotSizeUnit'
        ])->orderBy('created_at', 'desc')->paginate( 10);

        return view('livewire.awardee-list', [
            'awardees' => $awardees
        ]);
    }
}
