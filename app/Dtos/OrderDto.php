<?php

namespace App\Dtos;

use App\Models\Bnb;
use App\Models\Order;
use App\Models\OrderCur;

class OrderDto
{
    public string $id;
    public string $name;
    public array  $address;
    public float  $price;
    public string $currency;

    public static function create(Order $order, Bnb $bnb, OrderCur $orderCur): self
    {
        $orderDto = new self;

        $orderDto->id       = $order->order_id;
        $orderDto->name     = $bnb->name;
        $orderDto->price    = $orderCur->price;
        $orderDto->currency = $order->currency;
        $orderDto->address  = [
            'city'     => $bnb->city,
            'district' => $bnb->district,
            'street'   => $bnb->street,
        ];

        return $orderDto;
    }
}