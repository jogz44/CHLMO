<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        return $this->belongsTo(ProfiledTaggedApplicant::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(GranteeAttachmentList::class, 'grantee_id'); // Assuming there's a `grantee_id` in the attachment table
    }
    public function photo()
    {
        return $this->hasMany(ShelterUploadedFiles::class);
    }
}
