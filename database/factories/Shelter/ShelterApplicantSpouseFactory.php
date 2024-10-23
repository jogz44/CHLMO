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
            'profile_no' => $this->faker->randomElement($shelterApplicantIds),
            'shelter_spouse_first_name' => $this->faker->firstName,
            'shelter_spouse_middle_name' => $this->faker->optional()->firstName,
            'shelter_spouse_last_name' => $this->faker->lastName,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
