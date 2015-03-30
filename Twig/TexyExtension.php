<?php

namespace Edge\TexyBundle\Twig;

use Twig_Extension;
use Twig_SimpleFilter;
use Edge\TexyBundle\Processor\TexyProcessor;

class TexyExtension extends Twig_Extension
{
    private $processor;

    public function __construct(TexyProcessor $p)
    {
        $this->processor = $p;
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('texy_process', array($this->processor, 'singleLineText'),  array('is_safe' => array('html'))),
            new Twig_SimpleFilter('texy_process_line', array($this->processor, 'multiLineText'),  array('is_safe' => array('html'))),
        );
    }

    public function getName()
    {
        return 'edge_texy_filter';
    }
}