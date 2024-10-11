<?php

namespace Database\Factories\Shelter;

use App\Models\Shelter\Material;
use App\Models\Shelter\ProfiledTaggedApplicant;
use Illuminate\Database\Eloquent\Factories\Factory;

class GranteeFactory extends Factory
{
    public function definition()
    {
        static $profiledTaggedApplicantIds;
        static $materialIds;

        if (!$profiledTaggedApplicantIds) {
            $profiledTaggedApplicantIds = ProfiledTaggedApplicant::pluck('id')->shuffle()->toArray();
        }

        if (!$materialIds) {
            $materialIds = Material::pluck('id')->shuffle()->toArray();
        }

        return [
            'profiled_tagged_applicant_id' => $this->faker->randomElement($profiledTaggedApplicantIds),
            'material_id' => $this->faker->randomElement($materialIds),
            'date_of_delivery' => $this->faker->dateTime(),
            'date_of_ris' => $this->faker->dateTime(),
            'photo' => $this->faker->optional()->imageUrl(640, 480, 'people'),  // Generates a random image URL
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
