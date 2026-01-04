<?php
declare(strict_types=1);

namespace Ejercicios\OOP\Validation;

class ValidationPipeline
{
    use ValidatorChain;
    
    public function __construct(private bool $stopOnFirstError = true) {}
    
    public function validate(mixed $value): ValidationResult
    {
        $errors = [];
        
        foreach ($this->validators as $validator) {
            if (!$validator->validate($value)) {
                $errors[] = $validator->getError();
                
                if ($this->stopOnFirstError) {
                    break;
                }
            }
        }
        
        return new ValidationResult(
            valid: empty($errors),
            errors: $errors
        );
    }
}
