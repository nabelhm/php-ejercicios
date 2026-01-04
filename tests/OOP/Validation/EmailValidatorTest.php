<?php
declare(strict_types=1);

namespace Tests\OOP\Validation;

use Ejercicios\OOP\Validation\Validators\EmailValidator;
use PHPUnit\Framework\TestCase;

class EmailValidatorTest extends TestCase
{
    public function testConstructValidator(): void
    {
        $validator = new EmailValidator();
        $this->assertInstanceOf(EmailValidator::class, $validator);
    }

    public function testValidateValidEmail(): void
    {
        $validator = new EmailValidator();

        $this->assertTrue($validator->validate('email@domain.es'));
    }

    public function testValidateInvalidEmail(): void
    {
        $validator = new EmailValidator();

        $this->assertFalse($validator->validate('email.domain.es'));
    }

    public function testGetErrorEmail(): void
    {
        $validator = new EmailValidator();

        $this->assertEquals('Invalid email format', $validator->getError());
    }
}