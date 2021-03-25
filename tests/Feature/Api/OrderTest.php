<?php

namespace Tests\Feature\Api;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Table;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * error create order
     *
     * @return void
     */
    public function testErrorCreateOrder()
    {
        $payload = [];
        $response = $this->postJson('/api/v1/orders', $payload);

        $response->assertStatus(422)
                    ->assertJsonPath('errors.token_company', [
                        trans('validation.required', ['attribute' => 'token company'])
                    ])->assertJsonPath('errors.products', [
                        trans('validation.required', ['attribute' => 'products'])
                    ]);
    }

    /**
     * create order
     *
     * @return void
     */
    public function testCreateOrder()
    {
        $tenant = factory(Tenant::class)->create();
        $payload = [
            'token_company' => $tenant->uuid,
            'products' => []
        ];

        $products = factory(Product::class, 10)->create();

        foreach ($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 2
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);

        $response->assertStatus(201);
    }

    /**
     * total order
     *
     * @return void
     */
    public function testTotalOrder()
    {
        $tenant = factory(Tenant::class)->create();
        $payload = [
            'token_company' => $tenant->uuid,
            'products' => []
        ];

        $products = factory(Product::class, 2)->create();

        foreach ($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 1
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);

        $response->assertStatus(201)
                    ->assertJsonPath('data.total', 25.8);
    }

    /**
     * Test Order not found
     *
     * @return void
     */
    public function testOrderNotFound()
    {
        $tenant = factory(Tenant::class)->create();
        $order = 'fake_value';

        $response = $this->getJson("api/v1/orders/{$order}?token_company={$tenant->uuid}");

        $response->assertStatus(404);
    }

    /**
     * Test get Order
     *
     * @return void
     */
    public function testGetOrder()
    {
        $tenant = factory(Tenant::class)->create();
        $order = factory(Order::class)->create();

        $response = $this->getJson("api/v1/orders/{$order->identify}?token_company={$tenant->uuid}");

        $response->assertStatus(200);
    }

    /**
     * create new order authenticated
     *
     * @return void
     */
    public function testCreateOrderAuthenticated()
    {
        $client = factory(Client::class)->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        $tenant = factory(Tenant::class)->create();
        $payload = [
            'token_company' => $tenant->uuid,
            'products' => []
        ];

        $products = factory(Product::class, 2)->create();

        foreach ($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 1
            ]);
        }

        $response = $this->postJson('/api/auth/v1/orders', $payload, [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(201);
    }

    /**
     * create new order with table
     *
     * @return void
     */
    public function testCreateOrderWithTable()
    {
        $table = factory(Table::class)->create();        

        $tenant = factory(Tenant::class)->create();

        $payload = [
            'token_company' => $tenant->uuid,
            'table' => $table->uuid,
            'products' => []
        ];

        $products = factory(Product::class, 2)->create();

        foreach ($products as $product) {
            array_push($payload['products'], [
                'identify' => $product->uuid,
                'qty' => 1
            ]);
        }

        $response = $this->postJson('/api/v1/orders', $payload);

        $response->assertStatus(201);
    }

    /**
     * teszt get my orders
     *
     * @return void
     */
    public function testGetMyOrders()
    {
        $client = factory(Client::class)->create();
        $token = $client->createToken(Str::random(10))->plainTextToken;

        factory(Order::class, 15)->create(['client_id' => $client->id]);

        $response = $this->getJson('/api/auth/v1/my-orders', [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(200)
                    ->assertJsonCount(15, 'data');
    }
}
