<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Awardee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tagged_and_validated_applicant_id',
        'address_id',
        'lot_id',
        'lot_size',
        'lot_size_unit_id',
        'grant_date',
        'is_awarded'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tagged_and_validated_applicant_id' => 'integer',
        'address_id' => 'integer',
        'lot_id' => 'integer',
        'grant_date' => 'datetime'
    ];

    public function taggedAndValidatedApplicant(): BelongsTo
    {
        return $this->belongsTo(TaggedAndValidatedApplicant::class);
    }
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
    public function lot(): BelongsTo
    {
        return $this->belongsTo(LotList::class, 'lot_id');
    }
    public function lotSizeUnit(): BelongsTo
    {
        return $this->belongsTo(LotSizeUnit::class, 'lot_size_unit_id', 'id');
    }
    public function awardeeDocumentsSubmissions(): HasMany
    {
        return $this->hasMany(AwardeeDocumentsSubmission::class, 'awardee_id');
    }
}
