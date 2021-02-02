<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            Post::USER_ID => User::all()->random()->id,
            Post::TITLE => $this->faker->sentence,
            Post::CONTENT => $this->faker->text(1000),
            Post::PUBLISHED_AT => $this->faker->datetime
        ];
    }
}
