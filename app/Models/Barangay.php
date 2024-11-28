<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barangay extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'id' => 'integer',    // Casts id as an integer
    ];

    public function puroks(): HasMany
    {
        return $this->hasMany(Purok::class);
    }
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
    public function lots(): HasMany
    {
        return $this->hasMany(LotList::class);
    }
}
