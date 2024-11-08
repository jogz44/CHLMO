<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveInPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagged_and_validated_applicant_id',
        'partner_first_name',
        'partner_middle_name',
        'partner_last_name',
        'partner_occupation',
        'partner_monthly_income',
    ];

    protected $casts = [
        'id' => 'integer',
        'tagged_and_validated_applicant_id' => 'integer',
    ];

    public function taggedAndValidatedApplicant(): BelongsTo
    {
        return $this->belongsTo(TaggedAndValidatedApplicant::class, 'tagged_and_validated_applicant_id');
    }
}
