<?php

namespace App\Models\Shelter;

use App\Models\ApplicantCounter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;


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

    public static function generateProfileNo()
    {
        $currentYear = Carbon::now()->year;

        // Increment the count for the current year
        $countForYear = ApplicantCounter::incrementCountForYear($currentYear);

        // Format the ID: "YYYY-000XXX"
        $profileNo = sprintf('%d-%06d', $currentYear, $countForYear);

        // Log the generated values for debugging
        logger()->info('Generating Profile No', [
            'year' => $currentYear,
            'count' => $countForYear
        ]);

        return $profileNo;
    }

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
