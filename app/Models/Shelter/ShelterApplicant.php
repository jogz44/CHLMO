<?php

namespace App\Models\Shelter;

use App\Models\ApplicantCounter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use App\Models\People;


class ShelterApplicant extends Model
{
    use HasFactory;
    protected $table = 'shelter_applicants';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'person_id',
        'request_origin_id',
        'profile_no',
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
        'is_tagged' => 'boolean'
    ];

//    public static function generateProfileNo()
//    {
//        $currentYear = Carbon::now()->year;
//
//        // Increment the count for the current year
//        $countForYear = ApplicantCounter::incrementCountForYear($currentYear);
//
//        // Format the ID: "YYYY-000XXX"
//        $profileNo = sprintf('%d-%06d', $currentYear, $countForYear);
//
//        // Log the generated values for debugging
//        logger()->info('Generating Profile No', [
//            'year' => $currentYear,
//            'count' => $countForYear
//        ]);
//
//        return $profileNo;
//    }
    public static function generateProfileNo()
    {
        $currentYear = Carbon::now()->year;

        // Use the same constant as defined in People model
        $countForYear = ApplicantCounter::incrementCountForYear(
            $currentYear,
            ApplicantCounter::TYPE_SHELTER
        );

        // Format the ID: "YYYY-000XXX"
        $profileNo = sprintf('%d-%06d', $currentYear, $countForYear);

        logger()->info('Generating Profile No', [
            'year' => $currentYear,
            'count' => $countForYear,
            'type' => ApplicantCounter::TYPE_SHELTER
        ]);

        return $profileNo;
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(People::class, 'person_id');
    }

    public function originOfRequest(): BelongsTo
    {
        return $this->belongsTo(OriginOfRequest::class, 'request_origin_id', 'id');
    }

    public function profiledTagged(): HasOne
    {
        return $this->hasOne(ProfiledTaggedApplicant::class, 'profile_no');
    }

}
