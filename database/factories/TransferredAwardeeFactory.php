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
        return [
            'applicant_id' => Applicant::factory(),
            'dependent_id' => Dependent::factory(),
            'death_certificate_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'voters_id_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'valid_id_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'marriage_certificate_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'birth_certificate_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'certificate_of_no_land_holding_photo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
