<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\;
use App\Models\Applicant;
use App\Models\Spouse;

class SpouseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Spouse::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'applicant_id' => Applicant::factory(),
            'occupation_id' => ::factory(),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'last_name' => $this->faker->lastName(),
            'income' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
