<?php

namespace App\Livewire;

use App\Models\Awardee;
use Livewire\Component;

class TransferAwardee extends Component
{
    public $awardee;
    public $showModal = false;

    protected $listeners = ['openTransferModal' => 'openModal'];

    public function mount(Awardee $awardee)
    {
        $this->awardee = $awardee;
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function initiateTransfer()
    {
        if (!$this->awardee) {
            return;
        }

        // Store awardee data in session
        session([
            'transfer_data' => [
                'previous_awardee_id' => $this->awardee->id,
                'previous_awardee_name' => $this->awardee->taggedAndValidatedApplicant->applicant->person->full_name,
                'relocation_site' => $this->awardee->actualRelocationSite?->relocation_site_name ?? $this->awardee->assignedRelocationSite->relocation_site_name,
                'block' => $this->awardee->actual_block ?? $this->awardee->assigned_block,
                'lot' => $this->awardee->actual_lot ?? $this->awardee->assigned_lot,
                'lot_size' => $this->awardee->actual_relocation_lot_size ?? $this->awardee->assigned_relocation_lot_size,
                'unit' => $this->awardee->unit
            ]
        ]);

        return redirect()->route('add-new-occupant');
    }

    public function render()
    {
        return view('livewire.transfer-awardee');
    }
}
