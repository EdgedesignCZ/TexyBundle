<?php

namespace Edge\TexyBundle\Twig;

use Mockery as m;

class TexyTwigFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCallProcessor()
    {
        $processor = m::mock('Edge\TexyBundle\Processor\TexyProcessor');
        $filter = new TexyExtension($processor);
        foreach ($filter->getFilters() as $filter) {
            $callable = $filter->getCallable();
            $this->assertSame($processor, $callable[0]);
            $this->assertContains('LineText', $callable[1]);
        }
    }
}
