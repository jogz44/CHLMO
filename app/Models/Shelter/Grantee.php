<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Address;
use App\Models\Barangay;
use App\Models\Purok;

class Grantee extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profiled_tagged_applicant_id',
        'material_id',
        'grantee_quantity',
        'date_of_delivery',
        'date_of_ris',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'profiled_tagged_applicant_id' => 'integer',
        'material_id' => 'integer',
        'date_of_delivery' => 'date',
        'date_of_ris' => 'date',
    ];

    public function profiledTaggedApplicant(): BelongsTo
    {
        return $this->belongsTo(ProfiledTaggedApplicant::class, 'profiled_tagged_applicant_id', 'id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    public function shelterApplicant()
    {
        return $this->belongsTo(ShelterApplicant::class, 'profile_no', 'id');
    }

    public function originOfRequest(): BelongsTo
    {
        return $this->belongsTo(OriginOfRequest::class, 'request_origin_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(GranteeAttachmentList::class, 'grantee_id'); // Assuming there's a `grantee_id` in the attachment table
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function purok()
    {
        return $this->belongsTo(Purok::class, 'purok_id');
    }
    public function photo()
    {
        return $this->hasMany(ShelterUploadedFiles::class);
    }
}
