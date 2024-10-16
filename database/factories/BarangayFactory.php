<?php

namespace Database\Factories;

use App\Models\Barangay;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BarangayFactory extends Factory
{
    protected $model = Barangay::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'city_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
