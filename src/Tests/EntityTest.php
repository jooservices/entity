<?php

namespace JOOservices\Entity\Tests;

use Carbon\Carbon;
use JOOservices\Entity\Entity\TestEntity;
use JOOservices\Entity\Exceptions\InvalidAttributesType;
use JsonException;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    /**
     * @throws JsonException
     */
    public function testTransformValid(): void
    {
        $entity = TestEntity::transform([
            'id' => 1,
            'name' => 'John Doe',
            'age' => '25',
            'type' => [
                'class' => 'test',
                'id' => 11,
            ],
            'entity' => [
                'id' => 12,
            ],
            'bod' => Carbon::now()->toDateTimeString(),
        ]);

        $this->assertIsObject($entity);
        $this->assertEquals('John Doe', $entity->name);
        $this->assertIsInt($entity->age);
        $this->assertEquals(25, $entity->age);
        $this->assertTrue($entity->hasAttributes('name'));

        $this->assertInstanceOf(TestEntity::class, $entity->entity);

        $this->assertTrue($entity->isAttributeLoaded('name'));
        $this->assertFalse($entity->isAttributeLoaded('hello'));

        $this->assertInstanceOf(Carbon::class, $entity->bod);
    }

    /**
     * @throws JsonException
     */
    public function testTransformInvalid(): void
    {
        $this->expectException(InvalidAttributesType::class);
        TestEntity::transform('');
    }
}
