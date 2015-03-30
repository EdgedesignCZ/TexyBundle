<?php

namespace Edge\TexyBundle\Texy;

use Twig_Extension;
use Twig_SimpleFilter;

class TexyTwigFilter extends Twig_Extension
{
    private $processor;

    public function __construct(TexyProcessor $p)
    {
        $this->processor = $p;
    }

    public function getFilters()
    {
        return array(
            $this->filter('texy_process', 'singleLineText'),
            $this->filter('texy_process_line', 'multiLineText'),
        );
    }

    private function filter($name, $method)
    {
        return new Twig_SimpleFilter($name, array($this->processor, $method), array('is_safe' => array('html')));
    }

    public function getName()
    {
        return 'edge_texy_filter';
    }
}
