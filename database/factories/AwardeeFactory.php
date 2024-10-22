<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\Awardee;

class AwardeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Awardee::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        static $applicantIds; // Use static to persist the array across multiple calls
        if (!$applicantIds) {
            $applicantIds = Applicant::pluck('id')->shuffle()->toArray(); // Fetch and shuffle the user IDs once
        }

        return [
            'applicant_id' => array_pop($applicantIds),
            'lot_size_allocated' => $this->faker->numberBetween(100, 10000), // LotList size as a numeric value
            'letter_of_intent_photo' => $this->faker->imageUrl(640, 480, 'business', true, 'Letter of Intent'), // Realistic photo URL
            'voters_id_photo' => $this->faker->imageUrl(640, 480, 'identity', true, 'Voter ID'), // Realistic photo URL
            'valid_id_photo' => $this->faker->imageUrl(640, 480, 'identity', true, 'Valid ID'), // Realistic photo URL
            'certificate_of_no_land_holding_photo' => $this->faker->imageUrl(640, 480, 'business', true, 'No Land Holding Certificate'), // Realistic photo URL
            'marriage_certificate_photo' => $this->faker->imageUrl(640, 480, 'family', true, 'Marriage Certificate'), // Realistic photo URL
            'birth_certificate_photo' => $this->faker->imageUrl(640, 480, 'family', true, 'Birth Certificate'), // Realistic photo URL
        ];

    }
}
