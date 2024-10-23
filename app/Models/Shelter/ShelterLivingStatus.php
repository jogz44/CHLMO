<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShelterLivingStatus extends Model
{
    use HasFactory;

    protected $table = 'shelter_living_statuses';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shelter_living_status_name',
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function profiledTaggedApplicant(): HasMany
    {
        return $this->hasMany(ProfiledTaggedApplicant::class);
    }
}
