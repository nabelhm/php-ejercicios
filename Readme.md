# PHP - Ejercicios de Práctica

Proyecto de ejercicios para practicar fundamentos de PHP siguiendo el roadmap de [roadmap.sh/php](https://roadmap.sh/php).

## Objetivo

Practicar conceptos de PHP desde fundamentos hasta arquitectura avanzada:
- Fundamentos (completado): Funciones, condicionales, ciclos
- OOP (en progreso): Interfaces, traits, abstract classes, SOLID, dependency injection
- Arquitectura avanzada (próximamente): DDD, Hexagonal, CQRS en Symfony

## Requisitos

- PHP 8.2+
- Composer
- PHPUnit 11
- Xdebug (opcional, para coverage)

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

# Con coverage
./vendor/bin/phpunit --coverage-html coverage
```

## Tabla de Ejercicios

### Fundamentos

| # | Ejercicio | Conceptos | Estado |
|---|-----------|-----------|--------|
| 1 | [FizzBuzz](#1-fizzbuzz) | Ciclos, condicionales | Completado |
| 2 | [Validador de Contraseñas](#2-validador-de-contraseñas) | Funciones, strings, condicionales | Completado |
| 3 | [Calculadora de IMC](#3-calculadora-de-imc) | Funciones, condicionales, aritmética | Completado |
| 4 | [Contador de Vocales](#4-contador-de-vocales) | Ciclos, strings, arrays | Completado |
| 5 | [Analizador de Arrays](#5-analizador-de-arrays) | Ciclos, arrays, funciones | Completado |

### Programación Orientada a Objetos

| # | Ejercicio | Conceptos | Estado |
|---|-----------|-----------|--------|
| 6 | [Money Value Object](#6-money-value-object) | Value Objects, Enums, Readonly properties, Immutability | Completado |
| 7 | [State Machine con Enums](#7-state-machine-con-enums) | Enums, Immutability, Exceptions | Completado |
| 8 | [Event Dispatcher](#8-event-dispatcher) | Interfaces, Dependency Injection, Observer Pattern | Completado |
| 9 | [Validation Pipeline](#9-validation-pipeline) | Traits, Fluent Interface, Decorator Pattern | Completado |
| 10 | [Repository Pattern con Caching](#10-repository-pattern-con-caching) | Abstract Classes, Traits, Attributes, Decorator Pattern | Pendiente |
| 11 | [Logger con Decorators](#11-logger-con-decorators) | Interfaces, Enums, Namespaces, Decorator Pattern | Pendiente |

---

## Ejercicios de Fundamentos

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

---

## Ejercicios de Programación Orientada a Objetos

### 6. Money Value Object

**Enunciado:**
Implementa un Value Object inmutable para manejar dinero con diferentes monedas.

**Requisitos:**
- Readonly properties con constructor promotion (PHP 8.1+)
- Backed Enum `Currency` con valores: USD, EUR, GBP
- Métodos inmutables que retornan nueva instancia: `add()`, `subtract()`, `multiply()`, `divide()`
- Magic method `__toString()` con formato: "100.50 EUR"
- Validación: no permitir operaciones entre diferentes monedas (lanzar exception)
- Método estático `fromString("100.50 EUR")` para parsear strings
- Métodos de comparación: `equals()`, `greaterThan()`, `lessThan()`

**Reglas de negocio:**
- Amount debe ser siempre >= 0
- Operaciones retornan nueva instancia (immutability)
- División por cero lanza exception
- Comparaciones solo entre misma moneda

**Namespace:** `Ejercicios\OOP\Money`

**Conceptos practicados:**
- Value Objects
- Backed Enums (PHP 8.1)
- Readonly properties
- Constructor promotion
- Immutability
- Static factory methods
- Magic methods
- Exception handling

---

### 7. State Machine con Enums

**Enunciado:**
Implementa una máquina de estados para un pedido (Order) que transiciona entre estados: Pending → Confirmed → Shipped → Delivered.

**Requisitos:**
- Backed Enum `OrderStatus` (string backed) con valores: PENDING, CONFIRMED, SHIPPED, DELIVERED
- Método en enum: `canTransitionTo(OrderStatus $status): bool` usando match expression
- Class `Order` con readonly property `OrderStatus $status`
- Métodos inmutables que retornan nueva instancia: `confirm()`, `ship()`, `deliver()`
- Método `cancel()` que solo funciona desde PENDING o CONFIRMED
- Exception personalizada `InvalidStateTransitionException`
- Readonly property `id` (string UUID o similar)
- Readonly property `createdAt` (DateTimeImmutable)

**Transiciones válidas:**
- PENDING → CONFIRMED, CANCELLED
- CONFIRMED → SHIPPED, CANCELLED
- SHIPPED → DELIVERED
- DELIVERED → (estado final, no transiciona)
- CANCELLED → (estado final, no transiciona)

**Namespace:** `Ejercicios\OOP\Order`

**Conceptos practicados:**
- Backed Enums
- Enum methods
- Match expressions
- Immutability
- Custom exceptions
- State pattern
- Value Objects (Order como entidad inmutable)

---

### 8. Event Dispatcher

**Enunciado:**
Implementa un sistema de eventos con múltiples listeners usando Observer pattern.

**Requisitos:**
- Interface `EventInterface` con método `getName(): string`
- Interface `ListenerInterface` con método `handle(EventInterface $event): void`
- Class `EventDispatcher` que almacena listeners por evento
- Método `subscribe(string $eventName, ListenerInterface $listener): void`
- Método `dispatch(EventInterface $event): void` ejecuta todos los listeners del evento
- Listeners se ejecutan en el orden en que fueron suscritos
- Un evento puede tener múltiples listeners
- Type hints estrictos con `declare(strict_types=1)`

**Ejemplo de uso:**
```php
  $dispatcher = new EventDispatcher();
  $dispatcher->subscribe('user.created', new EmailListener());
  $dispatcher->subscribe('user.created', new LogListener());
  $dispatcher->dispatch(new UserCreatedEvent($user));
```

**Namespace:** 
- `Ejercicios\OOP\Events\EventInterface`
- `Ejercicios\OOP\Events\Listener\ListenerInterface`
- `Ejercicios\OOP\Events\EventDispatcher`

**Conceptos practicados:**
- Interfaces
- Observer pattern
- Dependency injection
- Type declarations
- Namespaces
- SOLID (Single Responsibility, Open/Closed)

---

### 9. Validation Pipeline

**Enunciado:**
Implementa un sistema de validación componible con fluent interface.

**Requisitos:**
- Interface `ValidatorInterface` con método `validate(mixed $value): bool` y `getError(): string`
- Trait `ValidatorChain` para encadenar validaciones
- Validators concretos: 
  - `EmailValidator`: valida formato email
  - `LengthValidator`: valida longitud min/max
  - `RegexValidator`: valida contra regex personalizado
- Class `ValidationPipeline` que usa el trait
- Fluent interface: `$pipeline->add($validator)->add($validator)->validate($data)`
- Class `ValidationResult` con métodos `isValid(): bool` y `getErrors(): array`
- El pipeline debe detenerse en el primer error o validar todos (configurable)

**Ejemplo de uso:**
```php
  $pipeline = new ValidationPipeline();
  $result = $pipeline
      ->add(new LengthValidator(min: 8))
      ->add(new EmailValidator())
      ->validate('test@example.com');

  if (!$result->isValid()) {
      var_dump($result->getErrors());
  }
```

**Namespace:** `Ejercicios\OOP\Validation`

**Conceptos practicados:**
- Interfaces
- Traits
- Fluent interface (method chaining)
- Named parameters (PHP 8.0)
- Composite pattern
- Strategy pattern

---

### 10. Repository Pattern con Caching

**Enunciado:**
Implementa el patrón Repository con una implementación en memoria y un decorador de caché.

**Requisitos:**
- Interface `RepositoryInterface` con métodos:
  - `find(string $id): ?object`
  - `save(object $entity): void`
  - `delete(string $id): void`
  - `findAll(): array`
- Abstract class `AbstractRepository` con lógica común (generación de IDs, etc.)
- Concrete class `InMemoryRepository` que extiende AbstractRepository (almacena en array)
- Trait `Timestampable` con properties `createdAt` y `updatedAt` (DateTimeImmutable)
- Class `CachedRepository` que implementa `RepositoryInterface` y decora cualquier repository
- Custom attribute `#[Entity]` para marcar clases persistibles
- Constructor promotion + readonly donde sea apropiado

**Ejemplo de uso:**
```php
$baseRepo = new InMemoryRepository();
$cachedRepo = new CachedRepository($baseRepo, ttl: 60);

$cachedRepo->save($user); // Guarda en repo base y cachea
$user = $cachedRepo->find($id); // Primera vez: lee de repo base, cachea
$user = $cachedRepo->find($id); // Segunda vez: lee de caché
```

**Namespace:** `Ejercicios\OOP\Repository`

**Conceptos practicados:**
- Interfaces
- Abstract classes
- Traits
- Decorator pattern
- Dependency injection
- Attributes (PHP 8.0)
- Constructor promotion
- Repository pattern

---

### 11. Logger con Decorators

**Enunciado:**
Implementa un sistema de logging con múltiples handlers y decoradores (inspirado en PSR-3 simplificado).

**Requisitos:**
- Interface `LoggerInterface` con métodos:
  - `log(LogLevel $level, string $message, array $context = []): void`
  - Métodos de conveniencia: `debug()`, `info()`, `warning()`, `error()`
- Backed Enum `LogLevel` con valores: DEBUG, INFO, WARNING, ERROR
- Método estático en enum: `LogLevel::fromString(string $level): self`
- Implementations concretas:
  - `FileLogger`: escribe a archivo
  - `ConsoleLogger`: escribe a STDOUT
  - `NullLogger`: no hace nada (útil para tests)
- Decorators:
  - `TimestampedLogger`: añade timestamp a cada mensaje
  - `FilteredLogger`: solo loguea niveles >= nivel mínimo configurado
- Cada logger puede decorar otro (composition)
- Constructor injection de dependencias

**Ejemplo de uso:**
```php
$baseLogger = new FileLogger('/tmp/app.log');
$timestamped = new TimestampedLogger($baseLogger);
$filtered = new FilteredLogger($timestamped, minLevel: LogLevel::WARNING);

$filtered->debug('This will not be logged');
$filtered->error('This will be logged with timestamp');
```

**Namespace:** 
- `Ejercicios\OOP\Logger\LoggerInterface`
- `Ejercicios\OOP\Logger\LogLevel`
- `Ejercicios\OOP\Logger\Handler\*` (FileLogger, ConsoleLogger, NullLogger)
- `Ejercicios\OOP\Logger\Decorator\*` (TimestampedLogger, FilteredLogger)

**Conceptos practicados:**
- Interfaces
- Backed Enums
- Static factory methods
- Decorator pattern
- Dependency injection
- Namespaces organizados
- Composition over inheritance

---

## Recursos

- [Roadmap PHP](https://roadmap.sh/php)
- [PHPUnit Documentation](https://phpunit.de/)
- [PHP Documentation](https://www.php.net/docs.php)