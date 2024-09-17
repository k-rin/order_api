<?php

namespace App\Repositories;

use App\Models\OrderCur;
use App\Repositories\Contracts\IOrderCurRepository;

class OrderCurRepository implements IOrderCurRepository
{
    protected $model;

    public function __construct(OrderCur $model)
    {
        $this->model = $model;
    }

    public function create(int $id, int $bnbId, float $price, string $currency): OrderCur
    {
        $this->setCurrency($currency);

        return $this->model->create([
            'id'     => $id,
            'bnb_id' => $bnbId,
            'price'  => $price,
        ]);
    }

    public function get(int $id, string $currency): ?OrderCur
    {
        $this->setCurrency($currency);

        return $this->model->find($id);
    }

    private function setCurrency(string $currency): void
    {
        $this->model->bind('mysql', 'orders_' . strtolower($currency));
    }
}
