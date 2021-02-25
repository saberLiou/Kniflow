<?php

namespace Tests\Feature;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * Test AuthController@register.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class RegisterTest extends TestCase
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

        $this->url = route('auth.register');
    }

    public function testWhenRegistrationSucceeded()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $formData = [
            User::NAME => config('scribe.example_values.name'),
            User::EMAIL => config('scribe.example_values.email'),
            User::PASSWORD => config('scribe.example_values.password'),
            PersonalAccessToken::DEVICE_NAME => config('scribe.example_values.device_name'),
        ];

        $expected = [
            'data' => format_resource_object(1, User::TABLE, [
                User::NAME => $formData[User::NAME],
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
        $response->assertStatus(Response::HTTP_CREATED)->assertJson($expected);
    }

    public function testWhenAnyValidationFailed()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $formData = [];

        $expected = [
            'errors' => format_error_objects(Response::HTTP_UNPROCESSABLE_ENTITY, [
                User::NAME => $this->formatValidationErrorMessages(User::NAME, 'required'),
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
