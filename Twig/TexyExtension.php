<?php


namespace Edge\TexyBundle\Twig;

use Edge\TexyBundle\Processor\IProcessor;
use Twig_Extension;
use Twig_SimpleFilter;

/**
 * @author: Marek Makovec <marek.makovec@edgedesign.cz>
 */
class TexyExtension extends Twig_Extension
{
    /**
     * @var IProcessor
     */
    private $processor;

    public function __construct(IProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('texy_process', array($this, 'processTexy'),  array('is_safe' => array('html'))),
        );
    }

    public function getName()
    {
        return 'edge_texy_filter';
    }

    /**
     * Process given $text by text processor with given $id
     *
     * @param string $text
     * @param string $id
     * @return string
     */
    public function processTexy($text, $id='default')
    {
        return $this->processor->process($id, $text);
    }

}