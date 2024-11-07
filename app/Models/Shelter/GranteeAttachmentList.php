<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GranteeAttachmentList extends Model
{
    use HasFactory;

    protected $fillable = [
        'attachment_name'
    ];

    public function submissions(): HasMany
    {
        return $this->hasMany(GranteeDocumentsSubmission::class);
    }

    // public function grantee()
    // {
    //     return $this->belongsTo(Grantee::class, 'grantee_id');
    // }
}
