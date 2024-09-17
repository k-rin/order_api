<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Services\Contracts\IOrderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreOrder
{
    /**
     * Create the event listener.
     */
    public function __construct(
        protected IOrderService $service,
    ) {}

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $this->service->create($event->orderInfo);
    }
}
