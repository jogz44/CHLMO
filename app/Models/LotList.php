<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LotList extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'barangay_id',
        'lot_name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'barangay_id' => 'integer',
    ];


    public function awardees(): HasMany
    {
        return $this->hasMany(Awardee::class, 'lot_id', 'id');
    }
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }

}
