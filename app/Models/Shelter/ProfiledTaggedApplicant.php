<?php

namespace App\Models\Shelter;

use App\Models\Address;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\GovernmentProgram;
use App\Models\Shelter\ShelterLivingStatus;
use App\Models\Religion;
use App\Models\Tribe;
use App\Models\Shelter\OriginOfRequest;
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
        'profile_no',
        'request_origin_id',
        'age',
        'civil_status_id',
        'religion_id',
        'address_id',
        'government_program_id',
        'tribe_id',
        'shelter_living_status_id',
        'case_specification_id',
        'living_situation_case_specification',
        'sex',
        'occupation',
        'year_of_residency',
        'contact_number',
        'date_tagged',
        'remarks',
        'is_tagged',
        'first_name',
        'middle_name',
        'last_name',
        'is_awarding_on_going',
        'date_request',
        'is_granted'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'age' => 'integer',
        'civil_status_id' => 'integer',
        'request_origin_id' => 'integer',
        'religion_id' => 'integer',
        'address_id' => 'integer',
        'government_program_id' => 'integer',
        'year_of_residency' => 'integer',
        'shelter_living_status_id' => 'integer',
        'tribe_id' => 'integer',
        'living_situation_id' => 'integer',
        'case_specification_id' => 'integer',
        'date_tagged' => 'date',
    ];

    public function shelterApplicant()
    {
        return $this->belongsTo(ShelterApplicant::class, 'profile_no', 'id');
    }
    public function civilStatus(): BelongsTo
    {
        return $this->belongsTo(CivilStatus::class);
    }
    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function governmentProgram(): BelongsTo
    {
        return $this->belongsTo(GovernmentProgram::class);
    }
    public function tribe(): BelongsTo
    {
        return $this->belongsTo(Tribe::class);
    }
    public function shelterLivingStatus(): BelongsTo
    {
        return $this->belongsTo(ShelterLivingStatus::class);
    }
    public function caseSpecification(): BelongsTo
    {
        return $this->belongsTo(CaseSpecification::class);
    }

    public function originOfRequest(): BelongsTo
    {
        return $this->belongsTo(OriginOfRequest::class, 'request_origin_id', 'id');
    }

    public function grantees(): HasMany
    {
        return $this->hasMany(Grantee::class);
    }
}
