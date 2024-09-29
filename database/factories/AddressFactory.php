<?php

namespace Database\Factories;

use App\Models\Barangay;
use App\Models\City;
use App\Models\Country;
use App\Models\Purok;
use App\Models\State;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Applicant;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        static $purokIds; // Use static to persist the array across multiple calls
        if (!$purokIds) {
            $purokIds = Purok::pluck('id')->shuffle()->toArray(); // Fetch and shuffle the user IDs once
        }

        static $barangayIds;
        if (!$barangayIds) {
            $barangayIds = Barangay::pluck('id')->shuffle()->toArray();
        }

        return [
            'purok_id' => fake()->randomElement($purokIds),
            'barangay_id' => fake()->randomElement($barangayIds),
            'street' => $this->faker->streetAddress(),
            'house_number' => $this->faker->buildingNumber(),
        ];
    }

}
