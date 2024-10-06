<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Applicant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'transaction_type_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix_name',
        'contact_number',
        'date_applied',
        'initially_interviewed_by',
        'address_id',
        'applicant_id',
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
        'transaction_type_id' => 'integer',
        'date_applied' => 'date',
    ];

    /**
     * Generate a unique applicant ID for the current year.
     *
     * @return string
     */
    public static function generateApplicantId()
    {
        $currentYear = Carbon::now()->year;

        // Increment the count for the current year
        $countForYear = ApplicantCounter::incrementCountForYear($currentYear);

        // Format the ID: "YYYY-000XXX"
        $applicantId = sprintf('%d-%06d', $currentYear, $countForYear);

        // Log the generated values for debugging
        logger()->info('Generating applicant ID', [
            'year' => $currentYear,
            'count' => $countForYear
        ]);

        return $applicantId;
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function spouse(): BelongsTo
    {
        return $this->belongsTo(Spouse::class);
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
