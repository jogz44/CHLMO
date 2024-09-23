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
        $userIds = User::pluck('id')->toArray();
        $transactionTypeIds = TransactionType::pluck('id')->toArray();
        $civilStatusIds = CivilStatus::pluck('id')->toArray();
        $tribeIds = Tribe::pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement($userIds),
            'transaction_type_id' => fake()->randomElement($transactionTypeIds),
            'civil_status_id' => fake()->randomElement($civilStatusIds),
            'tribe_id' => fake()->randomElement($tribeIds),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->optional()->firstName(), // Optional middle name
            'last_name' => $this->faker->lastName(),
            'age' => $this->faker->numberBetween(18, 100), // Reasonable age range
            'phone' => $this->faker->phoneNumber(),
            'sex' => $this->faker->randomElement(['male', 'female']), // More realistic gender options
            'occupation' => $this->faker->jobTitle(), // Generates a random job title
            'income' => $this->faker->numberBetween(20000, 200000), // Reasonable income range
            'date_applied' => $this->faker->dateTimeBetween('-1 years', 'now'), // Date within the last year
            'initially_interviewed_by' => $this->faker->name(), // Realistic name for the interviewer
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']), // Fixed status options
            'tagger_name' => $this->faker->name(), // Realistic name for tagger
            'tagging_date' => $this->faker->dateTimeBetween('-1 months', 'now'), // Recent tagging date
            'awarded_by' => $this->faker->name(), // Realistic name for who awarded
            'awarding_date' => $this->faker->dateTimeBetween('now', '+1 year'), // Future awarding date
            'photo' => $this->faker->imageUrl(640, 480, 'people'), // Realistic image URL for a photo
        ];
    }

}
