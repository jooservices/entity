<?php

namespace JOOservices\Entity;

use JOOservices\Entity\Traits\THasAttributes;

abstract class AbstractBaseEntity
{
    use THasAttributes;

    protected mixed $data;

    public function __construct(protected $oData = null)
    {
        $this->initData($this->oData);
    }
}
