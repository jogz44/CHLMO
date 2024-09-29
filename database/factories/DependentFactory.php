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
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->optional()->firstName(), // Optional middle name
            'last_name' => $this->faker->lastName(),
            'date_of_birth' => $this->faker->dateTimeBetween('-100 years', '-18 years')->format('Y-m-d'),
            'relationship' => $this->faker->randomElement(['Parent', 'Sibling', 'Spouse', 'Child', 'Relative', 'Friend']),
            'occupation' => $this->faker->jobTitle(),
            'monthly_income' => $this->faker->numberBetween(10000, 100000), // Assuming a realistic positive income range
        ];
    }

}
