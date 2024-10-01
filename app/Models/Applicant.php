<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'phone',
        'date_applied',
        'initially_interviewed_by',
        'address_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionType()
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

    public function taggedAndValidatedApplicant(): HasOne
    {
        return $this->hasOne(TaggedAndValidatedApplicant::class);
    }
}
