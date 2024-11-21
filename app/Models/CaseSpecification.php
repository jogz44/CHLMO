<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shelter\ProfiledTaggedApplicant;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CaseSpecification extends Model
{
    use HasFactory;
    protected $table = 'case_specifications';

    protected $fillable = [
        'case_specification_name',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function taggedAndValidatedApplicants(): HasMany
    {
        return $this->hasMany(TaggedAndValidatedApplicant::class);
    }
    public function profiledTaggedApplicants()
    {
        return $this->hasMany(ProfiledTaggedApplicant::class);
    }
}
