<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaggedDocumentsSubmission extends Model
{
    protected $fillable = [
        'tagged_applicant_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size'
    ];

    protected $casts = [
        'id' => 'integer'
    ];

    public function taggedAndValidatedApplicant(): BelongsTo
    {
        return $this->belongsTo(TaggedAndValidatedApplicant::class, 'tagged_applicant_id');
    }
}
