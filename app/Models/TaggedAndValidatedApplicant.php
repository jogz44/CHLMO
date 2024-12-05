<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TaggedAndValidatedApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id', 'civil_status_id', 'tribe', 'religion', 'living_situation_id', 'case_specification_id',
        'living_situation_case_specification', 'non_informal_settler_case_specification', 'government_program_id', 'living_status_id', 'roof_type_id',
        'wall_type_id', 'structure_status_id', 'full_address', 'sex', 'date_of_birth', 'occupation',
        'monthly_income', 'tagging_date', 'room_rent_fee', 'room_landlord', 'house_rent_fee', 'house_landlord',
        'lot_rent_fee', 'lot_landlord', 'house_owner', 'relationship_to_house_owner', 'tagger_name',
        'years_of_residency', 'voters_id_number', 'remarks', 'is_tagged', 'is_awarding_on_going',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'tagging_date'  => 'datetime',
        'monthly_income' => 'integer',
        'rent_fee' => 'integer',
        'years_of_residency' => 'integer'
    ];

    // Relationship with Applicant
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }
    public function person(): BelongsTo
    {
        return $this->belongsTo(People::class, 'person_id', 'id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
    public function awardees(): HasMany
    {
        return $this->hasMany(Awardee::class, 'tagged_and_validated_applicant_id');
    }
    public function civilStatus(): BelongsTo
    {
        return $this->belongsTo(CivilStatus::class, 'civil_status_id');
    }
    public function spouse(): HasOne
    {
        return $this->hasOne(Spouse::class, 'tagged_and_validated_applicant_id');
    }
    public function liveInPartner(): HasOne
    {
        return $this->hasOne(LiveInPartner::class, 'tagged_and_validated_applicant_id');
    }

    // Relationship with Dependent
    public function dependents(): HasMany
    {
        return $this->hasMany(Dependent::class, 'tagged_and_validated_applicant_id');
    }

    // Relationship with LivingSituation
    public function livingSituation(): BelongsTo
    {
        return $this->belongsTo(LivingSituation::class, 'living_situation_id');
    }
    // Relationship with CaseSpecification
    public function caseSpecification(): BelongsTo
    {
        return $this->belongsTo(CaseSpecification::class);
    }

    // Relationship with government Program
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
    public function structureStatus(): BelongsTo
    {
        return $this->belongsTo(StructureStatusType::class);
    }
    public function taggedDocuments(): HasMany
    {
        return $this->hasMany(TaggedDocumentsSubmission::class, 'tagged_applicant_id');
    }
}
