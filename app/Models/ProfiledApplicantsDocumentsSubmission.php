<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Shelter\ProfiledTaggedApplicant;

class ProfiledApplicantsDocumentsSubmission extends Model
{
    protected $fillable = [
        'profiled_tagged_applicant_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size'
    ];

    protected $casts = [
        'id' => 'integer'
    ];

    public function profiledTaggedApplicant(): BelongsTo
    {
        return $this->belongsTo(ProfiledTaggedApplicant::class, 'profiled_tagged_applicant_id');
    }
}
