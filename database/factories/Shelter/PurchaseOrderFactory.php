<?php

namespace Database\Factories\Shelter;

use App\Models\Shelter\PurchaseRequisition;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderFactory extends Factory
{
    public function definition()
    {
        static $purchaseRequisitionIds;

        if (!$purchaseRequisitionIds) {
            $purchaseRequisitionIds = PurchaseRequisition::pluck('id')->shuffle()->toArray();
        }

        return [
            'purchase_requisition_id' => $this->faker->randomElement($purchaseRequisitionIds),
            'po_number' => $this->faker->regexify('[A-Z0-9]{5}'),  // Generates a 5-character PO number
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
