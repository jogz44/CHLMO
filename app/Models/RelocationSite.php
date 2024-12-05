<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RelocationSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'barangay_id',
        'relocation_site_name',
        'total_land_area',
        'total_no_of_lots',
        'community_facilities_road_lots_open_space',
        'is_full'
    ];

    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'total_land_area' => 'integer',
        'total_no_of_lots' => 'integer',
        'community_facilities_road_lots_open_space' => 'integer'
    ];

    public function getRemainingLotSize(): float
    {
        $totalAvailableLots = $this->total_no_of_lots - $this->community_facilities_road_lots_open_space;

        // Calculate total allocated space based on actual or assigned lot sizes
        $totalAllocatedSpace = $this->awardees()
            ->get()
            ->sum(function ($awardee) {
                // Use actual Lot size if available, otherwise use assigned lot size
                return $awardee->actual_relocation_lot_size ?? $awardee->assigned_relocation_lot_size;
            });

        return $totalAvailableLots - $totalAllocatedSpace;
    }
    public function updateFullStatus(): void
    {
        $remainingSize = $this->getRemainingLotSize();
        $this->update([
            'is_full' => $remainingSize <= 0
        ]);
    }
    public function actualAwardees(): HasMany
    {
        return $this->hasMany(Awardee::class, 'actual_relocation_site_id', 'id');
    }
    public function awardees(): HasMany
    {
        return $this->hasMany(Awardee::class, 'assigned_relocation_site_id', 'id');
    }
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }
}
