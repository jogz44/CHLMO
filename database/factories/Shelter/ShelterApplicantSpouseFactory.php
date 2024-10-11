<?php

namespace Database\Factories\Shelter;

use App\Models\Shelter\ShelterApplicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShelterApplicantSpouseFactory extends Factory
{
    public function definition()
    {
        static $shelterApplicantIds;

        if (!$shelterApplicantIds) {
            $shelterApplicantIds = ShelterApplicant::pluck('id')->shuffle()->toArray();
        }

        return [
            'shelter_applicant_id' => $this->faker->randomElement($shelterApplicantIds),
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->firstName,
            'last_name' => $this->faker->lastName,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
