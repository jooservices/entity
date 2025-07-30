<?php

namespace JOOservices\Entity\Traits;

use Carbon\Carbon;

trait THasCasting
{
    protected array $casts = [];

    protected function getCastType(string $key): ?string
    {
        return $this->casts[$key] ?? null;
    }

    protected function castAttribute(string $key, mixed $value): mixed
    {
        if (is_null($value)) {
            return null;
        }

        return match ($this->getCastType($key)) {
            'int', 'integer' => (int)$value,
            'real', 'float', 'double' => (float)$value,
            'string' => (string)$value,
            'bool', 'boolean' => (bool)$value,
            'date', 'datetime' => $this->asDataTime($value),
            default => $value,
        };
    }

    protected function asDataTime($value): Carbon
    {
        return Carbon::createFromTimeString($value);
    }
}