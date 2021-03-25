<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * Error create new client
     *
     * @return void
     */
    public function testErrorCreateNewClient()
    {
        $payload = [
            'name' => 'Flavio client',
            'email' => 'flavio@punk.com.br'
        ];

        $response = $this->postJson('/api/auth/register', $payload);

        $response->assertStatus(422);
                // ->assertExactJson([
                //     'message' => 'The given data was invalid.',
                //     'errors' => [
                //         'password' => [trans('validation.required', ['attribute' => 'password'])]
                //     ]
                // ]);
    }

    /**
     * Create new client
     *
     * @return void
     */
    public function testCreateNewClient()
    {
        $payload = [
            'name' => 'Flavio client',
            'email' => 'flavio@punk.com.br',
            'password' => '12345678'
        ];

        $response = $this->postJson('/api/auth/register', $payload);

        $response->assertStatus(201)
                    ->assertExactJson([
                        'data' => [
                            'name' => $payload['name'],
                            'email' => $payload['email'],
                        ]
                    ]);
    }
}
