<?php

namespace JOOservices\Entity\Traits;

trait THasSubEntity
{
    protected array $subEntities = [];

    protected function loadSubEntity(string $key, mixed $value)
    {
        if (!isset($this->subEntities[$key])) {
            return $value;
        }

        return new $this->subEntities[$key]($value);
    }
}