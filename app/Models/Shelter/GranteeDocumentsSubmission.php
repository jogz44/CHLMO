<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GranteeDocumentsSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'profiled_tagged_applicant_id',
        'document_name',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
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
