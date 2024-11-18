<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AwardeeDocumentsSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagged_applicant_id',
        'attachment_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    protected $casts = [
        'id' => 'integer',
        'tagged_applicant_id' => 'integer',
        'awardee_attachments_list_id' => 'integer'
    ];
    public function taggedAndValidatedApplicant(): BelongsTo
    {
        return $this->belongsTo(TaggedAndValidatedApplicant::class, 'tagged_applicant_id');
    }

    public function attachmentType(): BelongsTo
    {
        return $this->belongsTo(AwardeeAttachmentsList::class, 'awardee_attachments_list_id');
    }
}
