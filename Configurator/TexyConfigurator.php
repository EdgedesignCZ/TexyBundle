<?php


namespace Edge\TexyBundle\Configurator;
use \Texy;


/**
 * @author: Marek Makovec <marek.makovec@edgedesign.cz>
 */
class TexyConfigurator implements IConfigurator
{
    /**
     * @var string stores name of Texy class
     */
    private $texyClassName;

    /**
     * @param string $texy_class_name name of class of Texy
     */
    function __construct($texyClassName)
    {
        $this->texyClassName = $texyClassName;
    }


    /**
     * Function, that receives data from user config and returns fully configured Texy
     *
     * @param array $parameters
     * @return Texy
     */
    public function configure(array $parameters)
    {
        if(array_key_exists('class', $parameters)){
            $texy = new $parameters['class'];
            if(!$texy instanceof Texy){
                throw new \InvalidArgumentException('Specified class ' . $parameters['class'] . ' is not instance of Texy nor it\'s descendant.');
            }
        } else {
            $texy = new $this->texyClassName;
        }

        foreach($parameters as $type => $options){
            if($type === 'allowed'){
                $this->setAllowed($texy, $options);
            } else if ($type === 'modules'){
                $this->setModules($texy, $options);
            } else if ($type === 'variables'){
                $this->setVariables($texy, $options);
            }
        }

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
        foreach($options as $option => $value){
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
        foreach($options as $moduleName => $moduleOptions){
            foreach($moduleOptions as $optionName => $optionParameters){
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
        foreach($options as $variableName => $value){
            $texy->$variableName = $this->translateArgument($value);
        }
    }

    private function translateArgument($argument)
    {
        if(is_array($argument)){
            $transformed_argument = array();
            foreach($argument as $key => $value){
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
        if($value === '*') {
            return Texy::ALL;
        } else if ($value === '-'){
            return Texy::NONE;
        }

        return $value;
    }

}