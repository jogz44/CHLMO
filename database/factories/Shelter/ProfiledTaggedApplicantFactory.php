<?php

namespace Database\Factories\Shelter;

use App\Models\Address;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\GovernmentProgram;
use App\Models\Shelter\ShelterLivingStatus;
use App\Models\LivingSituation;
use App\Models\Religion;
use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\ShelterApplicantSpouse;
use App\Models\Tribe;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfiledTaggedApplicantFactory extends Factory
{
    public function definition()
    {
        static $shelterApplicantIds;
        static $civilStatusIds;
        static $religionIds;
        static $addressIds;
        static $governmentProgramIds;
        static $tribeIds;
        static $shelterlivingStatusIds;
        static $caseSpecificationIds;
        static $shelterSpouseIds;

        if (!$shelterApplicantIds) {
            $shelterApplicantIds = ShelterApplicant::pluck('id')->shuffle()->toArray();
        }

        if (!$civilStatusIds) {
            $civilStatusIds = CivilStatus::pluck('id')->shuffle()->toArray();
        }

        if (!$religionIds) {
            $religionIds = Religion::pluck('id')->shuffle()->toArray();
        }

        if (!$addressIds) {
            $addressIds = Address::pluck('id')->shuffle()->toArray();
        }

        if (!$governmentProgramIds) {
            $governmentProgramIds = GovernmentProgram::pluck('id')->shuffle()->toArray();
        }

        if (!$tribeIds) {
            $tribeIds = Tribe::pluck('id')->shuffle()->toArray();
        }

        if (!$shelterlivingStatusIds) {
            $shelterlivingStatusIds = ShelterlivingStatus::pluck('id')->shuffle()->toArray();
        }

        if (!$caseSpecificationIds) {
            $caseSpecificationIds = CaseSpecification::pluck('id')->shuffle()->toArray();
        }

        return [
            'profile_no' => $this->faker->randomElement($shelterApplicantIds),
            'civil_status_id' => $this->faker->randomElement($civilStatusIds),
            'religion_id' => $this->faker->randomElement($religionIds),
            'address_id' => $this->faker->randomElement($addressIds),
            'government_program_id' => $this->faker->randomElement($governmentProgramIds),
            'tribe_id' => $this->faker->randomElement($tribeIds),
            'shelter_living_status_id' => $this->faker->randomElement($shelterlivingStatusIds),
            'case_specification_id' => $this->faker->optional()->randomElement($caseSpecificationIds),
            'living_situation_case_specification' => $this->faker->optional()->sentence,
            'age' => $this->faker->numberBetween(1, 100),
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'occupation' => $this->faker->jobTitle,
            'year_of_residency' => $this->faker->numberBetween(1, 50),
            'contact_number' => $this->faker->phoneNumber,
            'date_tagged' => $this->faker->dateTime(),
            'remarks' => $this->faker->optional()->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
