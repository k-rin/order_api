<?php

namespace App\Repositories;

use App\Models\Bnb;
use App\Repositories\Contracts\IBnbRepository;

class BnbRepository implements IBnbRepository
{
    protected $model;

    public function __construct(Bnb $model)
    {
        $this->model = $model;
    }

    public function create(string $name, string $city, string $district, string $street): Bnb
    {
        return $this->model->create([
            'name'     => $name,
            'city'     => $city,
            'district' => $district,
            'street'   => $street,
        ]);
    }

    public function get(int $id): Bnb
    {
        return $this->model->find($id);
    }

    public function getByName(string $name): ?Bnb
    {
        return $this->model->where('name', $name)->first();
    }
}
