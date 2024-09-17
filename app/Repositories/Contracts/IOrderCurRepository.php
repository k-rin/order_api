<?php

namespace App\Repositories\Contracts;

use App\Models\OrderCur;

interface IOrderCurRepository
{
    public function create(int $id, int $bnbId, float $price, string $currency): OrderCur;

    public function get(int $id, string $currency): ?OrderCur;
}
