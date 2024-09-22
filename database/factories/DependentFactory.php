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
        $applicantIds = Applicant::pluck('id')->toArray();

        return [
            'applicant_id' => fake()->randomElement($applicantIds),
            'occupation' => $this->faker->jobTitle(),
            'relationship' => $this->faker->randomElement(['Parent', 'Sibling', 'Spouse', 'Child', 'Relative', 'Friend']),
            'income' => $this->faker->numberBetween(10000, 100000), // Assuming a realistic positive income range
        ];
    }

}
