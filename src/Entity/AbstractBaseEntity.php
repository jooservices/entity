<?php

namespace JOOservices\Entity\Entity;

use JOOservices\Entity\Exceptions\InvalidAttributesType;
use JOOservices\Entity\Interfaces\IEntity;
use JOOservices\Entity\Traits\THasAttributes;
use JsonException;
use stdClass;

abstract class AbstractBaseEntity implements IEntity
{
    use THasAttributes;

    protected array $loadedKeys = [];

    protected stdClass $attributes;

    protected function __construct(protected mixed $data)
    {
        $this->loadAttributes($data);

        if (method_exists($this, 'boot')) {
            $this->boot();
        }
    }

    /**
     * @throws JsonException
     */
    public static function transform(mixed $data): static
    {
        if (is_object($data)) {
            return new static($data);
        }

        if (is_array($data)) {
            return new static(
                json_decode(
                    json_encode($data, JSON_THROW_ON_ERROR),
                    false,
                    512,
                    JSON_THROW_ON_ERROR
                )
            );
        }

        throw new InvalidAttributesType(sprintf('Attributes must be an object or array, %s given.', gettype($data)));
    }

    public function getLoadedKeys(): array
    {
        return $this->loadedKeys;
    }

    public function isAttributeLoaded(string $name): bool
    {
        return isset($this->loadedKeys[$name]);
    }

    /**
     * Original data
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    protected function loadedKey(string $key, bool $success = true): void
    {
        $this->loadedKeys[$key] = $success;
    }
}
