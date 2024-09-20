<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShelterMaterial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wall_type_id',
        'roof_type_id',
        'other_materials',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'wall_type_id' => 'integer',
        'roof_type_id' => 'integer',
    ];

    public function wallType(): BelongsTo
    {
        return $this->belongsTo(WallType::class);
    }

    public function roofType(): BelongsTo
    {
        return $this->belongsTo(RoofType::class);
    }
}
