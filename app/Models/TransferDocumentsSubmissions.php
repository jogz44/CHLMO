<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferDocumentsSubmissions extends Model
{
    protected $fillable = [
        'awardee_id',
        'attachment_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    protected $casts = [
        'id' => 'integer',
        'awardee_id' => 'integer',
    ];
    public function awardee(): BelongsTo
    {
        return $this->belongsTo(Awardee::class, 'awardee_id', 'id');
    }

    public function attachmentType(): BelongsTo
    {
        return $this->belongsTo(TransferAttachmentsList::class, 'attachment_id');
    }
}
