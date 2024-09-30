<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Barangay;
use App\Models\CivilStatus;
use App\Models\Purok;
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

        static $addressIds; // Use static to persist the array across multiple calls
        if (!$addressIds) {
            $addressIds = Address::pluck('id')->shuffle()->toArray(); // Fetch and shuffle the user IDs once
        }

        return [
            'user_id' => fake()->randomElement($userIds),
            'transaction_type_id' => fake()->randomElement($transactionTypeIds),
            'address_id' => fake()->randomElement($addressIds),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->optional()->firstName(), // Optional middle name
            'last_name' => $this->faker->lastName(),
            'suffix_name' => fake()->optional()->suffix(),
            'phone' => $this->faker->phoneNumber(),
            'date_applied' => $this->faker->date(),
            'initially_interviewed_by' => $this->faker->name(), // Realistic name for the interviewer
        ];
    }

}
