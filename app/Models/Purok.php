<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purok extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barangay_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'barangay_id' => 'integer',
    ];

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
