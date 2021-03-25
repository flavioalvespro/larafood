<?php

namespace Tests\Feature\Api;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class EvalutationTest extends TestCase
{
    /**
     * test error create new evaluation
     *
     * @return void
     */
    public function testErrorCreateEvaluation()
    {
        $order = 'fake_value';

        $response = $this->postJson("api/auth/v1/orders/{$order}/evaluations");

        $response->assertStatus(401);
    }

    /**
     * test create new evaluation
     *
     * @return void
     */
    public function testCreateEvaluation()
    {
        $client = factory(Client::class)->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        $order = $client->orders()->save(factory(Order::class)->make());

        $payload = [
            'stars' => 5,
            'comment' => Str::random(10)
        ];

        $headers = [
            'Authorization' => "Bearer {$token}",
        ];

        $response = $this->postJson("api/auth/v1/orders/{$order->identify}/evaluations", $payload, $headers);

        $response->assertStatus(201);
    }
}
