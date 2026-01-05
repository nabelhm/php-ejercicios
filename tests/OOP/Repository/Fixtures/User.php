<?php

declare(strict_types=1);

namespace Tests\OOP\Repository\Fixtures;

use Ejercicios\OOP\Repository\Entity;
use Ejercicios\OOP\Repository\Timestampable;

#[Entity(table: 'users')]
class User
{
    use Timestampable;
    
    public string $id;
    
    public function __construct(public string $name)
    {
        $this->initializeTimestamps();
    }
}