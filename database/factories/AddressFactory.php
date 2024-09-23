<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
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
        return [
            'applicant_id' => Applicant::factory(),
            'city_id' => City::factory(),
            'state_id' => State::factory(),
            'country_id' => Country::factory(),
            'street_address' => $this->faker->streetAddress(), // More realistic street address
            'city' => $this->faker->city(), // Generates a random city name
            'state_name' => $this->faker->state(), // Generates a random state name
            'postal_code' => $this->faker->postcode(), // Generates a random postal code
            'country' => $this->faker->country(), // Generates a random country name
            'latitude' => $this->faker->latitude(), // Generates a random latitude
            'longitude' => $this->faker->longitude(), // Generates a random longitude
            'full_address' => $this->faker->address(), // Generates a complete address
        ];
    }

}
