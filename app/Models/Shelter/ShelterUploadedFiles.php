<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShelterUploadedFiles extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grantee_id',
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
        'grantee_id' => 'integer',
        'order' => 'integer',
    ];
    public function grantee(): BelongsTo
    {
        return $this->belongsTo(Grantee::class);
    }
}
