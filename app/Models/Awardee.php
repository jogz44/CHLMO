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
        'assigned_lot',
        'assigned_block',
        'assigned_relocation_lot_size',
        'actual_relocation_site_id',
        'actual_lot',
        'actual_block',
        'actual_relocation_lot_size',
        'unit',
        'grant_date',
        'previous_awardee_name',
        'has_assigned_relocation_site',
        'documents_submitted',
        'is_awarded',
        'is_blacklisted'
    ];

    protected $casts = [
        'id' => 'integer',
        'tagged_and_validated_applicant_id' => 'integer',
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
    // Get the previous awardee for a transfer case
    public function previousAwardee(): BelongsTo
    {
        return $this->belongsTo(Awardee::class, 'previous_awardee_id');
    }
    // Get the new awardee that replaced this one
    public function newAwardee(): HasOne
    {
        return $this->hasOne(Awardee::class, 'previous_awardee_id', 'id');
    }
    // Get the transfer history records where this awardee was the previous awardee
    public function transferHistories(): HasMany
    {
        return $this->hasMany(AwardeeTransferHistory::class, 'previous_awardee_id');
    }
    public function documents(): HasMany
    {
        return $this->hasMany(AwardeeDocumentsSubmission::class, 'awardee_id');
    }
}
