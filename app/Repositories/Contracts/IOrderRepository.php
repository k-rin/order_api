<?php

namespace App\Repositories\Contracts;

use App\Models\Order;

interface IOrderRepository
{
    public function create(string $orderId, string $currency): Order;

    public function get(string $orderId): ?Order;
}
