<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LotSizeUnit extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lot_size_unit_name',
        'lot_size_unit_short_name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    // Relationship: One LotSizeUnit has many LotLists
    public function awardees(): HasMany
    {
        return $this->hasMany(Awardee::class, 'lot_size_unit_id', 'id');
    }
}
