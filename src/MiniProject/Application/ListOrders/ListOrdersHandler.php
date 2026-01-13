<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\ListOrders;

use Ejercicios\MiniProject\Application\GetOrder\OrderDto;
use Ejercicios\MiniProject\Application\GetOrder\OrderItemDto;
use Ejercicios\MiniProject\Domain\Order\OrderRepositoryInterface;

class ListOrdersHandler
{

    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    /**
     * @return OrderSummaryDTO[]
     */
    public function handle(ListOrdersQuery $query): array
    {
        $orders = $this->orderRepository->findAll();

        $ordersDto = [];
        foreach ($orders as $order) {
            $ordersDto[] =  new OrderSummaryDTO(
                orderId: $order->id()->value(),
                customerId: $order->customerId()->value(),
                status: $order->status()->value,
                totalAmount: $order->total()->amount,
                totalCurrency: $order->total()->currency->value,
                itemCount: count($order->items()),
                createdAt: $order->createdAt()->format('r')
            );
        }

        return $ordersDto;
    }
}
