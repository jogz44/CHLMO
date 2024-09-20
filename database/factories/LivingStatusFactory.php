<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\LivingStatus;

class LivingStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LivingStatus::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'living_status_name' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
