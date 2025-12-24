<?php

namespace Tests;

use Ejercicios\PasswordValidator;
use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
    private PasswordValidator $validator; 
   
    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new PasswordValidator();
    }
    
    public function testValidPassword(): void
    {
        $password = "123.Abcd";
    
        ['valid' => $valid, 'errors' => $errors] = $this->validator->validate($password);

        $this->assertTrue($valid);

        $this->assertIsArray($errors);
        $this->assertEmpty($errors);
    }

    public function testPasswordUnder8(): void
    {
        $password = "123.Abc";
    
        ['valid' => $valid, 'errors' => $errors] = $this->validator->validate($password);

        $this->assertFalse($valid);

        $this->assertIsArray($errors);
        $this->assertEquals(1, count($errors));

        $this->assertContains('under_8_char',$errors);
    }

    public function testPasswordNoUpper(): void
    {
        $password = "1234.abc";
    
        ['valid' => $valid, 'errors' => $errors] = $this->validator->validate($password);

        $this->assertFalse($valid);

        $this->assertIsArray($errors);
        $this->assertEquals(1, count($errors));

        $this->assertContains('no_upper',$errors);
    }

    public function testPasswordNoLower(): void
    {
        $password = "1234.ABC";
    
        ['valid' => $valid, 'errors' => $errors] = $this->validator->validate($password);

        $this->assertFalse($valid);

        $this->assertIsArray($errors);
        $this->assertEquals(1, count($errors));

        $this->assertContains('no_lower',$errors);
    }

    public function testPasswordNoNumber(): void
    {
        $password = "ABC.defg";
    
        ['valid' => $valid, 'errors' => $errors] = $this->validator->validate($password);

        $this->assertFalse($valid);

        $this->assertIsArray($errors);
        $this->assertEquals(1, count($errors));

        $this->assertContains('no_number',$errors);
    }

    public function testPasswordNoSpecialChar(): void
    {
        $password = "1234Abcd";
    
        ['valid' => $valid, 'errors' => $errors] = $this->validator->validate($password);

        $this->assertFalse($valid);

        $this->assertIsArray($errors);
        $this->assertEquals(1, count($errors));

        $this->assertContains('no_special_char',$errors);
    }
}