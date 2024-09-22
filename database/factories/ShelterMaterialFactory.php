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
        $wallTypeIds = WallType::pluck('id')->toArray();
        $roofTypeIds = RoofType::pluck('id')->toArray();

        return [
            'wall_type_id' => fake()->randomElement($wallTypeIds),
            'roof_type_id' => fake()->randomElement($roofTypeIds),
            'other_materials' => $this->faker->randomElement([
                'Bricks',
                'Concrete',
                'Steel',
                'Wood',
                'Glass',
                'Stone',
                'Aluminum',
                'Vinyl',
                'Stucco',
                'Fiber Cement'
            ]),
        ];
    }
}
