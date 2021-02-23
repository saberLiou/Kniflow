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
 * Test CategoryController@index.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->url = route('categories.index');

        $this->seed(UserSeeder::class);
    }

    public function testWhenCategoriesDisplayed()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $category = Category::factory()->create([
            Category::USER_ID => User::first()->id,
            Category::NAME => config('scribe.example_values.name'),
            Category::SORT => 1,
        ])->refresh();

        $expected = [
            'data' => [
                format_resource_object($category->id, Category::TABLE, [
                    Category::SLUG => $category->slug,
                    Category::NAME => $category->name,
                    Category::SORT => $category->sort,
                ], [
                    Category::USER => [
                        'data' => [
                            User::ID => $category->user_id,
                        ],
                    ],
                ]),
            ],
        ];

        // WHEN
        $response = $this->get($this->url, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
