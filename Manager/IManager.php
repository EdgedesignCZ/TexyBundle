<?php

namespace Edge\TexyBundle\Manager;

use Texy;

interface IManager
{
    /**
     * @param string $name
     * @return Texy Returns Texy instance named $name
     * @throws \InvalidArgumentException
     */
    public function getTexy($name);
}