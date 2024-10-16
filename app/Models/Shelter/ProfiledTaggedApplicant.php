<?php

namespace App\Models\Shelter;

use App\Models\Address;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\Religion;
use App\Models\Tribe;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProfiledTaggedApplicant extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shelter_applicant_id',
        'civil_status_id',
        'religion_id',
        'address_id',
        'government_program_id',
        'tribe_id',
        'living_situation_id',
        'case_specification_id',
        'living_situation_case_specification',
        'date_of_birth',
        'sex',
        'occupation',
        'years_of_residency',
        'contact_number',
        'house_no_or_street_name',
        'date_tagged',
        'remarks'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'shelter_applicant_id' => 'integer',
        'civil_status_id' => 'integer',
        'religion_id' => 'integer',
        'address_id' => 'integer',
        'government_program_id' => 'integer',
        'tribe_id' => 'integer',
        'living_situation_id' => 'integer',
        'case_specification_id' => 'integer',
        'date_tagged' => 'date',
    ];

    public function shelterApplicant(): BelongsTo
    {
        return $this->belongsTo(ShelterApplicant::class);
    }
    public function civilStatus(): BelongsTo
    {
        return $this->belongsTo(CivilStatus::class);
    }
    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
    public function governmentProgram(): BelongsTo
    {
        return $this->belongsTo(GovernmentProgram::class);
    }
    public function tribe(): BelongsTo
    {
        return $this->belongsTo(Tribe::class);
    }
    public function livingSituation(): BelongsTo
    {
        return $this->belongsTo(LivingSituation::class);
    }
    public function caseSpecification(): BelongsTo
    {
        return $this->belongsTo(CaseSpecification::class);
    }

    public function grantees(): HasMany
    {
        return $this->hasMany(Grantee::class);
    }
}
