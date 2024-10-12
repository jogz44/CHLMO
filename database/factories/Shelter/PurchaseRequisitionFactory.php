<?php

namespace Database\Factories\Shelter;

use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseRequisitionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pr_number' => $this->faker->regexify('[A-Z0-9]{5}'),  // Generates a 5-character PR number
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
