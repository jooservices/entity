<?php

namespace JOOservices\Entity;

use JOOservices\Entity\Traits\THasAttributes;

/**
 * Class AbstractBaseEntity
 * @package JOOservices\Entity
 */
abstract class AbstractBaseEntity
{
    use THasAttributes;

    /**
     * Processed data for the entity.
     * @var mixed
     */
    private mixed $data;

    /**
     * AbstractBaseEntity constructor.
     * @param mixed|null $oData
     */
    public function __construct(protected mixed $oData = null)
    {
        $this->initData($this->oData);
    }
}
