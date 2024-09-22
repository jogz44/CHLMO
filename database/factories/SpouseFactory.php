<?php

namespace Database\Factories;

use App\Models\Occupation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
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
        static $applicantIds; // Use static to persist the array across multiple calls
        if (!$applicantIds) {
            $applicantIds = Applicant::pluck('id')->shuffle()->toArray(); // Fetch and shuffle the user IDs once
        }

        return [
            'applicant_id' => array_pop($applicantIds),
            'occupation' => $this->faker->jobTitle(), // Generates a random job title
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->optional()->firstName(), // Use an optional middle name, which may be null
            'last_name' => $this->faker->lastName(),
            'income' => $this->faker->numberBetween(0, 100000), // Generates a realistic positive income
        ];

    }
}
