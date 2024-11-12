<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AwardeeTransferHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'previous_awardee_id',
//        'new_awardee_id',
        'transfer_date',
        'transfer_reason',
        'relationship',
        'processed_by',
        'remarks'
    ];

    protected $casts = [
        'transfer_date' => 'datetime',
        'previous_awardee_id' => 'integer',
//        'new_awardee_id' => 'integer',
        'processed_by' => 'integer'
    ];

    public function previousAwardee(): BelongsTo
    {
        return $this->belongsTo(Awardee::class, 'previous_awardee_id');
    }
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
    public function scopeFromDate($query, $date)
    {
        return $query->where('transfer_date', '>=', $date);
    }
    public function scopeToDate($query, $date)
    {
        return $query->where('transfer_date', '<=', $date);
    }
}
