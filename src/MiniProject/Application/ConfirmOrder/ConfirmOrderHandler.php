<?php
declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\ConfirmOrder;

use Ejercicios\MiniProject\Application\ConfirmOrder\Exception\OrderNotFoundException;
use Ejercicios\MiniProject\Domain\Order\OrderRepositoryInterface;
use Ejercicios\MiniProject\Domain\Shared\Uuid;

final class ConfirmOrderHandler
{
    public function __construct(private OrderRepositoryInterface $orderRepository)
    {}

    public function handle(ConfirmOrderCommand $command): ConfirmedOrderDto
    {
        $orderId = $command->orderId;
        $order = $this->orderRepository->find(Uuid::fromString($orderId));
        if (null === $order) {
            throw new OrderNotFoundException("There is no order with id $orderId");
        }

        $order->confirm();

        $this->orderRepository->save($order);

        //TODO: lanzar evento

        return new ConfirmedOrderDto(
            $order->id()->value(),
            $order->status()->value
        );
    }
}