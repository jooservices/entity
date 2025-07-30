# JOOservices Entity Library

This library provides a flexible base for working with entities in PHP applications. It includes abstract base classes and traits for attribute management, casting, and sub-entity handling.

## Features
- Abstract base entity class for easy extension
- Attribute management via traits
- Data casting and sub-entity support
- Integration with Laravel's Illuminate components

## Installation

1. Clone the repository:
   ```bash
   git clone <your-repo-url>
   ```
2. Install dependencies using Composer:
   ```bash
   composer install
   ```

## Usage

### Creating an Entity
Extend `AbstractBaseEntity` or `BaseEntity` to create your own entity:

```php
use JOOservices\Entity\BaseEntity;

class UserEntity extends BaseEntity {
    // Define your custom logic or attributes
}
```

### Working with Attributes
Entities support dynamic attribute access and casting:

```php
$user = new UserEntity(['name' => 'John', 'age' => 30]);
echo $user->name; // John
$user->age = 31;
```

### Converting to Array/JSON
```php
$array = $user->toArray();
$json = $user->toJson();
```

## Testing

Run tests using PHPUnit:
```bash
vendor/bin/phpunit
```

## Folder Structure
- `src/Entity/` - Core entity classes and traits
- `tests/` - Unit tests
- `vendor/` - Composer dependencies

## Contributing
Pull requests and issues are welcome. Please follow PSR standards and write tests for new features.

## License
MIT

