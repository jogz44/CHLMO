<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Shelter\ProfiledTaggedApplicant;

class ShelterLiveInPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'profiled_tagged_applicant_id',
        'partner_first_name',
        'partner_middle_name',
        'partner_last_name',
    ];

    protected $casts = [
        'id' => 'integer',
        'profiled_tagged_applicant_id' => 'integer',
    ];

    public function profiledTaggedApplicant(): BelongsTo
    {
        return $this->belongsTo(ProfiledTaggedApplicant::class, 'profiled_tagged_applicant_id');
    }
}
