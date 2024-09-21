<?php

namespace Database\Factories;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\Blacklist;

class BlacklistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blacklist::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        static $applicantIds; // Use static to persist the array across multiple calls
        if (!$applicantIds) {
            $applicantIds = Applicant::pluck('id')->shuffle()->toArray(); // Fetch and shuffle the user IDs once
        }

        $userIds = User::pluck('id')->toArray();

        return [
            'applicant_id' => array_pop($applicantIds),
            'user_id' => fake()->randomElement($userIds),
            'date_blacklisted' => $this->faker->dateTimeBetween('-1 year', 'now'), // Date within the past year
            'blacklist_reason_description' => $this->faker->sentence(10), // A brief reason for blacklisting
            'updated_by' => $this->faker->name(), // Realistic name for the user who updated the record
        ];

    }
}
