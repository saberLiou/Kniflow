<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * Test CategoryController@show.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class ShowTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * The specified Category instance.
     *
     * @var Category
     */
    protected $category;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);

        $this->category = User::first()->categories()->create([
            Category::NAME => config('scribe.example_values.name'),
            Category::SORT => 1,
        ])->refresh();

        $this->url = route('categories.show', [
            'category' => $this->category->slug,
        ]);
    }

    public function testWhenCategoryDisplayed()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $expected = [
            'data' => format_resource_object($this->category->id, Category::TABLE, [
                Category::SLUG => $this->category->slug,
                Category::NAME => $this->category->name,
                Category::SORT => $this->category->sort,
            ], [
                Category::USER => [
                    'data' => [
                        User::ID => $this->category->user_id,
                    ],
                ],
            ]),
        ];

        // WHEN
        $response = $this->get($this->url, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenCategoryNotFound()
    {
        // GIVEN
        $this->url = route('categories.show', [
            'category' => strtolower($this->faker->word),
        ]);

        $expected = $this->errorMessage(Response::HTTP_NOT_FOUND);

        // WHEN
        $response = $this->get($this->url, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
