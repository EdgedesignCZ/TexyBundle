<?php

namespace Edge\TexyBundle\Manager;

use Edge\TexyBundle\Configurator\TexyConfigurator;
use InvalidArgumentException;

class TexyManager
{
    private $initializedTexy;
    private $configurator;
    private $definitions;

    public function __construct(TexyConfigurator $c, array $definitions)
    {
        $this->configurator = $c;
        $this->definitions = $definitions;
        $this->initializedTexy = array();
    }

    /**
     * @param string $name
     * @return \Texy Returns Texy instance named $name
     * @throws \InvalidArgumentException
     */
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