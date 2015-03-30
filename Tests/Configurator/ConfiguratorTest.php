<?php

namespace Edge\TexyBundle\DependencyInjection;

class EdgeTexyBundleConfiguratorTest extends \PHPUnit_Framework_TestCase
{
    /** @dataProvider provideConfigs */
    public function testShouldNotDeepMergeOptions($configs, $expectedConfig)
    {
        $extension = new EdgeTexyExtension();
        $mergedConfigs = $extension->mergeConfigs($configs);
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
