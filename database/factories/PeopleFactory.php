<?php

namespace Database\Factories;

use App\Models\People;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeopleFactory extends Factory
{
    protected $model = People::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->firstName, // Optional, use null sometimes if not always present
            'last_name' => $this->faker->lastName,
            'suffix_name' => $this->faker->randomElement(['Jr.', 'Sr.', 'III', null]), // Includes null for optional field
            'contact_number' => $this->faker->numerify('09#########'), // Simulates a Philippine mobile number
            'application_type' => $this->faker->randomElement(['Housing Applicant', 'Shelter Applicant']), // Example types
        ];
    }
}
