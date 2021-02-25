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
 * Test CategoryController@update.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class UpdateTest extends TestCase
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
     * The form data for request.
     *
     * @var array
     */
    protected $formData;

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

        $this->url = route('categories.update', [
            'category' => $this->category->slug,
        ]);

        $this->formData = [
            Category::NAME => $this->faker->word,
            Category::SORT => 2,
        ];
    }

    public function testWhenCategoryUpdated()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $this->authenticatedUser($this->author);

        $expected = [
            'data' => format_resource_object(1, Category::TABLE, [
                Category::SLUG => strtolower($this->formData[Category::NAME]),
                Category::NAME => $this->formData[Category::NAME],
                Category::SORT => $this->formData[Category::SORT],
            ], [
                Category::USER => [
                    'data' => [
                        User::ID => $this->author->id,
                    ],
                ],
            ]),
        ];

        // WHEN
        $response = $this->patch($this->url, $this->formData, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $expected = $this->errorMessage(Response::HTTP_UNAUTHORIZED);

        // WHEN
        $response = $this->patch($this->url, $this->formData, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenCategoryUpdatedByWrongUser()
    {
        // GIVEN
        $this->authenticatedUser();

        $expected = $this->errorMessage(Response::HTTP_FORBIDDEN);

        // WHEN
        $response = $this->patch($this->url, $this->formData, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }

    public function testWhenCategoryNotFound()
    {
        // GIVEN
        $this->authenticatedUser($this->author);

        $this->url = route('categories.update', [
            'category' => strtolower($this->faker->word),
        ]);

        $expected = $this->errorMessage(Response::HTTP_NOT_FOUND);

        // WHEN
        $response = $this->patch($this->url, $this->formData, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }

    public function testWhenAnyValidationFailed()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $this->authenticatedUser($this->author);

        $this->formData = [
            Category::NAME => $this->faker->randomDigit,
            Category::SORT => $this->faker->word,
        ];

        $expected = [
            'errors' => format_error_objects(Response::HTTP_UNPROCESSABLE_ENTITY, [
                Category::NAME => $this->formatValidationErrorMessages(Category::NAME, 'string'),
                Category::SORT => $this->formatValidationErrorMessages(Category::SORT, 'integer'),
            ]),
        ];

        // WHEN
        $response = $this->patch($this->url, $this->formData, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
