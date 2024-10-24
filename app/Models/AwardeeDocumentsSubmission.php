<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AwardeeDocumentsSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'awardee_id',
        'attachment_id',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    protected $casts = [
        'id' => 'integer',
        'awardee_id' => 'integer',
        'awardee_attachments_list_id' => 'integer'
    ];
    public function awardee(): BelongsTo
    {
        return $this->belongsTo(Awardee::class);
    }

    public function attachmentType(): BelongsTo
    {
        return $this->belongsTo(AwardeeAttachmentsList::class, 'awardee_attachments_list_id');
    }
}
