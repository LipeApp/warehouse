<?php

namespace Database\Factories;

use App\Models\Warehouse;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Warehouse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reminder' => $this->faker->randomNumber(2),
            'material_id' => \App\Models\Material::factory(),
        ];
    }
}
