<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_order_successfully()
    {
        $response = $this->postJson('/api/orders', [
            'id'       => 'T0000001',
            'name'     => 'Feature Test Inn',
            'price'    => '9999',
            'currency' => 'TWD',
            'address'  => [
                'city'     => 'taipei-city',
                'district' => 'da-an-district',
                'street'   => 'fuxing-south-road',
            ],
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'order_id' => 'T0000001',
            'currency' => 'TWD',
        ]);
        $this->assertDatabaseHas('bnbs', [
            'name' => 'Feature Test Inn',
        ]);
        $this->assertDatabaseHas('orders_twd', [
            'price' => 9999,
        ]);
    }

    public function test_store_order_failed()
    {
        $response = $this->postJson('/api/orders', [
            'id'       => 123456,
            'name'     => 'Feature Test Inn',
            'price'    => '9999',
            'currency' => 'TWD',
            'address'  => [
                'city'     => 'taipei-city',
                'district' => 'da-an-district',
                'street'   => 'fuxing-south-road',
            ],
        ]);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('orders', [
            'order_id' => 123456,
            'currency' => 'TWD',
        ]);
        $this->assertDatabaseMissing('bnbs', [
            'name' => 'Feature Test Inn',
        ]);
        $this->assertDatabaseMissing('orders_twd', [
            'price' => 9999,
        ]);
    }
}
