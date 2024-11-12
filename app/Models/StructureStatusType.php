<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StructureStatusType extends Model
{
    use HasFactory;

    protected $fillable = [
        'structure_status'
    ];

    protected $casts = [
        'id' => 'integer'
    ];

    public function taggedAndValidatedApplicants()
    {
        return $this->hasMany(TaggedAndValidatedApplicant::class);
    }
}
