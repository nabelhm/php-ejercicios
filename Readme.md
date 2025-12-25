# PHP - Ejercicios de Práctica

Proyecto de ejercicios para practicar fundamentos de PHP siguiendo el roadmap de [roadmap.sh/php](https://roadmap.sh/php).

## Objetivo

Practicar conceptos básicos de PHP:
- Funciones
- Condicionales
- Ciclos
- TDD con PHPUnit

## Requisitos

- PHP 8.2+
- Composer
- PHPUnit 11

## Instalación
```bash
composer install
```

## Ejecutar tests
```bash
# Todos los tests
./vendor/bin/phpunit

# Un test específico
./vendor/bin/phpunit tests/NombreDelTest.php
```

## Tabla de Ejercicios

| # | Ejercicio | Conceptos | Estado |
|---|-----------|-----------|--------|
| 1 | [FizzBuzz](#1-fizzbuzz) | Ciclos, condicionales | Completado |
| 2 | [Validador de Contraseñas](#2-validador-de-contraseñas) | Funciones, strings, condicionales | Completado |
| 3 | [Calculadora de IMC](#3-calculadora-de-imc) | Funciones, condicionales, aritmética | En progreso |
| 4 | Contador de Vocales | Ciclos, strings | Pendiente |
| 5 | Generador de Tabla de Multiplicar | Ciclos anidados, arrays | Pendiente |

---

## Ejercicios

### 1. FizzBuzz

**Enunciado:**
Crea una clase `FizzBuzz` con un método `convert($n)` que retorne:
- "Fizz" si el número es divisible por 3
- "Buzz" si es divisible por 5
- "FizzBuzz" si es divisible por ambos
- El número como string si no es divisible por ninguno

**Conceptos practicados:**
- Condicionales
- Operador módulo
- Type hints
- Return types

---

### 2. Validador de Contraseñas

**Enunciado:**
Crea una clase `PasswordValidator` con un método `validate($password)` que retorne un array con:
```php
[
    'valid' => bool,
    'errors' => array // array de strings con los errores encontrados
]
```

Requisitos de validación:
- Mínimo 8 caracteres
- Al menos una letra mayúscula
- Al menos una letra minúscula
- Al menos un número
- Al menos un carácter especial

**Conceptos practicados:**
- Validación de strings
- Funciones de caracteres (ctype_*)
- Arrays
- Iteración de strings

---

### 3. Calculadora de IMC

**Enunciado:**
Crea una clase `BMICalculator` con un método `calculate($weight, $height)` que:
- Calcule el IMC (peso en kg / altura en metros al cuadrado)
- Retorne un array con:
```php
[
    'bmi' => float,        // IMC calculado, redondeado a 2 decimales
    'category' => string   // Categoría según la clasificación
]
```

**Clasificación:**
- BMI < 18.5 → "Bajo peso"
- 18.5 <= BMI < 25 → "Peso normal"
- 25 <= BMI < 30 → "Sobrepeso"
- BMI >= 30 → "Obesidad"

**Conceptos practicados:**
- Operaciones aritméticas
- Condicionales con rangos
- Redondeo de números
- Validación de entrada

---

## Recursos

- [Roadmap PHP](https://roadmap.sh/php)
- [PHPUnit Documentation](https://phpunit.de/)
- [PHP Documentation](https://www.php.net/docs.php)