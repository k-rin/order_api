<?php

namespace App\Repositories\Contracts;

use App\Models\Bnb;

interface IBnbRepository
{
    public function create(string $name, string $city, string $district, string $street): Bnb;

    public function get(int $id): Bnb;

    public function getByName(string $name): ?Bnb;
}
