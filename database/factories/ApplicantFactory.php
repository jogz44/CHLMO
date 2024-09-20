<?php

namespace Database\Factories;

use App\Models\CivilStatus;
use App\Models\Spouse;
use App\Models\TransactionType;
use App\Models\Tribe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\User;

class ApplicantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Applicant::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'transaction_type_id' => TransactionType::factory(),
            'civil_status_id' => CivilStatus::factory(),
            'tribe_id' => Tribe::factory(),
            'spouse_id' => Spouse::factory(),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'last_name' => $this->faker->lastName(),
            'age' => $this->faker->numberBetween(-10000, 10000),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'occupation' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'income' => $this->faker->numberBetween(-10000, 10000),
            'date_applied' => $this->faker->dateTime(),
            'initially_interviewed_by' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'status' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'tagger_name' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'tagging_date' => $this->faker->dateTime(),
            'awarded_by' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'awarding_date' => $this->faker->dateTime(),
            'photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
