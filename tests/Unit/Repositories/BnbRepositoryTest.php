<?php

namespace Tests\Unit\Repositories;

use App\Models\Bnb;
use App\Repositories\BnbRepository;
use Tests\TestCase;

class BnbRepositoryTest extends TestCase
{
    protected $model;
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->model      = \Mockery::mock(Bnb::class);
        $this->repository = new BnbRepository($this->model);
    }

    public function test_create_bnb()
    {
        $this->model
            ->shouldReceive('create')
            ->once()
            ->with([
                'name'     => 'name',
                'city'     => 'city',
                'district' => 'district',
                'street'   => 'street',
            ])
            ->andReturn(new Bnb);

        $this->repository->create('name', 'city', 'district', 'street');
    }

    public function test_get_bnb()
    {
        $this->model
            ->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn(new Bnb);

        $this->repository->get(1);
    }

    public function test_get_bnb_by_name()
    {
        $this->model
            ->shouldReceive('where')
            ->once()
            ->with('name', 'abc')
            ->andReturnSelf();
        $this->model
            ->shouldReceive('first')
            ->once()
            ->andReturn(new Bnb);

        $this->repository->getByName('abc');
    }
}
