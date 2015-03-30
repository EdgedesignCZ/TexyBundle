<?php

namespace Edge\TexyBundle\DependencyInjection;

use Mockery as m;

class EdgeTexyExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $extension;

    public function setUp()
    {
        $this->extension = new EdgeTexyExtension();
    }

    public function testShouldLoadTexyManager()
    {
        $container = m::mock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $container->shouldReceive('setParameter')->once()->with('edge_texy.filters', 'irrelevant filter');
        $container->shouldReceive('setParameter')->once()->with('edge_texy.custom_attributes', 'irrelevant attributes');

        $config = array(
            'filters' => 'irrelevant filter',
            'custom_attributes' => 'irrelevant attributes'
        );
        $this->extension->loadManager($config, $container);
        m::close();
    }

    /** @dataProvider provideConfigs */
    public function testShouldMergeConfigurations($configs, $expectedConfig)
    {
        $mergedConfigs = $this->extension->mergeConfigs($configs);
        $this->assertEquals($mergedConfigs, $expectedConfig);
    }

    public function provideConfigs()
    {
        return array(
            'should not deep merge options' => array(
                array(
                    array(
                        'default' => array(
                            'Core.HiddenElements' => array('script' => true),
                            'Cache.SerializerPath' => null,
                        )
                    ),
                    array(
                        'default' => array(
                            'Core.HiddenElements' => array('style' => true),
                        )
                    )
                ),
                array(
                    'default' => array(
                        'Core.HiddenElements' => array('style' => true),
                        'Cache.SerializerPath' => null
                    )
                )
            ),
            'should load custom configuration' => array(
                array(
                    array(
                        'simple' => array(
                            'customConfig' => true,
                            'AutoFormat.RemoveEmpty.RemoveNbsp' => true
                        ),
                    )
                ),
                array(
                    'simple' => array(
                        'customConfig' => true,
                        'AutoFormat.RemoveEmpty.RemoveNbsp' => true
                    )
                )
            )
        );
    }
}
