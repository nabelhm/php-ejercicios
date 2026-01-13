<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\GetOrder;

use Ejercicios\MiniProject\Application\GetOrder\OrderDto;
use Ejercicios\MiniProject\Application\Shared\Dto\OrderItemDto;
use Ejercicios\MiniProject\Application\Shared\Exception\OrderNotFoundException;
use Ejercicios\MiniProject\Domain\Order\OrderRepositoryInterface;
use Ejercicios\MiniProject\Domain\Shared\Uuid;

final readonly class GetOrderHandler
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    public function handle(GetOrderQuery $query): OrderDto
    {
        # desesctructurar query
        $orderId = $query->orderId;
        # buscar repositorio
        $order = $this->orderRepository->find(Uuid::fromString($orderId));
        #  si no existe lanza excepción
        if (null === $order) {
            throw new OrderNotFoundException("There is no order with id $orderId");
        }

        #  si existe devuelve dto
        #      dto orderItem, agregado
        $itemsArray = [];
        foreach ($order->items() as $item) {
            $itemsArray[] = new OrderItemDto(
                productId: $item->product()->id(),
                quantity: $item->quantity(),
                subtotalAmount: $item->subtotal()->amount,
                currency: $item->subtotal()->currency->value
            );
        }

        return new OrderDto(
            id: $order->id()->value(),
            customerId: $order->customerId()->value(),
            createdAt: $order->createdAt()->format('r'),
            status: $order->status()->value,
            totalAmount: $order->total()->amount,
            currency: $order->total()->currency->value,
            items: $itemsArray,
        );
        
    }
}
