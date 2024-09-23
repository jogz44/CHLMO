<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\WallType;

class WallTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WallType::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
//            'wall_type_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
