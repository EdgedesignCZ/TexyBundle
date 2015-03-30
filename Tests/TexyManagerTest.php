<?php

namespace Edge\TexyBundle\Manager;

use Mockery as m;

class TexyManagerTest extends \PHPUnit_Framework_TestCase
{
    private $configurator;

    public function setUp()
    {
        $this->configurator = m::mock('Edge\TexyBundle\Configurator\TexyConfigurator');
    }

    /** @expectedException \InvalidArgumentException */
    public function testShouldThrowExceptionWhenFilterIsNotDefined()
    {
        $manager = new TexyManager($this->configurator, array());
        $manager->getTexy('non-existent filter');
    }
}
