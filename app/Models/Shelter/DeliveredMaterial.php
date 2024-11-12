<?php

namespace App\Models\Shelter;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\Material;


class DeliveredMaterial extends Model
{
    protected $fillable = [
        'grantee_id',
        'material_id',
        'grantee_quantity',
    ];

    protected $casts = [
        'id' => 'integer',
        'grantee_id' => 'integer',
        'material_id' => 'integer',
    ];

    public function grantee()
    {
        return $this->belongsTo(Grantee::class, 'grantee_id', 'id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }

    // In Material model
    public function unit()
    {
        return $this->belongsTo(MaterialUnit::class, 'material_unit_id');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }
}
