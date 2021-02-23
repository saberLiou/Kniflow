<?php

namespace Tests\Feature;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * Test AuthController@login.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class LoginTest extends TestCase
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

        $this->url = route('auth.login');

        $this->postJson(route('auth.register'), [
            User::NAME => config('scribe.example_values.name'),
            User::EMAIL => config('scribe.example_values.email'),
            User::PASSWORD => config('scribe.example_values.password'),
            PersonalAccessToken::DEVICE_NAME => config('scribe.example_values.device_name'),
        ], $this->headers);
    }

    public function testWhenLoginSucceeded()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $formData = [
            User::EMAIL => config('scribe.example_values.email'),
            User::PASSWORD => config('scribe.example_values.password'),
            PersonalAccessToken::DEVICE_NAME => config('scribe.example_values.device_name'),
        ];

        $expected = [
            'data' => format_resource_object(1, User::TABLE, [
                User::EMAIL => $formData[User::EMAIL],
            ], [
                User::TOKENS => [
                    'data' => [
                        [
                            PersonalAccessToken::NAME => $formData[PersonalAccessToken::DEVICE_NAME],
                        ],
                    ],
                ],
            ])
        ];

        // WHEN
        $response = $this->postJson($this->url, $formData, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenAnyValidationFailed()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $formData = [];

        $expected = [
            'errors' => format_error_objects(Response::HTTP_UNPROCESSABLE_ENTITY, [
                User::EMAIL => $this->formatValidationErrorMessages(User::EMAIL, 'required'),
                User::PASSWORD => $this->formatValidationErrorMessages(User::PASSWORD, 'required'),
                PersonalAccessToken::DEVICE_NAME => $this->formatValidationErrorMessages(
                    PersonalAccessToken::DEVICE_NAME,
                    'required'
                ),
            ])
        ];

        // WHEN
        $response = $this->postJson($this->url, $formData, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
