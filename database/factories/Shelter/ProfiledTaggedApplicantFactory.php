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
        static $addressIds;
        static $governmentProgramIds;
        static $livingSituationIds;
        static $caseSpecificationIds;

        if (!$shelterApplicantIds) {
            $shelterApplicantIds = ShelterApplicant::pluck('id')->shuffle()->toArray();
        }

        if (!$civilStatusIds) {
            $civilStatusIds = CivilStatus::pluck('id')->shuffle()->toArray();
        }

        if (!$addressIds) {
            $addressIds = Address::pluck('id')->shuffle()->toArray();
        }

        if (!$governmentProgramIds) {
            $governmentProgramIds = GovernmentProgram::pluck('id')->shuffle()->toArray();
        }

        if (!$livingSituationIds) {
            $livingSituationIds = LivingSituation::pluck('id')->shuffle()->toArray();
        }

        if (!$caseSpecificationIds) {
            $caseSpecificationIds = CaseSpecification::pluck('id')->shuffle()->toArray();
        }

        return [
            'profile_no' => $this->faker->randomElement($shelterApplicantIds),
            'civil_status_id' => $this->faker->randomElement($civilStatusIds),
            'address_id' => $this->faker->randomElement($addressIds),
            'government_program_id' => $this->faker->randomElement($governmentProgramIds),
            'living_situation_id' => $this->faker->randomElement($livingSituationIds),
            'case_specification_id' => $this->faker->optional()->randomElement($caseSpecificationIds),
            'living_situation_case_specification' => $this->faker->optional()->sentence,
            'tribe' => $this->faker->word,
            'religion' => $this->faker->word,
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
