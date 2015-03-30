<?php

namespace Edge\TexyBundle\Manager;

use Edge\TexyBundle\Configurator\IConfigurator;
use Edge\TexyBundle\Exceptions\InstanceNotFoundException;
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


        throw new InstanceNotFoundException('Filter called "'.$name.'" does not exists. Known filter names are: ' .
                implode(',', array_keys($this->definitions))
            );
    }

    /**
     * Overrides all definitions given from constructor with newly defined definitions.
     *
     * @param array $definitions
     * @return void
     */
    public function setDefinitions(array $definitions)
    {
        $this->definitions = $definitions;
        $this->instances = array();
    }
}