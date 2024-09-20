<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Religion;

class ReligionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Religion::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'religion_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
