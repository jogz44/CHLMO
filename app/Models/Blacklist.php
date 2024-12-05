<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blacklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'awardee_id',
        'user_id',
        'date_blacklisted',
        'blacklist_reason_description',
        'updated_by',
    ];

    protected $casts = [
        'id' => 'integer',
        'awardee_id' => 'integer',
        'user_id' => 'integer',
        'date_blacklisted' => 'datetime',
    ];

    public function awardee(): BelongsTo
    {
        return $this->belongsTo(Awardee::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
