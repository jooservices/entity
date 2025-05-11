<?php

namespace JOOservices\Entity;

class TestEntity extends AbstractBaseEntity
{
    protected array $subEntities = [
        'subEntity' => BaseEntity::class
    ];

    protected array $casts = [
        'createdAt' => 'datetime'
    ];
}