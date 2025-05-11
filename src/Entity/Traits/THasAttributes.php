<?php

namespace JOOservices\Entity\Traits;

use Illuminate\Support\Str;
use stdClass;

trait THasAttributes
{
    use THasSubEntity;
    use THasCasting;

    protected array $loadedKeys = [];

    protected function initData($oData): void
    {
        $this->data = new stdClass();

        if (is_null($oData)) {
            return;
        }

        if (is_array($oData)) {
            $this->data = $this->loadFromArray($oData);
        }
    }

    private function loadFromArray($oData): stdClass
    {
        foreach ($oData as $key => $value) {
            $this->loadedKeys[$key] = true;
            $this->data->{$key} = $this->loadSubEntity($key, $value);
        }

        return $this->data;
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

    public function get(string $name, $default = null): mixed
    {
        $methodName = Str::studly($name);
        if (method_exists($this, $methodName)) {
            return $this->{$methodName}();
        }

        $methodName = 'get' . Str::studly($name) . 'Attribute';
        if (method_exists($this, $methodName)) {
            return $this->{$methodName}();
        }

        return  $this->castAttribute($name, $this->data->{$name} ?? $default);
    }

    public function __get($name): mixed
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