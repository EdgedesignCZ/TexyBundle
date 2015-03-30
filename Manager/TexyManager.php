<?php

namespace Edge\TexyBundle\Manager;

use Edge\TexyBundle\Configurator\IConfigurator;
use InvalidArgumentException;

class TexyManager implements IManager
{
    private $initializedTexy;
    private $configurator;
    private $definitions;

    public function __construct(IConfigurator $configurator, array $definitions)
    {
        $this->configurator = $configurator;
        $this->definitions = $definitions;
        $this->initializedTexy = array();
    }

    public function getTexy($name = 'default')
    {
        if (array_key_exists($name, $this->definitions)){
            if (!array_key_exists($name, $this->initializedTexy)) {
                $this->initializedTexy[$name] = $this->configurator->configure($this->definitions[$name]);
            }
            return $this->initializedTexy[$name];
        } else {
            $this->unknownFilter($name);
        }
    }

    private function unknownFilter($name)
    {
        $message = sprintf(
            "Filter called '%s' does not exists. Known filter names are: %s",
            $name,
            implode(',', array_keys($this->definitions))
        );
        throw new InvalidArgumentException($message);
    }
}