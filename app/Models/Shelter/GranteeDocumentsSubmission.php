<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GranteeDocumentsSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'grantee_id',
        'attachment_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    protected $casts = [
        'id' => 'integer',
        'grantee_id' => 'integer',
        'grantee_attachments_list_id' => 'integer'
    ];

    public function grantee(): BelongsTo
    {
        return $this->belongsTo(Grantee::class);
    }

    public function attachmentType(): BelongsTo
    {
        return $this->belongsTo(GranteeAttachmentList::class, 'grantee_attachment_list_id');
    }

}
