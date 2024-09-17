<?php

namespace Tests\Unit\Repositories;

use App\Models\Order;
use App\Repositories\OrderRepository;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    protected $model;
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->model      = \Mockery::mock(Order::class);
        $this->repository = new OrderRepository($this->model);
    }

    public function test_create_order()
    {
        $this->model
            ->shouldReceive('create')
            ->once()
            ->with([
                'order_id' => 'A0000001',
                'currency' => 'TWD',
            ])
            ->andReturn(new Order);

        $this->repository->create('A0000001', 'TWD');
    }

    public function test_get_order()
    {
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('order_id', 'A0000001')
            ->andReturnSelf();
        $this->model
            ->shouldReceive('first')
            ->once()
            ->andReturn(new Order);

        $this->repository->get('A0000001');
    }
}
