<?php

namespace Tests\Unit\Services;

use App\Dtos\OrderDto;
use App\Models\Bnb;
use App\Models\Order;
use App\Models\OrderCur;
use App\Repositories\Contracts\IBnbRepository;
use App\Repositories\Contracts\IOrderCurRepository;
use App\Repositories\Contracts\IOrderRepository;
use App\Services\OrderService;
use Exception;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    protected $bnbRepository;
    protected $orderCurRepository;
    protected $orderRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->bnbRepository      = $this->createMock(IBnbRepository::class);
        $this->orderCurRepository = $this->createMock(IOrderCurRepository::class);
        $this->orderRepository    = $this->createMock(IOrderRepository::class);

        $this->service = new OrderService(
            $this->bnbRepository,
            $this->orderCurRepository,
            $this->orderRepository
        );
    }

    public function test_create_exist_order()
    {
        DB::shouldReceive('beginTransaction');
        $this->orderRepository
            ->expects($this->once())
            ->method('get')
            ->with('A0000001')
            ->willReturn(new Order);
        $this->orderRepository
            ->expects($this->never())
            ->method('create');
        $this->bnbRepository
            ->expects($this->never())
            ->method('getByName');
        $this->bnbRepository
            ->expects($this->never())
            ->method('create');
        $this->orderCurRepository
            ->expects($this->never())
            ->method('create');
        DB::shouldNotReceive('commit');
        DB::shouldReceive('rollBack');
        $this->expectException(Exception::class);

        $this->service->create($this->getPostData());
    }

    public function test_create_order_with_exist_bnb()
    {
        DB::shouldReceive('beginTransaction');
        $this->orderRepository
            ->expects($this->once())
            ->method('get')
            ->with('A0000001')
            ->willReturn(null);
        $this->orderRepository
            ->expects($this->once())
            ->method('create')
            ->with('A0000001', 'TWD')
            ->willReturn($this->getOrder());
        $this->bnbRepository
            ->expects($this->once())
            ->method('getByName')
            ->with('Melody Holiday Inn')
            ->willReturn($this->getBnb());
        $this->bnbRepository
            ->expects($this->never())
            ->method('create');
        $this->orderCurRepository
            ->expects($this->once())
            ->method('create')
            ->with(1, 1, 2050)
            ->willReturn($this->getOrderCur());
        DB::shouldReceive('commit');
        DB::shouldNotReceive('rollBack');

        $this->service->create($this->getPostData());
    }

    public function test_create_order_with_not_exist_bnb()
    {
        DB::shouldReceive('beginTransaction');
        $this->orderRepository
            ->expects($this->once())
            ->method('get')
            ->with('A0000001')
            ->willReturn(null);
        $this->orderRepository
            ->expects($this->once())
            ->method('create')
            ->with('A0000001', 'TWD')
            ->willReturn($this->getOrder());
        $this->bnbRepository
            ->expects($this->once())
            ->method('getByName')
            ->with('Melody Holiday Inn')
            ->willReturn(null);
        $this->bnbRepository
            ->expects($this->once())
            ->method('create')
            ->with('Melody Holiday Inn', 'taipei-city', 'da-an-district', 'fuxing-south-road')
            ->willReturn($this->getBnb());
        $this->orderCurRepository
            ->expects($this->once())
            ->method('create')
            ->with(1, 1, 2050)
            ->willReturn($this->getOrderCur());
        DB::shouldReceive('commit');
        DB::shouldNotReceive('rollBack');

        $this->service->create($this->getPostData());
    }

    public function test_get_exist_order()
    {
        $this->orderRepository
            ->expects($this->once())
            ->method('get')
            ->with('A0000001')
            ->willReturn($this->getOrder());
        $this->orderCurRepository
            ->expects($this->once())
            ->method('get')
            ->with(1)
            ->willReturn($this->getOrderCur());
        $this->bnbRepository
            ->expects($this->once())
            ->method('get')
            ->with(1)
            ->willReturn($this->getBnb());

        $this->service->get('A0000001');
    }

    public function test_get_not_exist_order()
    {
        $this->orderRepository
            ->expects($this->once())
            ->method('get')
            ->with('A0000001')
            ->willReturn(null);
        $this->orderCurRepository
            ->expects($this->never())
            ->method('get');
        $this->bnbRepository
            ->expects($this->never())
            ->method('get');

        $this->assertNull($this->service->get('A0000001'));
    }

    private function getPostData()
    {
        return [
            'id'       => 'A0000001',
            'name'     => 'Melody Holiday Inn',
            'price'    => 2050,
            'currency' => 'TWD',
            'address'  => [
                'city'     => 'taipei-city',
                'district' => 'da-an-district',
                'street'   => 'fuxing-south-road',
            ],
        ];
    }

    private function getBnb()
    {
        $bnb = new Bnb;

        $bnb->id       = 1;
        $bnb->name     = 'Melody Holiday Inn';
        $bnb->city     = 'taipei-city';
        $bnb->district = 'da-an-district';
        $bnb->street   = 'fuxing-south-road';

        return $bnb;
    }

    private function getOrder()
    {
        $order = new Order;

        $order->id       = 1;
        $order->order_id = 'A0000001';
        $order->currency = 'TWD';

        return $order;
    }

    private function getOrderCur()
    {
        $orderCur = new OrderCur;

        $orderCur->bnb_id = 1;
        $orderCur->price  = 2050;

        return $orderCur;
    }
}
