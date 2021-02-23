<?php

namespace Tests;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * The url of a request.
     *
     * @var string
     */
    protected $url;

    /**
     * The additional headers of a request.
     *
     * @var array
     */
    protected $headers;

    /**
     * The json structure of a success response.
     *
     * @var array
     */
    protected $successResponseStructure = [
        'jsonapi' => ['version'],
        'data',
        'links' => ['self'],
    ];

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->headers = [
            'Accept' => 'application/json',
        ];
    }

    /**
     * Get an authenticated user.
     *
     * @return void
     */
    protected function authenticatedUser()
    {
        Sanctum::actingAs(
            User::factory()->create([
                User::NAME => config('scribe.example_values.name'),
                User::EMAIL => config('scribe.example_values.email'),
                User::PASSWORD => Hash::make(config('scribe.example_values.password')),
            ]),
            ['*']
        );
    }

    /**
     * Return unauthenticated error message.
     *
     * @return array
     */
    protected function unauthenticatedErrorMessage()
    {
        return [
            'errors' => format_error_objects(Response::HTTP_UNAUTHORIZED, [
                Response::$statusTexts[Response::HTTP_UNAUTHORIZED] => "Unauthenticated.",
            ])
        ];
    }

    /**
     * Format error messages of the field when validation failed.
     *
     * @param string $field
     * @param string $rule
     * @return array
     */
    protected function formatValidationErrorMessages(string $field, string $rule)
    {
        return [trans('validation.attributes.' . $field) . ' ' . trans('validation-inline.' . $rule)];
    }
}
