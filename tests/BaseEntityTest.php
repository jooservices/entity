<?php

namespace Tests;

use Carbon\Carbon;
use JOOservices\Entity\BaseEntity;
use JOOservices\Entity\TestEntity;

class BaseEntityTest extends TestCase
{
    public function testEntity(): void
    {
        $keyValue = $this->faker->word;
        $entity = new TestEntity(['key' => $keyValue,]);

        $this->assertEquals($keyValue, $entity->key);
        $this->assertArrayHasKey('key', $entity->getLoadedKeys());
        $this->assertTrue($entity->isAttributeLoaded('key'));
        $this->assertFalse($entity->isAttributeLoaded('fake'));
    }

    public function testEntityWithSub(): void
    {
        $keyValue = $this->faker->word;
        $entity = new TestEntity([
            'key' => $keyValue,
            'subEntity' => [
                'hello' => 'world'
            ]
        ]);

        $this->assertInstanceOf(BaseEntity::class, $entity->subEntity);
        $this->assertEquals('world', $entity->subEntity->hello);
    }

    public function testCasting(): void
    {
        $keyValue = $this->faker->word;
        $entity = new TestEntity([
            'key' => $keyValue,
            'subEntity' => [
                'hello' => 'world'
            ],
            'createdAt' => Carbon::now()->toString()
        ]);

        $this->assertInstanceOf(Carbon::class, $entity->createdAt);
        $this->assertEquals($keyValue, $entity->key);
    }
}