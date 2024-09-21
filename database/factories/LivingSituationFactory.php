<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\LivingSituation;

class LivingSituationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LivingSituation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
//            'living_situation_description' => $this->faker->text(),
        ];
    }
}
