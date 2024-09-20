<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Lot;

class LotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lot::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'lot_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'lot_size' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'status' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
