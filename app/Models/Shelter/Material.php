<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'purchase_order_id',
        'material_unit_id',
        'item_description',
        'quantity',
        'available_quantity'
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'purchase_order_id' => 'integer',
        'purchase_order_id' => 'integer'
    ];

    protected static function booted()
    {
        // Automatically set available_quantity to the same as quantity before saving
        static::creating(function ($material) {
            if (is_null($material->available_quantity)) {
                $material->available_quantity = $material->quantity;
            }
        });
    }
    
    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }
    
    public function materialUnit(): BelongsTo
    {
        return $this->belongsTo(MaterialUnit::class, 'material_unit_id', 'id');
    }

    public function grantees(): HasMany
    {
        return $this->hasMany(Grantee::class, 'material_id');
    }
}
