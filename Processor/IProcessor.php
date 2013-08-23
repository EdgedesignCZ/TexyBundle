<?php


namespace Edge\TexyBundle\Processor;


/**
 * @author: Marek Makovec <marek.makovec@edgedesign.cz>
 */
interface IProcessor
{

    /**
     * Process given $text via instance of texy named $instanceId
     *
     * @param string $instanceId identifier of filter to use
     * @param string $text text to process
     * @return string
     */
    public function process($instanceId, $text);
}