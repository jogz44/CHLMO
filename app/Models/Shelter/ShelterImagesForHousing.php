<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ShelterImagesForHousing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profiled_tagged_applicant_id',
        'image_path',
        'display_name',
        'order',
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'profiled_tagged_applicant_id' => 'integer',
        'order' => 'integer',
    ];
    public function profiledTaggedApplicant(): BelongsTo
    {
        return $this->belongsTo(ProfiledTaggedApplicant::class);
    }
}
