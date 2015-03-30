<?php

namespace Edge\TexyBundle\Processor;

use Mockery as m;

class TexyProcessorTest extends \PHPUnit_Framework_TestCase
{
    /** @dataProvider provideModes */
    public function testShouldSelectTexyMode($processMethod, $expectedTexyMode)
    {
        $texy = m::mock('Texy');
        $texy->shouldReceive('process')->once()->with(m::any(), $expectedTexyMode);

        $manager = m::mock('Edge\TexyBundle\Manager\TexyManager');
        $manager->shouldReceive('getTexy')->once()->andReturn($texy);

        $processor = new TexyProcessor($manager);
        $processor->$processMethod('irrelevant text');
        m::close();
    }

    public function provideModes()
    {
        return array(
            array('singleLineText', false),
            array('multiLineText', true),
        );
    }
}
