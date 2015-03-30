<?php

namespace Edge\TexyBundle\Manager;

use Edge\TexyBundle\Configurator\IConfigurator;
use InvalidArgumentException;
use Texy;

class TexyManager implements IManager{

    private $instances;

    private $configurator;

    private $definitions;

    public function __construct(IConfigurator $configurator, array $definitions)
    {
        $this->configurator = $configurator;
        $this->definitions = $definitions;
        $this->instances = array();
    }


    /**
     * Retrieve Texy instance named $name
     * throws InstanceNotFoundException when there is no such instance
     *
     * @param string $name
     * @return Texy
     * @throws \Edge\TexyBundle\Exceptions\InstanceNotFoundException
     */
    public function getTexy($name = 'default')
    {
        if(array_key_exists($name, $this->instances)){

            return $this->instances[$name];
        } else if (array_key_exists($name, $this->definitions)){
            $this->instances[$name] = $this->configurator->configure($this->definitions[$name]);

            return $this->instances[$name];
        }
        $this->unknownFilter($name);
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