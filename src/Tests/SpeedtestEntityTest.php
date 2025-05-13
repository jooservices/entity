<?php

namespace JOOservices\Entity\Tests;

use JOOservices\Entity\Entity\Speedtest\DownloadEntity;
use JOOservices\Entity\Entity\Speedtest\LatencyEntity;
use JOOservices\Entity\Entity\Speedtest\PingEntity;
use JOOservices\Entity\Entity\Speedtest\SpeedtestEntity;
use JOOservices\Entity\Entity\Speedtest\UploadEntity;
use JOOservices\Entity\Entity\TestEntity;
use JOOservices\Entity\Exceptions\InvalidAttributesType;
use JsonException;
use PHPUnit\Framework\TestCase;

class SpeedtestEntityTest extends TestCase
{
    /**
     * @throws JsonException
     */
    public function testTransformValid(): void
    {
        $entity = SpeedtestEntity::transform(
            json_decode(
                file_get_contents('./speedtest.json'),
                false, 512,
                JSON_THROW_ON_ERROR
            )
        );

        $this->assertInstanceOf(SpeedtestEntity::class, $entity);
        $this->assertInstanceOf(PingEntity::class, $entity->ping);
        $this->assertInstanceOf(DownloadEntity::class, $entity->download);
        $this->assertInstanceOf(LatencyEntity::class, $entity->download->latency);
        $this->assertInstanceOf(UploadEntity::class, $entity->upload);
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
