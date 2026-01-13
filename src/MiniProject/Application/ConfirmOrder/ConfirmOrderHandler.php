<?php
declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\ConfirmOrder;

use DateTimeImmutable;
use Ejercicios\MiniProject\Application\Shared\Exception\OrderNotFoundException;
use Ejercicios\MiniProject\Domain\Event\OrderConfirmed;
use Ejercicios\MiniProject\Domain\Order\OrderRepositoryInterface;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use Ejercicios\MiniProject\Infrastructure\Event\EventDispatcherInterface;

final class ConfirmOrderHandler
{
    public function __construct(private OrderRepositoryInterface $orderRepository, private EventDispatcherInterface $eventDispatcher)
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

         $this->eventDispatcher->dispatch(
            new OrderConfirmed(
                $order->id(),
                new DateTimeImmutable()
            )
        );

        return new ConfirmedOrderDto(
            $order->id()->value(),
            $order->status()->value
        );
    }
}