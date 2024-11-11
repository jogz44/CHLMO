<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Shelter\ProfiledTaggedApplicant;

class LivingSituation extends Model
{
    use HasFactory;

    protected $fillable = [
        'living_situation_description',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function taggedAndValidatedApplicants(): HasMany
    {
        return $this->hasMany(TaggedAndValidatedApplicant::class);
    }
    public function profiledTaggedApplicants(): HasMany
    {
        return $this->hasMany(ProfiledTaggedApplicant::class);
    }
}
