<?php

namespace Database\Factories;

use App\Models\Dependent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\TransferredAwardee;

class TransferredAwardeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TransferredAwardee::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        static $applicantIds; // Use static to persist the array across multiple calls
        if (!$applicantIds) {
            $applicantIds = Applicant::pluck('id')->shuffle()->toArray(); // Shuffle and convert to array
        }

        static $dependentIds; // Use static to persist the array across multiple calls
        if (!$dependentIds) {
            $dependentIds = Dependent::pluck('id')->shuffle()->toArray(); // Shuffle and convert to array
        }

        return [
            'applicant_id' => array_pop($applicantIds),
            'dependent_id' => array_pop($dependentIds),
            'death_certificate_photo' => $this->faker->imageUrl(640, 480, 'documents', true, 'death_certificate'),
            'voters_id_photo' => $this->faker->imageUrl(640, 480, 'documents', true, 'voters_id'),
            'valid_id_photo' => $this->faker->imageUrl(640, 480, 'documents', true, 'valid_id'),
            'marriage_certificate_photo' => $this->faker->imageUrl(640, 480, 'documents', true, 'marriage_certificate'),
            'birth_certificate_photo' => $this->faker->imageUrl(640, 480, 'documents', true, 'birth_certificate'),
            'certificate_of_no_land_holding_photo' => $this->faker->imageUrl(640, 480, 'documents', true, 'certificate_no_land'),
        ];
    }

}
