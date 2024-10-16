<?php

namespace Database\Factories\Shelter;

use App\Models\Address;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\Religion;
use App\Models\Shelter\ShelterApplicant;
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
        static $livingSituationIds;
        static $caseSpecificationIds;

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

        if (!$livingSituationIds) {
            $livingSituationIds = LivingSituation::pluck('id')->shuffle()->toArray();
        }

        if (!$caseSpecificationIds) {
            $caseSpecificationIds = CaseSpecification::pluck('id')->shuffle()->toArray();
        }

        return [
            'shelter_applicant_id' => $this->faker->randomElement($shelterApplicantIds),
            'civil_status_id' => $this->faker->randomElement($civilStatusIds),
            'religion_id' => $this->faker->randomElement($religionIds),
            'address_id' => $this->faker->randomElement($addressIds),
            'government_program_id' => $this->faker->randomElement($governmentProgramIds),
            'tribe_id' => $this->faker->randomElement($tribeIds),
            'living_situation_id' => $this->faker->randomElement($livingSituationIds),
            'case_specification_id' => $this->faker->optional()->randomElement($caseSpecificationIds),
            'living_situation_case_specification' => $this->faker->optional()->sentence,
            'date_of_birth' => $this->faker->date(),
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'occupation' => $this->faker->jobTitle,
            'year_of_residency' => $this->faker->numberBetween(1, 50),
            'contact_number' => $this->faker->phoneNumber,
            'house_no_or_street_name' => $this->faker->optional()->streetAddress,
            'date_tagged' => $this->faker->dateTime(),
            'remarks' => $this->faker->optional()->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
