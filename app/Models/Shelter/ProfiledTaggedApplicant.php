<?php

namespace App\Models\Shelter;

use App\Models\Address;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\Shelter\ShelterSpouse;
use App\Models\Shelter\ShelterLiveInPartner;
use App\Models\ProfiledApplicantsDocumentsSubmission;
use App\Models\Purok;
use App\Models\Barangay;
use App\Models\StructureStatusType;
use App\Models\Shelter\OriginOfRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'religion',
        // 'address_id',
        'government_program_id',
        'tribe',
        'shelter_living_situation_id',
        'case_specification_id',
        'living_situation_case_specification',
        'sex',
        'full_address',
        'occupation',
        'year_of_residency',
        'contact_number',
        'date_tagged',
        'remarks',
        'structure_status_id',
        'is_tagged',
        'first_name',
        'middle_name',
        'last_name',
        'is_awarding_on_going',
        'documents_submitted',
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
        'government_program_id' => 'integer',
        'documents_submitted' => 'boolean',
        'year_of_residency' => 'integer',
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
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    // public function barangay()
    // {
    //     return $this->belongsTo(Barangay::class, 'barangay_id');
    // }
    public function governmentProgram(): BelongsTo
    {
        return $this->belongsTo(GovernmentProgram::class);
    }
    // public function purok()
    // {
    //     return $this->belongsTo(Purok::class, 'purok_id');
    // }
    // Relationship with LivingSituation
    public function shelterLivingSituation(): BelongsTo
    {
        return $this->belongsTo(ShelterLivingSituation::class, 'shelter_living_situation_id');
    }

    // Relationship with CaseSpecification
    public function caseSpecification(): BelongsTo
    {
        return $this->belongsTo(CaseSpecification::class);
    }
    public function shelterSpouse(): HasOne
    {
        return $this->hasOne(ShelterSpouse::class, 'profiled_tagged_applicant_id');
    }
    public function shelterLiveInPartner(): HasOne
    {
        return $this->hasOne(ShelterLiveInPartner::class, 'profiled_tagged_applicant_id');
    }
    public function originOfRequest(): BelongsTo
    {
        return $this->belongsTo(OriginOfRequest::class, 'request_origin_id', 'id');
    }
    public function structureStatus(): BelongsTo
    {
        return $this->belongsTo(StructureStatusType::class);
    }
    public function grantees(): HasMany
    {
        return $this->hasMany(Grantee::class);
    }
    public function photo()
    {
        return $this->hasMany(ShelterImagesForHousing::class, 'profiled_tagged_applicant_id');
    }
    public function images()
    {
        return $this->hasMany(ShelterImagesForHousing::class, 'profiled_tagged_applicant_id');
    }
    // In ProfiledTaggedApplicant model
    public function documents(): HasMany
    {
        return $this->hasMany(GranteeDocumentsSubmission::class, 'profiled_tagged_applicant_id');
    }
    public function taggedDocuments()
    {
        return $this->hasMany(ProfiledApplicantsDocumentsSubmission::class, 'profiled_tagged_applicant_id');
    }
}
