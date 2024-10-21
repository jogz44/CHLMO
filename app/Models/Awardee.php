<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
//        'letter_of_intent_photo',
//        'voters_id_photo',
//        'valid_id_photo',
//        'certificate_of_no_land_holding_photo',
//        'marriage_certificate_photo',
//        'birth_certificate_photo',
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
}
