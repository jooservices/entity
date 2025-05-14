<?php

namespace JOOservices\Entity\Traits;

use Carbon\Carbon;
use JOOservices\Entity\Interfaces\IEntity;
use ReflectionClass;

trait THasCasting
{
    protected array $casts = [];

    public function castAttribute(string $attribute, mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        /**
         * Cast to another Entity class
         */
        $castType = $this->getCastType($attribute);

        if (class_exists($castType)) {
            $class = new ReflectionClass($castType);
            if ($class->implementsInterface(IEntity::class)) {
                return $castType::transform($value);
            }
        }

        return match ($this->getCastType($attribute)) {
            'int', 'integer' => (int)$value,
            'real', 'float', 'double' => (float)$value,
            'string' => (string)$value,
            'bool', 'boolean' => (bool)$value,
            'date', 'datetime' => $this->asDateTime($value),
            default => $value,
        };
    }

    protected function getCastType(string $key)
    {
        return $this->casts[$key] ?? null;
    }

    protected function asDateTime($value): Carbon
    {
        return Carbon::createFromTimeString($value);
    }
}
