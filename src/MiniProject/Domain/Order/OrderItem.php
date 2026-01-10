<?php
declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Order;

use Ejercicios\MiniProject\Domain\Money\Money;
use Ejercicios\MiniProject\Domain\Product\Product;
use InvalidArgumentException;

class OrderItem
{
    public function __construct(
        private Product $product,
        private int $quantity,
    )
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException("Quantity must be higher than zero");
        }
    }

    public function subtotal(): Money
    {
        return $this->product->price()->multiply((float) $this->quantity);
    }
}
