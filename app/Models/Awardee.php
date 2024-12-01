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
        'assigned_relocation_site_id',
        'actual_relocation_site_id',
        'lot_size',
        'unit',
        'grant_date',
        'has_assigned_relocation_site',
        'documents_submitted',
        'is_awarded',
        'is_blacklisted'
    ];

    protected $casts = [
        'id' => 'integer',
        'tagged_and_validated_applicant_id' => 'integer',
        'relocation_lot_id' => 'integer',
        'grant_date' => 'datetime',
        'has_assigned_relocation_site' => 'boolean',
        'documents_submitted' => 'boolean',
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
    public function assignedRelocationSite(): BelongsTo
    {
        return $this->belongsTo(RelocationSite::class, 'assigned_relocation_site_id');
    }
    public function actualRelocationSite(): BelongsTo
    {
        return $this->belongsTo(RelocationSite::class, 'actual_relocation_site_id');
    }
    public function lotSizeUnit(): BelongsTo
    {
        return $this->belongsTo(LotSizeUnit::class, 'lot_size_unit_id', 'id');
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
