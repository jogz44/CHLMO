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
        // Load the relationship if not already loaded
        if (!$awardee->relationLoaded('assignedRelocationSite')) {
            $awardee->load('assignedRelocationSite');
        }

        if ($awardee->assignedRelocationSite) {
            $awardee->assignedRelocationSite->updateFullStatus();
        }
    }

    /**
     * Handle the Awardee "updated" event.
     */
    public function updated(Awardee $awardee): void
    {

        $shouldUpdateStatus = $awardee->isDirty('assigned_relocation_lot_size') ||
            $awardee->isDirty('assigned_relocation_site_id') ||
            $awardee->isDirty('actual_relocation_lot_size') ||
            $awardee->isDirty('actual_relocation_site_id');

        if ($shouldUpdateStatus) {
            // Update assigned site status
            if (!$awardee->relationLoaded('assignedRelocationSite')) {
                $awardee->load('assignedRelocationSite');
            }
            if ($awardee->assignedRelocationSite) {
                $awardee->assignedRelocationSite->updateFullStatus();
            }

            // Update actual site status
            if (!$awardee->relationLoaded('actualRelocationSite')) {
                $awardee->load('actualRelocationSite');
            }
            if ($awardee->actualRelocationSite) {
                $awardee->actualRelocationSite->updateFullStatus();
            }

            // Update old sites if changed
            if ($awardee->isDirty('assigned_relocation_site_id')) {
                $oldSite = RelocationSite::find($awardee->getOriginal('assigned_relocation_site_id'));
                if ($oldSite) {
                    $oldSite->updateFullStatus();
                }
            }
            if ($awardee->isDirty('actual_relocation_site_id')) {
                $oldActualSite = RelocationSite::find($awardee->getOriginal('actual_relocation_site_id'));
                if ($oldActualSite) {
                    $oldActualSite->updateFullStatus();
                }
            }
        }
    }

    /**
     * Handle the Awardee "deleted" event.
     */
    public function deleted(Awardee $awardee): void
    {
        // Load the relationship if not already loaded
        if (!$awardee->relationLoaded('assignedRelocationSite')) {
            $awardee->load('assignedRelocationSite');
        }

        if ($awardee->assignedRelocationSite) {
            $awardee->assignedRelocationSite->updateFullStatus();
        }
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
