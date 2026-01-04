<?php
declare(strict_types=1);

namespace Ejercicios\OOP\Validation;

trait ValidatorChain {
    private array $validators = [];
    
    public function add(ValidatorInterface $validator): self
    {
        $this->validators[] = $validator;
        return $this;  // ← Esto permite el chaining
    }
}