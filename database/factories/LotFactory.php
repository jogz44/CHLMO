<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\LotList;

class LotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LotList::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'lot_name' => $this->faker->streetName, // Generates a plausible name for a lot
            'lot_size' => $this->faker->numberBetween(100, 10000) . ' sqm', // Generates a realistic lot size in square meters
            'status' => $this->faker->randomElement([
                'Available',
                'Occupied',
                'Pending',
                'Under Construction']), // Generates a realistic lot status
        ];
    }

}
