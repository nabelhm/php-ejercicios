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
| 3 | [Calculadora de IMC](#3-calculadora-de-imc) | Funciones, condicionales, aritmética | Completado |
| 4 | [Contador de Vocales](#4-contador-de-vocales) | Ciclos, strings, arrays | Completado |
| 5 | [Analizador de Arrays](#5-analizador-de-arrays) | Ciclos, arrays, funciones | En progreso |

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

### 4. Contador de Vocales

**Enunciado:**
Crea una clase `VowelCounter` con un método `count($text)` que retorne un array con:
```php
[
    'total' => int,           // Total de vocales encontradas
    'vowels' => [             // Detalle por vocal
        'a' => int,
        'e' => int,
        'i' => int,
        'o' => int,
        'u' => int
    ]
]
```

**Requisitos:**
- Debe contar vocales tanto mayúsculas como minúsculas
- Debe ignorar acentos (á, é, í, ó, ú cuentan como a, e, i, o, u)
- No debe contar caracteres especiales ni números
- Si no hay vocales, retorna total 0 y todos los contadores en 0

**Ejemplos:**
- `"Hola Mundo"` → total: 4, a: 1, e: 0, i: 0, o: 2, u: 1
- `"Programación"` → total: 5, a: 2, e: 0, i: 1, o: 2, u: 0
- `"123!@#"` → total: 0, todas las vocales en 0

**Conceptos practicados:**
- Iteración de strings
- Conversión de caracteres (minúsculas)
- Arrays asociativos
- Contadores
- Normalización de texto

---

### 5. Analizador de Arrays

**Enunciado:**
Crea una clase `ArrayAnalyzer` con un método `analyze($numbers)` que reciba un array de números y retorne un array con estadísticas:
```php
[
    'sum' => float,        // Suma de todos los números
    'average' => float,    // Promedio (redondeado a 2 decimales)
    'min' => float,        // Valor mínimo
    'max' => float,        // Valor máximo
    'count' => int         // Cantidad de elementos
]
```

**Requisitos:**
- Si el array está vacío, lanza una excepción `InvalidArgumentException` con mensaje "Array cannot be empty"
- El promedio debe estar redondeado a 2 decimales
- Debe funcionar con números enteros y decimales
- Debe funcionar con números negativos

**Ejemplos:**
- `[1, 2, 3, 4, 5]` → sum: 15, average: 3.00, min: 1, max: 5, count: 5
- `[10]` → sum: 10, average: 10.00, min: 10, max: 10, count: 1
- `[-5, 0, 5]` → sum: 0, average: 0.00, min: -5, max: 5, count: 3
- `[]` → lanza excepción

**Conceptos practicados:**
- Iteración de arrays
- Funciones agregadas (sum, average, min, max)
- Manejo de excepciones
- Operaciones con arrays vacíos

---

## Recursos

- [Roadmap PHP](https://roadmap.sh/php)
- [PHPUnit Documentation](https://phpunit.de/)
- [PHP Documentation](https://www.php.net/docs.php)