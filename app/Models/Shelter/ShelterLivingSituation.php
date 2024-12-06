<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShelterLivingSituation extends Model
{
    use HasFactory;

    protected $fillable = [
        'living_situation_description',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function profiledTaggedApplicants(): HasMany
    {
        return $this->hasMany(ProfiledTaggedApplicant::class);
    }
}
