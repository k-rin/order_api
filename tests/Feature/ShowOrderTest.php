<?php

namespace Tests\Feature;

use Database\Seeders\BnbSeeder;
use Database\Seeders\OrderCurSeeder;
use Database\Seeders\OrderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_order_successfully()
    {
        $this->seed(OrderSeeder::class);
        $this->seed(BnbSeeder::class);
        $this->seed(OrderCurSeeder::class);

        $response = $this->getJson('/api/orders/TE000001');

        $response->assertStatus(200);
    }

    public function test_show_order_not_found()
    {
        $response = $this->getJson('/api/orders/TE000002');

        $response->assertStatus(404);
    }
}
