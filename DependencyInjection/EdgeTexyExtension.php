<?php

namespace Edge\TexyBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Texy;

class EdgeTexyExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');

        $config = $this->mergeConfigs($configs);

        if(array_key_exists('filters', $config)){
            $managerDefinition = $container->getDefinition('edge_texy.manager');
            $managerDefinition->addMethodCall('setDefinitions', array($config['filters']));
        }
    }

    /**
     * Method for merging several configuration arrays.
     * It should merge several arrays of this structure A into one structure B
     *
     * Structure A examples:
     * <code>
     *     firstConfig:
     *        attributeSettings:
     *            bar: baz
     *            xizzy: zixxy
     *         filters:
     *             someFilter:
     *                 settings:
     *                     b: [span, id]
     *                     p: [class, id]
     *
     *     secondConfig:
     *        attributeSettings:
     *            asd: dsa
     *            zixxy: xizzy
     *         filters:
     *             someOtherFilter:
     *                 settings:
     *                     b: [span, id]
     *                     p: [class, id]
     * </code>
     *
     * Result structure example:
     * <code>
     *     config:
     *        attributeSettings:
     *            asd: dsa
     *            bar: baz
     *            xizzy: zixxy
     *            zixxy: xizzy
     *
     *         filters:
     *             someFilter:
     *                 settings:
     *                     b: [span, id]
     *                     p: [class, id]
     *
     *             someOtherFilter:
     *                 settings:
     *                     b: [span, id]
     *                     p: [class, id]
     * </code>
     *
     * @param array $configs
     *
     * @return array
     */
    public function mergeConfigs(array $configs)
    {
        $config = array();
        foreach ($configs as $cnf) {
            foreach ($cnf as $sectionName => $parameters) {
                $currentValues = (isset($config[$sectionName])) ? $config[$sectionName] : array();
                $config[$sectionName] = array_merge($currentValues, $parameters);
            }
        }

        return $config;
    }
}
