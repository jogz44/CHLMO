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
        return [
            'applicant_id' => Applicant::factory(),
            'lot_size_allocated' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'letter_of_intent_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'voters_id_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'valid_id_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'certificate_of_no_land_holding_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'marriage_certificate_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'birth_certificate_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
