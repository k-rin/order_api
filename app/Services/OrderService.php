<?php

namespace App\Services;

use App\Dtos\OrderDto;
use App\Repositories\Contracts\IBnbRepository;
use App\Repositories\Contracts\IOrderCurRepository;
use App\Repositories\Contracts\IOrderRepository;
use App\Services\Contracts\IOrderService;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService implements IOrderService
{
    protected $bnbRepository;
    protected $orderCurRepository;
    protected $orderRepository;

    public function __construct(
        IBnbRepository      $bnbRepository,
        IOrderCurRepository $orderCurRepository,
        IOrderRepository    $orderRepository
    ) {
        $this->bnbRepository      = $bnbRepository;
        $this->orderCurRepository = $orderCurRepository;
        $this->orderRepository    = $orderRepository;
    }

    public function create(array $orderInfo): OrderDto
    {
        try {
            DB::beginTransaction();
            // Check if the order already exists.
            $order = $this->orderRepository->get($orderInfo['id']);
            if ($order) {
                throw new Exception("Order ({$orderInfo['id']}) has been created.");
            }
            $order = $this->orderRepository->create($orderInfo['id'], $orderInfo['currency']);
            // Retrieve the bnb information; if not available, store it.
            $bnb = $this->bnbRepository->getByName($orderInfo['name']);
            if (empty($bnb)) {
                $bnb = $this->bnbRepository->create(
                    $orderInfo['name'],
                    $orderInfo['address']['city'],
                    $orderInfo['address']['district'],
                    $orderInfo['address']['street']
                );
            }
            // Store the order in the corresponding currency table.
            $orderCur = $this->orderCurRepository->create($order->id, $bnb->id, $orderInfo['price'], $orderInfo['currency']);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return OrderDto::create($order, $bnb, $orderCur);
    }

    public function get(string $orderId): ?OrderDto
    {
        $orderDto = null;

        if ($order = $this->orderRepository->get($orderId)) {
            $orderCur = $this->orderCurRepository->get($order->id, $order->currency);
            $bnb      = $this->bnbRepository->get($orderCur->bnb_id);
            $orderDto = OrderDto::create($order, $bnb, $orderCur);
        }

        return $orderDto;
    }
}
