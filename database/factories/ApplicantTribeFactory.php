<?php

namespace Database\Factories;

use App\Models\Tribe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\ApplicantTribe;

class ApplicantTribeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ApplicantTribe::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'applicant_id' => Applicant::factory(),
            'tribe_id' => Tribe::factory(),
        ];
    }
}
