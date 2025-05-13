<?php

namespace JOOservices\Entity\Entity;

use Carbon\Carbon;

/**
 * @property  int $id
 * @property string $name
 * @property int $age
 * @property TestEntity $entity
 * @property Carbon $bod
 */
class TestEntity extends AbstractBaseEntity
{
    protected array $casts = [
        'id' => 'int',
        'name' => 'string',
        'age' => 'int',
        'entity' => self::class,
        'bod' => 'datetime',
    ];
}
