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
/*
        $configurator = $container->getDefinition('edge_texy_bundle.class.configurator');
        $configurator->addArgument($container->getParameter('edge_texy_bundle.class.texy'));
        $manager = $container->getDefinition('edge_texy_bundle.class.manager');
        $manager->addArgument($container->getParameter('texy_instances'));
*/
    }
}
