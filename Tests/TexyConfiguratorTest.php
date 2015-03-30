<?php

namespace Edge\TexyBundle\Texy;

class TexyConfiguratorTest extends \PHPUnit_Framework_TestCase
{
    private $attribute = 'my-custom-attribute';
    private $texy;
    private $config;

    public function setUp()
    {
        $this->texy = new \Texy();
        $this->config = new TexyConfigurator('irrelevant class', array(500 => $this->attribute));
    }

    public function testShouldAddCustomAttributeToEveryElement()
    {
        $this->config->addCustomAttributes($this->texy);
        $linkDtd = $this->getElementAttributtes('a');
        $this->assertArrayHasKey($this->attribute, $linkDtd);
        $this->assertSame(1, $linkDtd[$this->attribute]);
    }

    private function getElementAttributtes($element)
    {
        return $this->texy->dtd[$element][0];
    }
}
