<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AwardeeAttachmentsList extends Model
{
    use HasFactory;

    protected $fillable = [
        'attachment_name'
    ];
    public function submissions(): HasMany
    {
        return $this->hasMany(AwardeeDocumentSubmission::class);
    }
}
