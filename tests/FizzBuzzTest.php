<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Ejercicios\FizzBuzz;

class FizzBuzzTest extends TestCase
{
    private FizzBuzz $fizzbuzz; 
   
    protected function setUp(): void
    {
        parent::setUp();
        $this->fizzbuzz = new FizzBuzz();
    }
    
    public function testNumeroNormalDevuelveNumero()
    {
        $this->assertEquals('1', $this->fizzbuzz->convert(1));
        $this->assertEquals('2', $this->fizzbuzz->convert(2));
    }

    public function testMultiploDeTresDevuelveFizz()
    {
        $this->assertEquals('Fizz', $this->fizzbuzz->convert(3));
        $this->assertEquals('Fizz', $this->fizzbuzz->convert(6));
    }

    public function testMultiploDeCincoDevuelveBuzz()
    {
        $this->assertEquals('Buzz', $this->fizzbuzz->convert(5));
        $this->assertEquals('Buzz', $this->fizzbuzz->convert(10));
    }

    public function testMultiploDeAmbosDevuelveFizzBuzz()
    {
        $this->assertEquals('FizzBuzz', $this->fizzbuzz->convert(15));
        $this->assertEquals('FizzBuzz', $this->fizzbuzz->convert(30));
    }
}