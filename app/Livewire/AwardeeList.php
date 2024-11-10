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
        // Get the awardee's dependents who are either children or spouse
        $awardee = Awardee::with([
            'taggedAndValidatedApplicant.dependents' => function ($query) {
                $query->whereIn('dependent_relationship', ['Son', 'son', 'Daughter', 'daughter', 'Spouse', 'spouse']);
            }])->findOrFail($this->selectedAwardeeId);

        $this->eligibleDependents = $awardee->taggedAndValidatedApplicant->dependents;
    }
//    public function transferAward($dependentId): void
//    {
//        // Implement your award transfer logic here
//        // For example:
//        // 1. Update the current awardee's status
//        // 2. Create a new awardee record for the dependent
//        // 3. Transfer all relevant records and relationships
//
//        try {
//            DB::beginTransaction();
//
//            // Log the start of the process
//            logger()->info('Starting DB transaction', [
//                'dependentId' => $dependentId,
//                'awardeeId' => $this->selectedAwardeeId
//            ]);
//
//            // Get the current awardee with all necessary relationships
//            $currentAwardee = Awardee::with([
//                'taggedAndValidatedApplicant.dependents',
//                'address',
//                'lot',
//                'lotSizeUnit'
//            ])->findOrFail($this->selectedAwardeeId);
//
//            logger()->info('Current awardee loaded', [
//                'awardee_id' => $currentAwardee->id
//            ]);
//
//            // Get the dependent
//            $dependent = $currentAwardee->taggedAndValidatedApplicant->dependents()
//                ->where('id', $dependentId)
//                ->firstOrFail();
//
//            logger()->info('Dependent found', [
//                'dependent_id' => $dependent->id
//            ]);
//
//            // Create a blacklist record to mark the awardee as deceased
//            $blacklist = new Blacklist([
//                'awardee_id' => $currentAwardee->id,
//                'user_id' => auth()->id(),
//                'blacklist_reason_description' => 'Deceased - Award transferred to ' . $dependent->dependent_first_name . ' ' . $dependent->dependent_last_name,
//                'date_blacklisted' => now(),
//                'updated_by' => auth()->id()
//            ]);
//            // Save the blacklist record
//            $blacklist->save();
//
//            logger()->info('Blacklist record created');
//
//            $currentAwardee->update([
//                'is_blacklisted' => true
//            ]);
//
//            logger()->info('Current awardee updated');
//
//            $newAwardee = Awardee::create([
//                'tagged_and_validated_applicant_id' => $currentAwardee->taggedAndValidatedApplicant->id,
//                'address_id' => $currentAwardee->address_id,
//                'lot_id' => $currentAwardee->lot_id,
//                'lot_size' => $currentAwardee->lot_size,
//                'lot_size_unit_id' => $currentAwardee->lot_size_unit_id,
//                'grant_date' => now(),
//                'is_awarded' => true,
//                'is_blacklisted' => false
//            ]);
//
//            logger()->info('New awardee created', ['new_awardee_id' => $newAwardee->id]);
//
//            $transferHistory = AwardeeTransferHistory::create([
//                'previous_awardee_id' => $currentAwardee->id,
//                'new_awardee_id' => $newAwardee->id,
//                'transfer_date' => now(),
//                'transfer_reason' => 'Death of previous awardee',
//                'relationship' => $dependent->dependent_relationship,
//                'processed_by' => auth()->id(),
//                'remarks' => 'Award transferred due to death of original awardee'
//            ]);
//
//            logger()->info('Transfer history created', ['history_id' => $transferHistory->id]);
//
//            DB::commit();
//            logger()->info('Transaction committed successfully');
//
////            $this->showTransferModal = false;
////            $this->reset(['selectedAwardeeId', 'eligibleDependents']);
//
//            // success message here
//            $this->dispatch('alert', [
//                'title' => 'Award Transferred successfully!',
//                'message' => '<br><small>'. now()->calendar() .'</small>',
//                'type' => 'success'
//            ]);
//        } catch (\Exception $e) {
//            DB::rollBack();
//            logger()->error('Transfer failed', [
//                'error' => $e->getMessage(),
//                'line' => $e->getLine(),
//                'file' => $e->getFile(),
//                'trace' => $e->getTraceAsString()
//            ]);
//
//            throw $e; // Re-throw to be caught by the caller
//        }
//
//        $this->showTransferModal = false;
//        $this->reset(['selectedAwardeeId', 'eligibleDependents']);
//
//        // Show success message
//        session()->flash('message', 'Award transferred successfully.');
//    }

    public function transferAward($dependentId): void
    {
        try {
            DB::beginTransaction();

            // Get the current awardee
            $currentAwardee = Awardee::with([
                'taggedAndValidatedApplicant.dependents',
            ])->findOrFail($this->selectedAwardeeId);

            // Get the dependent
            $dependent = $currentAwardee->taggedAndValidatedApplicant->dependents()
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
                'relationship' => $dependent->dependent_relationship,
                'processed_by' => auth()->id(),
                'remarks' => 'Award transferred to ' . $dependent->dependent_first_name . ' ' . $dependent->dependent_last_name
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
            'taggedAndValidatedApplicant', 'address', 'lot', 'lotSizeUnit'
        ])->orderBy('created_at', 'desc')->paginate( 10);

        return view('livewire.awardee-list', [
            'awardees' => $awardees
        ]);
    }
}
