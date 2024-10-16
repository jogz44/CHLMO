<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShelterApplicant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'request_origin_id',
        'profile_no',
        'first_name',
        'middle_name',
        'last_name',
        'date_request',
        'is_tagged',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'request_origin_id' => 'integer',
        'date_request' => 'date',
    ];
    public function originOfRequest(): BelongsTo
    {
        return $this->belongsTo(OriginOfRequest::class, 'request_origin_id');
    }

    public function profiledTaggedApplicant(): HasOne
    {
        return $this->hasOne(ProfiledTaggedApplicant::class, 'applicant_id');
    }

    public function spouse(): HasOne
    {
        return $this->hasOne(ShelterApplicantSpouse::class, 'applicant_id');
    }
}
