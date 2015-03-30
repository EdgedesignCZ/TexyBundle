<?php


namespace Edge\TexyBundle\Manager;
use Texy;


/**
 * @author: Marek Makovec <marek.makovec@edgedesign.cz>
 */
interface IManager
{
    /**
     * Returns Texy instance named $name
     * throws InstanceNotFoundException when there is no such instance
     *
     * @param string $name
     * @return Texy
     * @throws \Edge\TexyBundle\Exceptions\InstanceNotFoundException
     */
    public function getTexy($name);

    /**
     * Overrides all definitions given from constructor with newly defined definitions.
     *
     * @param array $definitions
     * @return void
     */
    public function setDefinitions(array $definitions);
}