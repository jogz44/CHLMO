<?php

namespace Database\Factories\Shelter;

use App\Models\Shelter\OriginOfRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShelterApplicantFactory extends Factory
{
    public function definition()
    {
        static $userIds;
        static $originOfRequestIds;

        if (!$userIds) {
            $userIds = User::pluck('id')->shuffle()->toArray();
        }

        if (!$originOfRequestIds) {
            $originOfRequestIds = OriginOfRequest::pluck('id')->shuffle()->toArray();
        }

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'request_origin_id' => $this->faker->randomElement($originOfRequestIds),
            'profile_no' => $this->faker->unique()->regexify('[A-Z0-9]{6}'),
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->firstName,
            'last_name' => $this->faker->lastName,
            'date_request' => $this->faker->date(),
            'is_tagged' => $this->faker->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
