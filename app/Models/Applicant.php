<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'person_id',
        'user_id',
        'transaction_type_id',
        'address_id',
        'date_applied',
        'initially_interviewed_by',
        'is_tagged',
    ];

    protected $casts = [
        'id' => 'integer',
        'person_id' => 'integer',
        'user_id' => 'integer',
        'transaction_type_id' => 'integer',
        'date_applied' => 'date',
    ];

//    public static function generateApplicantId(): string
//    {
//        $currentYear = Carbon::now()->year;
//
//        // Increment the count for the current year
//        $countForYear = ApplicantCounter::incrementCountForYear($currentYear);
//
//        // Format the ID: "YYYY-000XXX"
//        $applicantId = sprintf('%d-%06d', $currentYear, $countForYear);
//
//        // Log the generated values for debugging
//        logger()->info('Generating applicant ID', [
//            'year' => $currentYear,
//            'count' => $countForYear
//        ]);
//
//        return $applicantId;
//    }
    public static function generateApplicantId(): string
    {
        $currentYear = Carbon::now()->year;

        // Use the same constant as defined in People model
        $countForYear = ApplicantCounter::incrementCountForYear(
            $currentYear,
            ApplicantCounter::TYPE_HOUSING
        );

        // Format the ID: "YYYY-000XXX"
        $applicantId = sprintf('%d-%06d', $currentYear, $countForYear);

        logger()->info('Generating applicant ID', [
            'year' => $currentYear,
            'count' => $countForYear,
            'type' => ApplicantCounter::TYPE_HOUSING
        ]);

        return $applicantId;
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function person(): BelongsTo
    {
        return $this->belongsTo(People::class, 'person_id', 'id');
    }

    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function spouse(): BelongsTo
    {
        return $this->belongsTo(Spouse::class);
    }
    public function dependent(): BelongsTo
    {
        return $this->belongsTo(Dependent::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function taggedAndValidated(): HasOne
    {
        return $this->hasOne(TaggedAndValidatedApplicant::class, 'applicant_id', 'id');
    }
}
