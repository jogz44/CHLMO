<?php

namespace App\Livewire;

use App\Livewire\Logs\ActivityLogs;
use App\Models\Awardee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AwardAwardee extends Component
{
    public $awardee;
    public $showModal = false;
    public $grantDate;
    public $documentSubmitted = false;

    protected $listeners = ['openAwardModal' => 'openModal'];

    public function mount(Awardee $awardee)
    {
        $this->awardee = $awardee;
        // Set today's date as default
        $this->grantDate = now()->format('Y-m-d');
    }

    private function canAwardWithAssignedSite(): array
    {
        $site = $this->awardee->assignedRelocationSite;
        if (!$site) {
            return [
                'can_award' => false,
                'message' => 'No relocation site assigned.'
            ];
        }

        if ($site->is_full) {
            return [
                'can_award' => false,
                'message' => 'Assigned site is full. Please assign an actual relocation site.'
            ];
        }

        // Check available space
        $availableSpace = $site->getRemainingLotSize();
        $requiredSpace = $this->awardee->assigned_relocation_lot_size;

        if ($availableSpace < $requiredSpace) {
            return [
                'can_award' => false,
                'message' => 'Assigned site does not have enough space. Please assign an actual relocation site.'
            ];
        }

        return ['can_award' => true];
    }

    public function openModal()
    {
        if (!$this->awardee->assignedRelocationSite && !$this->awardee->actualRelocationSite) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Please assign a relocation site first.'
            ]);
            return;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function award()
    {
        $this->validate([
            'grantDate' => 'required|date|before_or_equal:today',
            'documentSubmitted' => 'required|accepted',  // This ensures checkbox must be checked
        ], [
            'documentSubmitted.accepted' => 'You must verify that all required documents have been submitted.'
        ]);

        try {
            DB::beginTransaction();

            // Check if we can proceed with assigned site
            if (!$this->awardee->actualRelocationSite) {
                $siteCheck = $this->canAwardWithAssignedSite();
                if (!$siteCheck['can_award']) {
                    $this->dispatch('alert', [
                        'type' => 'error',
                        'message' => $siteCheck['message']
                    ]);
                    return;
                }
            }

            // Update awardee
            $this->awardee->update([
                'grant_date' => $this->grantDate,
                'documents_submitted' => $this->documentSubmitted,
                'is_awarded' => true
            ]);

            // Log activity
            $logger = new ActivityLogs();
            $logger->logActivity(
                'Awarded property to ' . $this->awardee->taggedAndValidatedApplicant->applicant->person->full_name,
                Auth::user()
            );

            DB::commit();

            $this->showModal = false;
            $this->dispatch('alert', [
                'title' => 'Success!',
                'message' => 'Applicant has been successfully awarded.',
                'type' => 'success'
            ]);

            return redirect()->route('awardee-list');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Failed to process award. Please try again.'
            ]);
        }
    }

    public function render()
    {
        $isAwarded = $this->awardee->is_awarded;
        return view('livewire.award-awardee', compact('isAwarded'));
    }
}
