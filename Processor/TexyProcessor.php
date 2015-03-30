<?php

namespace Edge\TexyBundle\Processor;

use Edge\TexyBundle\Manager\TexyManager;

class TexyProcessor
{
    private $manager;

    public function __construct(TexyManager $m)
    {
        $this->manager = $m;
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