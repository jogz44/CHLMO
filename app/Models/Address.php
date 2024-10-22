<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'barangay_id',
        'purok_id',
        'full_address',
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'barangay_id' => 'integer',
        'purok_id' => 'integer',
        'full_address' => 'string',
    ];

    /**
     * Get the purok associated with this address.
     */
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }
    public function purok(): BelongsTo
    {
        return $this->belongsTo(Purok::class);
    }
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class, 'address_id'); // `address_id` should be in the `applicants` table
    }
    public function taggedAndValidatedApplicants()
    {
        return $this->hasMany(TaggedAndValidatedApplicant::class);
    }
    public function awardees()
    {
        return $this->hasMany(Awardee::class);
    }
}
