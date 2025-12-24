# PHP - Ejercicios de Práctica

Proyecto de ejercicios para practicar fundamentos de PHP siguiendo el roadmap de [roadmap.sh/php](https://roadmap.sh/php).

## 🎯 Objetivo

Practicar conceptos básicos de PHP:
- Funciones
- Condicionales
- Ciclos
- TDD con PHPUnit

## 🛠️ Requisitos

- PHP 8.2+
- Composer
- PHPUnit 11

## 📦 Instalación
```bash
composer install
```

## 🧪 Ejecutar tests
```bash
# Todos los tests
./vendor/bin/phpunit

# Un test específico
./vendor/bin/phpunit tests/FizzBuzzTest.php
```

## 📝 Tabla de Ejercicios

| # | Ejercicio | Conceptos | Estado |
|---|-----------|-----------|--------|
| 1 | [FizzBuzz](#1-fizzbuzz) | Ciclos, condicionales | ✅ |
| 2 | [Validador de Contraseñas](#2-validador-de-contraseñas) | Funciones, strings, condicionales | 🔄 |
| 3 | Calculadora de IMC | Funciones, condicionales | ⏳ |
| 4 | Contador de Vocales | Ciclos, strings | ⏳ |
| 5 | Generador de Tabla de Multiplicar | Ciclos anidados, arrays | ⏳ |

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
Crea una clase `PasswordValidator` con un método `validate($password)` que retorne `true` si la contraseña cumple:
- Mínimo 8 caracteres
- Al menos una letra mayúscula
- Al menos una letra minúscula
- Al menos un número
- Al menos un carácter especial (!@#$%^&*)

El método debe retornar un array con:
```php
[
    'valid' => bool,
    'errors' => array // array de strings con los errores encontrados
]
```

**Conceptos practicados:**
- Validación de strings
- Expresiones regulares
- Arrays
- Funciones de string (strlen, preg_match)

---

## 📚 Recursos

- [Roadmap PHP](https://roadmap.sh/php)
- [PHPUnit Documentation](https://phpunit.de/)
- [PHP Documentation](https://www.php.net/docs.php)