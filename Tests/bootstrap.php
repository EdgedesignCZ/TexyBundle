<?php

require_once $_SERVER['SYMFONY'] . '/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Edge\TexyBundle' => realpath(__DIR__.'/../../..'),
    'Symfony'                     => $_SERVER['SYMFONY'],
));
$loader->registerPrefixes(array(
    'Twig_'        => $_SERVER['TWIG'],
));
$loader->register();
