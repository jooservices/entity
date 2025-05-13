<?php

namespace JOOservices\Entity\Traits;

use Illuminate\Support\Str;
use JOOservices\Entity\Exceptions\InvalidAttributesType;
use ReflectionObject;
use ReflectionProperty;
use stdClass;

trait THasAttributes
{
    use THasCasting;

    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    public function getAttribute(string $name, string|null $default = null): mixed
    {

        return $this->castAttribute($name, $this->getRawAttribute($name, $default));
    }

    public function getRawAttribute(string $name, string|null $default = null): mixed
    {
        if (!is_object($this->attributes)) {
            throw new InvalidAttributesType(
                sprintf('Attributes must be an object, %s given.', gettype($this->attributes))
            );
        }

        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        $method = 'get' . Str::studly($name);
        if (method_exists($this, $method)) {
            return $this->{$method}($default);
        }

        $method = 'get' . Str::studly($name) . 'Attribute';
        if (method_exists($this, $method)) {
            return $this->{$method}($default);
        }

        return $this->attributes->{$name} ?? $default;
    }

    public function setAttribute(string $name, mixed $value): self
    {
        $this->attributes->{$name} = $value;

        $this->loadedKey($name);

        return $this;
    }

    public function __isset($name)
    {
        return $this->hasAttributes($name);
    }

    public function hasAttributes(string $name): bool
    {
        return isset($this->attributes->{$name});
    }

    public function __unset($name)
    {
        $this->unset($name);
    }

    public function unset($name): void
    {
        unset($this->attributes->{$name});

        $this->loadedKey($name, false);
    }

    /**
     * Generated attributes from data
     * @return stdClass
     */
    public function getAttributes(): stdClass
    {
        return $this->attributes;
    }

    protected function loadAttributes(mixed $oData): void
    {
        $this->attributes = new stdClass();
        $object = new ReflectionObject($oData);
        $properties = $object->getProperties(
            ReflectionProperty::IS_PRIVATE
            | ReflectionProperty::IS_PROTECTED
            | ReflectionProperty::IS_PUBLIC
        );

        foreach ($properties as $property) {
            $key = $property->getName();
            $value = $property->getValue($oData);

            $this->attributes->{$key} = $value;
            $this->loadedKey($key);
        }
    }
}
