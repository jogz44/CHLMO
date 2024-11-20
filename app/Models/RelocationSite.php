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
        'address_id',
        'lot_number',
        'block_identifier',
        'relocation_site_name',
        'total_lot_size',
        'is_full'
    ];

    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'total_lot_size' => 'integer'
    ];

    public function updateFullStatus(): void
    {
        $remainingSize = $this->getRemainingLotSize();
        $this->update([
            'is_full' => $remainingSize <= 0
        ]);
    }
    public function getRemainingLotSize(): float
    {
        return $this->total_lot_size - $this->awardees()->sum('lot_size');
    }
    public function taggedAndValidatedApplicants(): HasMany
    {
        return $this->hasMany(TaggedAndValidatedApplicant::class, 'relocation_lot_id', 'id');
    }
    public function awardees(): HasMany
    {
        return $this->hasMany(Awardee::class, 'relocation_lot_id', 'id');
    }
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
