<?php

namespace Edge\TexyBundle\Texy;

use Texy;

class TexyConfigurator
{
    /** @var string stores name of Texy class */
    private $texyClassName;
    private $customAttributes = array();

    public function __construct($texyClassName, array $customAttributes)
    {
        $this->texyClassName = $texyClassName;
        foreach ($customAttributes as $name) {
            $this->customAttributes[$name] = 1;
        }
    }

    /**
     * Function, that receives data from user config and returns fully configured Texy
     * @param  array $parameters
     * @return Texy
     */
    public function configure(array $parameters)
    {
        if (array_key_exists('class', $parameters)) {
            $texy = new $parameters['class']();
            if (!$texy instanceof Texy) {
                $error = "Specified class {$parameters['class']} is not instance of Texy nor it's descendant.";
                throw new \InvalidArgumentException($error);
            }
        } else {
            $texy = new $this->texyClassName();
        }

        if (array_key_exists('outputMode', $parameters)) {
            $texy->setOutputMode($parameters['outputMode']);
        }

        foreach ($parameters as $type => $options) {
            if ($type === 'allowed') {
                $this->setAllowed($texy, $options);
            } elseif ($type === 'modules') {
                $this->setModules($texy, $options);
            } elseif ($type === 'variables') {
                $this->setVariables($texy, $options);
            }
        }
        $this->addCustomAttributes($texy);

        return $texy;
    }

    /**
     * Sets all arguments that needs to be called like $texy->allowed
     *
     * Although texyClassName can be set be user, I have to expect, it is Texy class or some class that extends it.
     * Hence the typehint.
     *
     * @param Texy $texy
     * @param $options
     */
    private function setAllowed(Texy $texy, $options)
    {
        foreach ($options as $option => $value) {
            $texy->allowed[$option] = $this->translateArgument($value);
        }
    }

    /**
     * Sets all arguments that needs to be called like $texy->someModule->option = value;
     *
     * Although texyClassName can be set be user, I have to expect, it is Texy class or some class that extends it.
     * Hence the typehint.
     *
     * @param Texy $texy
     * @param $options
     */
    private function setModules(Texy $texy, $options)
    {
        foreach ($options as $moduleName => $moduleOptions) {
            foreach ($moduleOptions as $optionName => $optionParameters) {
                $moduleVariableName = $moduleName.'Module';
                $texy->$moduleVariableName->$optionName = $this->translateArgument($optionParameters);
            }
        }
    }

    /**
     * sets all calls that needs to be called like $texy->something = somethingElse
     *
     * Although texyClassName can be set be user, I have to expect, it is Texy class or some class that extends it.
     * Hence the typehint.
     *
     * @param Texy $texy
     * @param $options
     */
    private function setVariables(Texy $texy, $options)
    {
        foreach ($options as $variableName => $value) {
            $texy->$variableName = $this->translateArgument($value);
        }
    }

    private function translateArgument($argument)
    {
        if (is_array($argument)) {
            $transformed_argument = array();
            foreach ($argument as $key => $value) {
                $transformed_argument[$key] = $this->translateValue($value);
            }
            $argument = $transformed_argument;
        } else {
            $argument = $this->translateValue($argument);
        }

        return $argument;
    }

    private function translateValue($value)
    {
        if ($value === '*') {
            return Texy::ALL;
        } elseif ($value === '-') {
            return Texy::NONE;
        }
        return $value;
    }

    public function addCustomAttributes(Texy $texy)
    {
        foreach (array_keys($texy->dtd) as $element) {
            if (!is_array($texy->dtd[$element][0])) {
                continue;
            }
            $texy->dtd[$element][0] = array_merge(
                $texy->dtd[$element][0],
                $this->customAttributes
            );
        }
    }
}
