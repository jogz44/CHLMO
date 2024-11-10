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
    /**
     * Get the previous awardee associated with the transfer.
     */
    public function previousAwardee(): BelongsTo
    {
        return $this->belongsTo(Awardee::class, 'previous_awardee_id');
    }
    /**
     * Get the new awardee associated with the transfer.
     */
//    public function newAwardee(): BelongsTo
//    {
//        return $this->belongsTo(Awardee::class, 'new_awardee_id');
//    }
    /**
     * Get the user who processed the transfer.
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
    /**
     * Scope a query to only include transfers from a specific date onwards.
     */
    public function scopeFromDate($query, $date)
    {
        return $query->where('transfer_date', '>=', $date);
    }
    /**
     * Scope a query to only include transfers up to a specific date.
     */
    public function scopeToDate($query, $date)
    {
        return $query->where('transfer_date', '<=', $date);
    }
}
