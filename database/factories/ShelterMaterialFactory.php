<?php

namespace Database\Factories;

use App\Models\RoofType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ShelterMaterial;
use App\Models\WallType;

class ShelterMaterialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShelterMaterial::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'wall_type_id' => WallType::factory(),
            'roof_type_id' => RoofType::factory(),
            'other_materials' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
