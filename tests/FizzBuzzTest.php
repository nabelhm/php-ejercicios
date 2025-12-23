<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Ejercicios\FizzBuzz;

class FizzBuzzTest extends TestCase
{
    public function testNumeroNormalDevuelveNumero()
    {
        $fizzbuzz = new FizzBuzz();
        $this->assertEquals('1', $fizzbuzz->convert(1));
        $this->assertEquals('2', $fizzbuzz->convert(2));
    }

    public function testMultiploDeTresDevuelveFizz()
    {
        $fizzbuzz = new FizzBuzz();
        $this->assertEquals('Fizz', $fizzbuzz->convert(3));
        $this->assertEquals('Fizz', $fizzbuzz->convert(6));
    }

    public function testMultiploDeCincoDevuelveBuzz()
    {
        $fizzbuzz = new FizzBuzz();
        $this->assertEquals('Buzz', $fizzbuzz->convert(5));
        $this->assertEquals('Buzz', $fizzbuzz->convert(10));
    }

    public function testMultiploDeAmbosDevuelveFizzBuzz()
    {
        $fizzbuzz = new FizzBuzz();
        $this->assertEquals('FizzBuzz', $fizzbuzz->convert(15));
        $this->assertEquals('FizzBuzz', $fizzbuzz->convert(30));
    }
}