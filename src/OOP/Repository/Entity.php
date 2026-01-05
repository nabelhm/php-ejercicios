<?php
declare(strict_types=1);

namespace Ejercicios\OOP\Repository;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Entity
{
    public function __construct(public string $table = '') {}
}