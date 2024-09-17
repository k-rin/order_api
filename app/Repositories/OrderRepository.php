<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\IOrderRepository;

class OrderRepository implements IOrderRepository
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function create(string $orderId, string $currency): Order
    {
        return $this->model->create([
            'order_id' => $orderId,
            'currency' => $currency,
        ]);
    }

    public function get(string $orderId): ?Order
    {
        return $this->model->where('order_id', $orderId)->first();
    }
}
