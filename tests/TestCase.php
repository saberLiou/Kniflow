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
     * @param User|null $user
     * @param array $scopes
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function authenticatedUser(User $user = null, array $scopes = ['*'])
    {
        return Sanctum::actingAs($user ?? User::factory()->create([
            User::NAME => config('scribe.example_values.name'),
            User::EMAIL => config('scribe.example_values.email'),
            User::PASSWORD => Hash::make(config('scribe.example_values.password')),
        ])->refresh(), $scopes);
    }

    /**
     * Return an error message by the status code of an HTTP response.
     *
     * @param integer $status
     * @return array
     */
    protected function errorMessage(int $status)
    {
        switch ($status) {
            case Response::HTTP_UNAUTHORIZED:
                $message = "Unauthenticated.";
                break;
            case Response::HTTP_NOT_FOUND:
                $message = "Cannot find the resource.";
                break;
            default:
                $message = "";
        }
        return [
            'errors' => format_error_objects($status, [
                Response::$statusTexts[$status] => $message,
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
