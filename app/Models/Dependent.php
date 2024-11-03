<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dependent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tagged_and_validated_applicant_id',
        'dependent_civil_status_id',
        'dependent_first_name',
        'dependent_middle_name',
        'dependent_last_name',
        'dependent_sex',
        'dependent_date_of_birth',
        'dependent_relationship',
        'dependent_occupation',
        'dependent_monthly_income',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'tagged_and_validated_applicant_id' => 'integer',
        'dependent_civil_status_id' => 'integer',
    ];

    public function taggedAndValidatedApplicant(): BelongsTo
    {
        return $this->belongsTo(TaggedAndValidatedApplicant::class);
    }
    public function civilStatus(): BelongsTo
    {
        return $this->belongsTo(CivilStatus::class, 'dependent_civil_status_id', 'id');
    }
}
