<?php

namespace Database\Factories\Shelter;

use Illuminate\Database\Eloquent\Factories\Factory;

class OriginOfRequestFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
