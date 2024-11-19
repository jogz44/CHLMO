<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransferAttachmentsList extends Model
{
    protected $fillable = [
        'attachment_name'
    ];
    public function submissions(): HasMany
    {
        return $this->hasMany(TransferDocumentsSubmissions::class, 'attachment_id');
    }
}
