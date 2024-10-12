<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShelterApplicantSpouse extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shelter_applicant_id',
        'first_name',
        'middle_name',
        'last_name',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'shelter_applicant_id' => 'integer',
    ];

    public function shelterApplicant(): BelongsTo
    {
        return $this->belongsTo(ShelterApplicant::class);
    }
}
