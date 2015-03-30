<?php


namespace Edge\TexyBundle\Processor;
use Edge\TexyBundle\Manager\IManager;

class TexyProcessor
{
    private $manager;

    public function __construct(IManager $manager)
    {
        $this->manager = $manager;
    }

    public function singleLineText($text, $filter = 'default')
    {
        return $this->process($text, $filter, false);
    }

    public function multiLineText($text, $filter = 'default')
    {
        return $this->process($text, $filter, true);
    }

    private function process($text, $filter, $mode)
    {
        return $this->manager->getTexy($filter)->process($text, $mode);
    }
}