<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * Test CategoryController@store.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class StoreTest extends TestCase
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

        $this->url = route('categories.store');
    }

    public function testWhenCategoryCreated()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $authUser = $this->authenticatedUser();

        $formData = [
            Category::NAME => config('scribe.example_values.name'),
            Category::SORT => 1,
        ];

        $expected = [
            'data' => format_resource_object(1, Category::TABLE, [
                Category::NAME => $formData[Category::NAME],
                Category::SORT => $formData[Category::SORT],
            ], [
                Category::USER => [
                    'data' => [
                        User::ID => $authUser->id,
                    ],
                ],
            ]),
        ];

        // WHEN
        $response = $this->post($this->url, $formData, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_CREATED)->assertJson($expected);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $formData = [
            Category::NAME => config('scribe.example_values.name'),
            Category::SORT => 1,
        ];

        $expected = $this->unauthenticatedErrorMessage();

        // WHEN
        $response = $this->post($this->url, $formData, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenAnyValidationFailed()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $this->authenticatedUser();

        $formData = [];

        $expected = [
            'errors' => format_error_objects(Response::HTTP_UNPROCESSABLE_ENTITY, [
                Category::NAME => $this->formatValidationErrorMessages(Category::NAME, 'required'),
            ]),
        ];

        // WHEN
        $response = $this->post($this->url, $formData, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
