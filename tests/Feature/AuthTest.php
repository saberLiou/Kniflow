<?php

namespace Tests\Feature;

use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test AuthController@register.
     *
     * @return void
     */
    public function testRegister()
    {
        // GIVEN
        $formData = [
            User::NAME => 'Guo-Xun Liu',
            User::EMAIL => 'saberliou@gmail.com',
            User::PASSWORD => '12345678',
            PersonalAccessToken::DEVICE_NAME => 'iPhone8+',
        ];

        $headers = [
            'Accept' => 'application/json',
        ];

        $expected = [
            'data' => format_resource_object(1, User::TABLE, [
                User::NAME => $formData[User::NAME],
                User::EMAIL => $formData[User::EMAIL],
            ], [
                User::TOKENS => [
                    'data' => [
                        [
                            PersonalAccessToken::ID => 1,
                            PersonalAccessToken::TOKENABLE_TYPE => User::TABLE,
                            PersonalAccessToken::TOKENABLE_ID => 1,
                            PersonalAccessToken::NAME => $formData[PersonalAccessToken::DEVICE_NAME],
                        ],
                    ],
                ],
            ])
        ];

        // WHEN
        $response = $this->postJson(endpoint('auth.register'), $formData, $headers);

        // THEN
        $response->assertStatus(Response::HTTP_CREATED)->assertJson($expected);
    }
}
