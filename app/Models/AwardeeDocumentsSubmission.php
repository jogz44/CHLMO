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
        'document_name',
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
        return $this->belongsTo(Awardee::class, 'awardee_id');
    }
}
