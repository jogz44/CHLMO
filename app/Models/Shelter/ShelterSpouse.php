<?php
namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Shelter\ProfiledTaggedApplicant;

class ShelterSpouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'profiled_tagged_applicant_id',
        'spouse_first_name',
        'spouse_middle_name',
        'spouse_last_name',
    ];

    protected $casts = [
        'id' => 'integer',
        'profiled_tagged_applicant_id' => 'integer',
    ];

    public function profiledTaggedApplicant(): BelongsTo
    {
        return $this->belongsTo(ProfiledTaggedApplicant::class, 'profiled_tagged_applicant_id');
    }
}
