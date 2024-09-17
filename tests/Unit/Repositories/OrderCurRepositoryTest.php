<?php

namespace Tests\Unit\Repositories;

use App\Models\OrderCur;
use App\Repositories\OrderCurRepository;
use Tests\TestCase;

class OrderCurRepositoryTest extends TestCase
{
    protected $model;
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->model      = \Mockery::mock(OrderCur::class);
        $this->repository = new OrderCurRepository($this->model);
    }

    public function test_create_order_currency()
    {
        $this->model
            ->shouldReceive('bind')
            ->once()
            ->with('mysql', 'orders_usd')
            ->andReturnSelf();
        $this->model
            ->shouldReceive('create')
            ->once()
            ->with([
                'id'     => 1,
                'bnb_id' => 1,
                'price'  => 1000,
            ])
            ->andReturn(new OrderCur);

        $this->repository->create(1, 1, 1000, 'USD');
    }

    public function test_get_order_currency()
    {
        $this->model
            ->shouldReceive('bind')
            ->once()
            ->with('mysql', 'orders_twd')
            ->andReturnSelf();
        $this->model
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn(new OrderCur);

        $this->repository->get(1, 'TWD');
    }
}
