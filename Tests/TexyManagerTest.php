<?php

namespace Edge\TexyBundle\Texy;

use Mockery as m;

class TexyManagerTest extends \PHPUnit_Framework_TestCase
{
    private $configurator;

    public function setUp()
    {
        $this->configurator = m::mock('Edge\TexyBundle\Texy\TexyConfigurator');
    }

    /** @expectedException \InvalidArgumentException */
    public function testShouldThrowExceptionWhenFilterIsNotDefined()
    {
        $manager = new TexyManager($this->configurator, array());
        $manager->getTexy('non-existent filter');
    }

    public function testShouldLoadFilterOnlyOnce()
    {
        $filter = 'irrelevant filter';
        $manager = new TexyManager($this->configurator, array($filter => array()));

        $this->configurator->shouldReceive('configure')->once();
        $manager->getTexy($filter);
        $manager->getTexy($filter);
        m::close();
    }
}
