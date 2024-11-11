<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Shelter\ProfiledTaggedApplicant;

class CaseSpecification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'case_specification_name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function taggedAndValidatedApplicants()
    {
        return $this->hasMany(TaggedAndValidatedApplicant::class);
    }
    public function profiledTaggedApplicants()
    {
        return $this->hasMany(ProfiledTaggedApplicant::class);
    }
}
