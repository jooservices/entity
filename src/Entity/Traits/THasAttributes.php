<?php

namespace JOOservices\Entity\Traits;

use Illuminate\Support\Str;
use stdClass;

trait THasAttributes
{
    use THasSubEntity;
    use THasCasting;

    /**
     * Keys that have been loaded
     * @var array
     */
    protected array $loadedKeys = [];

    /**
     * Initialize entity data
     * @param mixed $oData
     */
    protected function initData(mixed $oData): void
    {
        $this->loadedKeys = [];
        $this->data = new stdClass();

        if ($oData === null) {
            $this->data = $this->loadFromNull();
        } elseif (is_array($oData)) {
            $this->data = $this->loadFromArray($oData);
        } elseif (is_object($oData)) {
            $this->data = $this->loadFromObject($oData);
        } else {
            $this->data = $oData;
        }
    }

    /**
     * Load from null value
     * @return stdClass
     */
    private function loadFromNull(): stdClass
    {
        return new stdClass();
    }

    /**
     * Load from array
     * @param array $oData
     * @return stdClass
     */
    private function loadFromArray(array $oData): stdClass
    {
        foreach ($oData as $key => $value) {
            $this->data->{$key} = $this->loadSubEntity($key, $value);
            $this->loadedKey($key);
        }

        return $this->data;
    }

    /**
     * Load from object
     * @param object $oData
     * @return stdClass
     */
    private function loadFromObject(object $oData): stdClass
    {
        $object = new \ReflectionObject($oData);
        $properties = $object->getProperties(
            \ReflectionProperty::IS_PRIVATE
            | \ReflectionProperty::IS_PROTECTED
            | \ReflectionProperty::IS_PUBLIC
        );

        foreach ($properties as $property) {
            $key = $property->getName();
            $value = $property->getValue($oData);

            $this->data->{$key} = $this->loadSubEntity($key, $value);
            $this->loadedKey($key);
        }

        return $this->data;
    }

    private function loadedKey(string $key, bool $success = true): void
    {
        $this->loadedKeys[$key] = $success;
    }

    public function getLoadedKeys(): array
    {
        return $this->loadedKeys;
    }

    public function isAttributeLoaded(string $name): bool
    {
        return isset($this->loadedKeys[$name]);
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function setData(mixed $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function get(string $name, mixed $default = null): mixed
    {
        $methodName = Str::studly($name);
        if (method_exists($this, $methodName)) {
            return $this->{$methodName}();
        }

        $methodName = 'get' . Str::studly($name) . 'Attribute';
        if (method_exists($this, $methodName)) {
            return $this->{$methodName}();
        }

        return $this->castAttribute($name, $this->data->{$name} ?? $default);
    }

    public function __get(string $name): mixed
    {
        return $this->get($name);
    }

    public function set(string $name, mixed $value): static
    {
        $methodName = 'set' . Str::studly($name) . 'Attribute';
        if (method_exists($this, $methodName)) {
            $value = $this->{$methodName}($value);
        }

        /**
         * Cast data back for saving
         */
        $this->data->{$name} = $value;

        return $this;
    }

    public function __set($name, mixed $value): void
    {
        $this->set($name, $value);
    }

    public function toArray(): array
    {
        return json_decode(json_encode($this->data), true);
    }

    public function toJson(): string
    {
        return json_encode($this->data);
    }
}
