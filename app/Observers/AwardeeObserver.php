<?php

namespace App\Observers;

use App\Models\Awardee;
use App\Models\RelocationSite;

class AwardeeObserver
{
    /**
     * Handle the Awardee "created" event.
     */
    public function created(Awardee $awardee): void
    {
        $awardee->relocationLot->updateFullStatus();
    }

    /**
     * Handle the Awardee "updated" event.
     */
    public function updated(Awardee $awardee): void
    {
        if ($awardee->isDirty('lot_size') || $awardee->isDirty('relocation_lot_id')) {
            $awardee->relocationLot->updateFullStatus();

            // If relocation site was changed, update old one too
            if ($awardee->isDirty('relocation_lot_id')) {
                RelocationSite::find($awardee->getOriginal('relocation_lot_id'))
                    ?->updateFullStatus();
            }
        }
    }

    /**
     * Handle the Awardee "deleted" event.
     */
    public function deleted(Awardee $awardee): void
    {
        $awardee->relocationLot->updateFullStatus();
    }

    /**
     * Handle the Awardee "restored" event.
     */
    public function restored(Awardee $awardee): void
    {
        //
    }

    /**
     * Handle the Awardee "force deleted" event.
     */
    public function forceDeleted(Awardee $awardee): void
    {
        //
    }
}
