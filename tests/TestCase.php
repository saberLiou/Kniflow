<?php

namespace Tests;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

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
}
