<?php

namespace Tests\Feature\Api;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test validation auth
     *
     * @return void
     */
    public function testValidationAuth()
    {
        $response = $this->postJson('/api/auth/token');

        $response->assertStatus(422);
    }

    /**
     * Test auth with client fake
     *
     * @return void
     */
    public function testAuthClientFake()
    {
        $payload = [
            'email' => 'email@email.com',
            'password' => '12345678',
            'device_name' => Str::random(10),
        ];

        $response = $this->postJson('/api/auth/token', $payload);

        $response->assertStatus(404)
                        ->assertExactJson([
                            'message' => trans('messages.invalid_credentials')
                        ]);
    }

    /**
     * Test auth with client
     *
     * @return void
     */
    public function testAuthClientSuccess()
    {
        $client = factory(Client::class)->create();

        $payload = [
            'email' => $client->email,
            'password' => 'password',
            'device_name' => Str::random(10),
        ];

        $response = $this->postJson('/api/auth/token', $payload);

        $response->assertStatus(200)
                        ->assertJsonStructure(['token']);
    }

    /**
     * Error get me
     *
     * @return void
     */
    public function testErrorGetMe()
    {
        $response = $this->getJson('/api/me');

        $response->assertStatus(401);
    }

    /**
     * get me
     *
     * @return void
     */
    public function testGetMe()
    {
        $client = factory(Client::class)->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        $response = $this->getJson('/api/me', [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(200)
                        ->assertExactJson([
                            'data' => [
                                'name' => $client->name,
                                'email' => $client->email
                            ]
                        ]);
    }

    /**
     * logout
     *
     * @return void
     */
    public function testLogout()
    {
        $client = factory(Client::class)->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => "Bearer {$token}",
        ]);

        $response->assertStatus(204);;
    }
}
