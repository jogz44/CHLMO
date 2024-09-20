<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'civil_status_id',
        'tribe_id',
        'spouse_id',
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'phone',
        'gender',
        'occupation',
        'income',
        'date_applied',
        'initially_interviewed_by',
        'status',
        'tagger_name',
        'tagging_date',
        'awarded_by',
        'awarding_date',
        'photo',
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
        'civil_status_id' => 'integer',
        'tribe_id' => 'integer',
        'spouse_id' => 'integer',
        'date_applied' => 'datetime',
        'tagging_date' => 'datetime',
        'awarding_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactionType(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function civilStatus(): BelongsTo
    {
        return $this->belongsTo(CivilStatus::class);
    }

    public function tribe(): BelongsTo
    {
        return $this->belongsTo(Tribe::class);
    }

    public function spouse(): BelongsTo
    {
        return $this->belongsTo(Spouse::class);
    }

    public function awardees(): HasMany
    {
        return $this->hasMany(Awardee::class);
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(Dependent::class);
    }

    public function transferredAwardees(): HasMany
    {
        return $this->hasMany(TransferredAwardee::class);
    }

    public function applicantTribes(): HasMany
    {
        return $this->hasMany(ApplicantTribe::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
