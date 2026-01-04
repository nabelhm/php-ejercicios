<?php

declare(strict_types=1);

namespace Tests\OOP\Validation;

use Ejercicios\OOP\Validation\ValidationPipeline;
use Ejercicios\OOP\Validation\Validators\EmailValidator;
use Ejercicios\OOP\Validation\Validators\LengthValidator;
use PHPUnit\Framework\TestCase;

class ValidationPipelineTest extends TestCase
{
    public function testConstruct(): void
    {
        $pipeline = new ValidationPipeline(true);
        $this->assertInstanceOf(ValidationPipeline::class, $pipeline);
    }

    public function testFluentInterfaceReturnsItself(): void
    {
        $pipeline = new ValidationPipeline();
        $result = $pipeline->add(new EmailValidator());

        $this->assertSame($pipeline, $result);  // ✅ Verifica que es LA MISMA instancia
    }

    public function testValidateValidValue(): void
    {
        $pipeline = new ValidationPipeline(true);
        $pipeline->add(new EmailValidator());

        $validationResult = $pipeline->validate('email@domain.es');

        $this->assertTrue($validationResult->isValid());
        $this->assertEmpty($validationResult->getErrors());
    }

    public function testValidateSingleValidator(): void
    {
        $pipeline = new ValidationPipeline(true);
        $pipeline->add(new EmailValidator());

        $validationResult = $pipeline->validate('email.domain.es');

        $this->assertFalse($validationResult->isValid());
        $this->assertNotEmpty($validationResult->getErrors());
    }

    public function testValidateMultipleValidator(): void
    {
        $pipeline = new ValidationPipeline(true);
        $pipeline->add(new EmailValidator())
            ->add(new LengthValidator(max: 8));

        $validationResult = $pipeline->validate('email.domain.es');

        $this->assertFalse($validationResult->isValid());
        $this->assertNotEmpty($validationResult->getErrors());
    }

    public function testValidateDoesNotStopFirstError(): void
    {
        $pipeline = new ValidationPipeline(false);
        $pipeline->add(new EmailValidator())
            ->add(new LengthValidator(max: 8));

        $validationResult = $pipeline->validate('email.domain.es');

        $this->assertFalse($validationResult->isValid());
        $this->assertCount(2, $validationResult->getErrors());
    }

    public function testStopOnFirstErrorTrue(): void
    {
        $pipeline = new ValidationPipeline(stopOnFirstError: true);
        $pipeline
            ->add(new EmailValidator())
            ->add(new LengthValidator(max: 5));

        $result = $pipeline->validate('invalid');

        $this->assertFalse($result->isValid());
        $this->assertCount(1, $result->getErrors());
    }

    public function testEmptyPipelineValidatesAsTrue(): void
    {
        $pipeline = new ValidationPipeline();
        $result = $pipeline->validate('anything');

        $this->assertTrue($result->isValid());
        $this->assertEmpty($result->getErrors());
    }
}
