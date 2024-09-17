<?php

namespace Tests\Unit\Http\Controllers\Api;

use App\Dtos\OrderDto;
use App\Events\OrderCreated;
use App\Listeners\StoreOrder;
use App\Services\Contracts\IOrderService;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    protected $orderService;

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();

        $this->orderService = \Mockery::mock(IOrderService::class);
        $this->app->instance(IOrderService::class, $this->orderService);
    }

    public function test_store_order_successfully()
    {
        $this->postJson('/api/orders', $this->getPostData())
            ->assertStatus(200);

        Event::assertDispatched(OrderCreated::class);
    }

    public function test_store_order_without_id()
    {
        $data = $this->getPostData();
        unset($data['id']);

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The id field is required.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_with_invalid_id()
    {
        $data = $this->getPostData();
        $data['id'] = 1234;

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The id field must be a string.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_without_name()
    {
        $data = $this->getPostData();
        unset($data['name']);

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The name field is required.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_with_invalid_name()
    {
        $data = $this->getPostData();
        $data['name'] = 1234;

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The name field must be a string.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_without_price()
    {
        $data = $this->getPostData();
        unset($data['price']);

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The price field is required.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_with_invalid_price()
    {
        $data = $this->getPostData();
        $data['price'] = 'abcd';

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The price field must be a number.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_with_minus_price()
    {
        $data = $this->getPostData();
        $data['price'] = '-1000';

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The price field must be greater than 0.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_without_currency()
    {
        $data = $this->getPostData();
        unset($data['currency']);

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The currency field is required.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_with_invalid_currency()
    {
        $data = $this->getPostData();
        $data['currency'] = 'abcd';

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The selected currency is invalid.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_without_address()
    {
        $data = $this->getPostData();
        unset($data['address']);

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The address field is required.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_with_invalid_address()
    {
        $data = $this->getPostData();
        $data['address'] = 'abcd';

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The address field must be an array.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_without_city()
    {
        $data = $this->getPostData();
        unset($data['address']['city']);

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The address.city field is required.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_with_invalid_city()
    {
        $data = $this->getPostData();
        $data['address']['city'] = 1234;

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The address.city field must be a string.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_without_district()
    {
        $data = $this->getPostData();
        unset($data['address']['district']);

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The address.district field is required.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_with_invalid_district()
    {
        $data = $this->getPostData();
        $data['address']['district'] = 1234;

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The address.district field must be a string.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_without_street()
    {
        $data = $this->getPostData();
        unset($data['address']['street']);

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The address.street field is required.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_store_order_with_invalid_street()
    {
        $data = $this->getPostData();
        $data['address']['street'] = 1234;

        $this->postJson('/api/orders', $data)
            ->assertSeeText('The address.street field must be a string.')
            ->assertStatus(422);

        Event::assertNotDispatched(OrderCreated::class);
    }

    public function test_get_order_successfully()
    {
        $this->orderService
            ->shouldReceive('get')
            ->with('abcd')
            ->once()
            ->andReturn(new OrderDto);

        $this->getJson('/api/orders/abcd')
            ->assertStatus(200);
    }

    public function test_get_order_not_found()
    {
        $this->orderService
            ->shouldReceive('get')
            ->with('abcd')
            ->once()
            ->andReturn(null);

        $this->getJson('/api/orders/abcd')
            ->assertSeeText('Order (abcd) dose not exist.')
            ->assertStatus(404);
    }

    private function getPostData()
    {
        return [
            'id'       => 'A0000001',
            'name'     => 'Melody Holiday Inn',
            'price'    => '2050',
            'currency' => 'TWD',
            'address'  => [
                'city'     => 'taipei-city',
                'district' => 'da-an-district',
                'street'   => 'fuxing-south-road',
            ],
        ];
    }
}
