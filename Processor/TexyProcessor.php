<?php


namespace Edge\TexyBundle\Processor;
use Edge\TexyBundle\Manager\IManager;

/**
 * @author: Marek Makovec <marek.makovec@edgedesign.cz>
 */
class TexyProcessor implements IProcessor
{
    /**
     * @var IManager
     */
    private $manager;


    function __construct(IManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Process given $text via instance of texy named $instanceId
     *
     * @param $instanceId
     * @param $text
     * @return string
     */
    public function process($instanceId, $text, $mode)
    {
        return $this->manager->getTexy($instanceId)->process($text, $mode);
    }

}