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
 * Test CategoryController@destroy.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class DestroyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * The specified Category instance.
     *
     * @var Category
     */
    protected $category;

    /**
     * The instance of the user who created the specified category.
     *
     * @var User
     */
    protected $author;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UserSeeder::class);
        $this->author = User::first();

        $this->category = $this->author->categories()->create([
            Category::NAME => config('scribe.example_values.name'),
            Category::SORT => 1,
        ])->refresh();

        $this->url = route('categories.destroy', [
            'category' => $this->category->slug,
        ]);
    }

    public function testWhenCategoryDelete()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $this->authenticatedUser($this->author);

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
        $response = $this->deleteJson($this->url, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $expected = $this->errorMessage(Response::HTTP_UNAUTHORIZED);

        // WHEN
        $response = $this->deleteJson($this->url, $this->headers);
        // $this->delete will output:
        // Symfony\Component\Routing\Exception\RouteNotFoundException: Route [login] not defined.

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenCategoryUpdatedByWrongUser()
    {
        // GIVEN
        $this->authenticatedUser();

        $expected = $this->errorMessage(Response::HTTP_FORBIDDEN);

        // WHEN
        $response = $this->deleteJson($this->url, $this->headers);
        // $this->delete will output:
        // Illuminate\Auth\Access\AuthorizationException: This action is unauthorized.

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }

    public function testWhenCategoryNotFound()
    {
        // GIVEN
        $this->authenticatedUser($this->author);

        $this->url = route('categories.destroy', [
            'category' => strtolower($this->faker->word),
        ]);

        $expected = $this->errorMessage(Response::HTTP_NOT_FOUND);

        // WHEN
        $response = $this->deleteJson($this->url, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
