<?php

namespace Database\Factories;

use Database\Seeders\CaseSpecificationSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CaseSpecification;

class CaseSpecificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaseSpecification::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
//        return [
//            'case_specification_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
//        ];
        CaseSpecificationSeeder::class;
    }
}
