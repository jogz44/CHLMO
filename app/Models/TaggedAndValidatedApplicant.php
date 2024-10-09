<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'religion_id',
        'living_situation_id',
        'living_situation_case_specification',
        'government_program_id',
        'living_status_id',
        'roof_type_id',
        'wall_type_id',
        'full_address',
        'sex',
        'date_of_birth',
        'occupation',
        'monthly_income',
        'family_income',
        'tagging_date',
        'rent_fee',
        'landlord',
        'house_owner',
        'tagger_name',
        'remarks',
        'photos',
        'is_tagged'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'tagged_date'  => 'datetime',
        'monthly_income' => 'integer',
        'family_income'  => 'integer',
        'rent_fee'       => 'integer',
    ];

    /**
     * Define relationships to other models.
     */

    // Relationship with Applicant
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }
    public function civilStatus(): BelongsTo
    {
        return $this->belongsTo(CivilStatus::class);
    }
    public function tribe(): BelongsTo
    {
        return $this->belongsTo(Tribe::class);
    }
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    // Relationship with Religion
    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }

    // Relationship with Spouse
    public function spouse(): BelongsTo
    {
        return $this->belongsTo(Spouse::class);
    }

    // Relationship with Dependent
    public function dependent(): BelongsTo
    {
        return $this->belongsTo(Dependent::class);
    }

    // Relationship with LivingSituation
    public function livingSituation(): BelongsTo
    {
        return $this->belongsTo(LivingSituation::class);
    }

    // Relationship with CaseSpecification
    public function caseSpecification(): BelongsTo
    {
        return $this->belongsTo(CaseSpecification::class);
    }

    // Relationship with CaseSpecification
    public function governmentProgram(): BelongsTo
    {
        return $this->belongsTo(GovernmentProgram::class);
    }

    // Relationship with LivingStatus
    public function livingStatus(): BelongsTo
    {
        return $this->belongsTo(LivingStatus::class);
    }

    // Relationship with RoofType
    public function roofType(): BelongsTo
    {
        return $this->belongsTo(RoofType::class);
    }

    // Relationship with WallType
    public function wallType(): BelongsTo
    {
        return $this->belongsTo(WallType::class);
    }
}
