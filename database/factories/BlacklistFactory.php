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
        return [
            'applicant_id' => Applicant::factory(),
            'user_id' => User::factory(),
            'date_blacklisted' => $this->faker->dateTime(),
            'blacklist_reason_description' => $this->faker->text(),
            'updated_by' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
