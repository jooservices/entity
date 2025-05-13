<?php

namespace JOOservices\Entity\Entity\Speedtest\Traits;

use JOOservices\Entity\Entity\Speedtest\LatencyEntity;

trait THasBandwidth
{
    protected function boot(): void
    {
        $this->casts = array_merge(
            $this->casts,
            [
                'bandwidth' => 'int',
                'bytes' => 'int',
                'elapsed' => 'int',
                'latency' => LatencyEntity::class
            ]
        );
    }
}
