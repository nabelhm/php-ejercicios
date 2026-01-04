<?php

declare(strict_types=1);

namespace Tests\OOP\Validation;

use Ejercicios\OOP\Validation\Validators\RegexValidator;
use PHPUnit\Framework\TestCase;

class RegexValidatorTest extends TestCase
{
    public function testConstructValidator(): void
    {
        $validator = new RegexValidator("/(foo)(bar)(baz)/");
        $this->assertInstanceOf(RegexValidator::class, $validator);
    }

    public function testValidateValidValue(): void
    {
        $validator = new RegexValidator("/(foo)(bar)(baz)/");
        $this->assertTrue($validator->validate('foobarbaz'));
    }

    public function testValidateInvalidValue(): void
    {
        $validator = new RegexValidator("/(foo)(bar)(baz)/");
        $this->assertFalse($validator->validate('foobar'));
    }

    public function testGetError(): void
    {
        $validator = new RegexValidator("/(foo)(bar)(baz)/");

        $this->assertEquals('Value does not match required pattern', $validator->getError());
    }
}
