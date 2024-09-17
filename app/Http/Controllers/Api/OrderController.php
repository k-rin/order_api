<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Services\Contracts\IOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(IOrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        OrderCreated::dispatch($request->validated());

        return response()->json([], 200);
    }

    public function show(string $id): JsonResponse
    {
        if ($order = $this->orderService->get($id)) {
            return response()->json($order, 200);
        }

        return response()->json([
            'error' => "Order ({$id}) dose not exist."
        ], 404);
    }
}
