<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DependentsRelationship extends Model
{
    use HasFactory;

    protected $fillable = [
        'relationship'
    ];

    protected $casts = [
        'id' => 'integer'
    ];
    public function dependents(): HasMany
    {
        return $this->hasMany(Dependent::class);
    }
}
