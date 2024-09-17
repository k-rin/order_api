<?php

namespace App\Services\Contracts;

use App\Dtos\OrderDto;

interface IOrderService
{
    public function create(array $orderInfo): OrderDto;

    public function get(string $orderId): ?OrderDto;
}
