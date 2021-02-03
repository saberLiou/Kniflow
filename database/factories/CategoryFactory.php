<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            Category::USER_ID => User::all()->random()->id,
            Category::NAME => $this->faker->sentence,
            Category::SORT => $this->faker->numberBetween(1, 6),
        ];
    }
}
