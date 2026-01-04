<?php

declare(strict_types=1);

namespace Tests\OOP\Validation;

use Ejercicios\OOP\Validation\Validators\LengthValidator;
use PHPUnit\Framework\TestCase;

class LengthValidatorTest extends TestCase
{
    public function testConstructsValidator(): void
    {
        $validator = new LengthValidator();
        $this->assertInstanceOf(LengthValidator::class, $validator);
    }

    public function testValidateValidOnlyMin(): void
    {
        $validator = new LengthValidator(min: 5);

        $this->assertTrue($validator->validate('IamValid'));
    }
    
    public function testValidateValidOnlyMax(): void
    {
        $validator = new LengthValidator(max: 20);

        $this->assertTrue($validator->validate('IamValid'));
    }

    public function testValidateInvalidOnlyMin(): void
    {
        $validator = new LengthValidator(min: 9);

        $this->assertFalse($validator->validate('IamValid'));
    }

    public function testValidateInvalidOnlyMax(): void
    {
        $validator = new LengthValidator(max: 7);

        $this->assertFalse($validator->validate('IamValid'));
    }

    public function testValidateValidMinAndMax(): void
    {
        $validator = new LengthValidator(min: 5, max: 10);

        $this->assertTrue($validator->validate('IamValid'));
    }

    public function testValidateInvalidBelowMin(): void
    {
        $validator = new LengthValidator(min: 5, max: 10);
        $this->assertFalse($validator->validate('hi'));  // 2 chars
    }

    public function testValidateInvalidAboveMax(): void
    {
        $validator = new LengthValidator(min: 5, max: 10);
        $this->assertFalse($validator->validate('this is too long'));  // 17 chars
    }

    public function testGetErrorMessage(): void
    {
        $validator = new LengthValidator(min: 9, max: 8);
        $this->assertEquals('Length must be between 9 and 8', $validator->getError());
    }
}
