<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaggedAndValidatedApplicant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'applicant_id',
        'civil_status_id',
        'tribe_id',
        'address_id',
        'religion_id',
        'spouse_id',
        'dependent_id',
        'living_situation_id',
        'case_specification_id',
        'living_status_id',
        'wall_type_id',
        'landmark',
        'gender',
        'date_of_birth',
        'occupation',
        'monthly_income',
        'family_income',
        'awarding_date',
        'rent_fee',
        'status',
        'tagger_name',
        'tagging_date',
        'awarded_by',
        'photo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'awarding_date' => 'datetime',
        'tagging_date'  => 'datetime',
        'monthly_income' => 'integer',
        'family_income'  => 'integer',
        'rent_fee'       => 'integer',
    ];

    /**
     * Define relationships to other models.
     */

    // Relationship with Applicant
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    // Relationship with CivilStatus
    public function civilStatus()
    {
        return $this->belongsTo(CivilStatus::class);
    }

    // Relationship with Tribe
    public function tribe()
    {
        return $this->belongsTo(Tribe::class);
    }

    // Relationship with Address
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    // Relationship with Religion
    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    // Relationship with Spouse
    public function spouse()
    {
        return $this->belongsTo(Spouse::class);
    }

    // Relationship with Dependent
    public function dependent()
    {
        return $this->belongsTo(Dependent::class);
    }

    // Relationship with LivingSituation
    public function livingSituation()
    {
        return $this->belongsTo(LivingSituation::class);
    }

    // Relationship with CaseSpecification
    public function caseSpecification()
    {
        return $this->belongsTo(CaseSpecification::class);
    }

    // Relationship with LivingStatus
    public function livingStatus()
    {
        return $this->belongsTo(LivingStatus::class);
    }

    // Relationship with WallType
    public function wallType()
    {
        return $this->belongsTo(WallType::class);
    }
}
