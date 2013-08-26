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

    public function mergeConfigs(array $configs)
    {
        $config = array();

        foreach ($configs as $cnf) {
            $config = array_merge($config, $cnf);
        }

        return $config;
    }
}
