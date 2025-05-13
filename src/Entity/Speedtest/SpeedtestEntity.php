<?php

namespace JOOservices\Entity\Entity\Speedtest;

use JOOservices\Entity\Entity\AbstractBaseEntity;

class SpeedtestEntity extends AbstractBaseEntity
{
    protected array $casts = [
        'ping' => PingEntity::class,
        'download' => DownloadEntity::class,
        'upload' => UploadEntity::class,
        'interface' => InterfaceEntity::class,
        'server' => ServerEntity::class,
        'result' => ResultEntity::class,
    ];
}
