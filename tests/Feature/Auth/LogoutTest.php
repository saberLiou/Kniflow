<?php

namespace Tests\Feature;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

/**
 * Test AuthController@logout.
 *
 * @author saberLiou <saberliou@gmail.com>
 */
class LogoutTest extends TestCase
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

        $this->url = route('auth.logout');
    }

    public function testWhenLogoutSucceeded()
    {
        $this->withoutExceptionHandling();

        // GIVEN
        $authUser = $this->authenticatedUser();

        $formData = [
            PersonalAccessToken::DEVICE_NAME => config('scribe.example_values.device_name'),
        ];

        $expected = [
            'data' => format_resource_object($authUser->id, User::TABLE, [
                User::NAME => $authUser->name,
                User::EMAIL => $authUser->email,
            ], [
                User::TOKENS => [],
            ])
        ];

        // WHEN
        $response = $this->post($this->url, $formData, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $formData = [
            PersonalAccessToken::DEVICE_NAME => config('scribe.example_values.device_name'),
        ];

        $expected = $this->errorMessage(Response::HTTP_UNAUTHORIZED);

        // WHEN
        $response = $this->postJson($this->url, $formData, $this->headers);

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
