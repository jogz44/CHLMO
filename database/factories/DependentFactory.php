<?php

namespace Database\Factories;

use App\Models\Occupation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\Dependent;

class DependentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dependent::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'applicant_id' => Applicant::factory(),
            'occupation_id' => Occupation::factory(),
            'relationship' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'income' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
