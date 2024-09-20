<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CivilStatus;

class CivilStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CivilStatus::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'civil_status' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
