<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagged_and_validated_applicant_id',
        'spouse_first_name',
        'spouse_middle_name',
        'spouse_last_name',
        'spouse_occupation',
        'spouse_monthly_income',
    ];

    protected $casts = [
        'id' => 'integer',
        'tagged_and_validated_applicant_id' => 'integer',
    ];

//    public function taggedAndValidatedApplicants(): HasMany
//    {
//        return $this->hasMany(TaggedAndValidatedApplicant::class);
//    }
    public function taggedAndValidatedApplicant(): BelongsTo
    {
        return $this->belongsTo(TaggedAndValidatedApplicant::class, 'tagged_and_validated_applicant_id');
    }
}
