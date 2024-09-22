<?php

namespace Database\Factories;

use App\Models\CivilStatus;
use App\Models\TransactionType;
use App\Models\Tribe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\Transaction;
use App\Models\User;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $applicantIds = Applicant::pluck('id')->toArray();
        $transactionTypeIds = TransactionType::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        return [
            'applicant_id' => fake()->randomElement($applicantIds),
            'transaction_type_id' => fake()->randomElement($transactionTypeIds),
            'user_id' => fake()->randomElement($userIds),
            'start_time' => $this->faker->dateTime(),
            'end_time' => $this->faker->dateTime(),
        ];
    }

}
