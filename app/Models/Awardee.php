<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Awardee extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagged_and_validated_applicant_id',
        'address_id',
        'relocation_lot_id',
        'lot_size',
        'lot_size_unit_id',
        'grant_date',
        'is_awarded',
        'is_blacklisted'
    ];

    protected $casts = [
        'id' => 'integer',
        'tagged_and_validated_applicant_id' => 'integer',
        'address_id' => 'integer',
        'relocation_lot_id' => 'integer',
        'grant_date' => 'datetime',
        'is_awarded' => 'boolean',
        'is_blacklisted' => 'boolean'
    ];

    public function taggedAndValidatedApplicant(): BelongsTo
    {
        return $this->belongsTo(TaggedAndValidatedApplicant::class);
    }
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
    public function relocationLot(): BelongsTo
    {
        return $this->belongsTo(RelocationSite::class, 'relocation_lot_id');
    }
    public function lotSizeUnit(): BelongsTo
    {
        return $this->belongsTo(LotSizeUnit::class, 'lot_size_unit_id', 'id');
    }
    public function awardeeDocumentsSubmissions(): HasMany
    {
        return $this->hasMany(AwardeeDocumentsSubmission::class, 'awardee_id');
    }
    public function blacklist(): HasOne
    {
        return $this->hasOne(Blacklist::class);
    }
    public function transfersAsOriginal(): HasMany
    {
        return $this->hasMany(AwardeeTransferHistory::class, 'previous_awardee_id');
    }
    public function transfersAsNew(): HasMany
    {
        return $this->hasMany(AwardeeTransferHistory::class, 'new_awardee_id');
    }
}
