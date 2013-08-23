<?php


namespace Edge\TexyBundle\Configurator;
use Texy;


/**
 * @author: Marek Makovec <marek.makovec@edgedesign.cz>
 */
interface IConfigurator
{
    /**
     * Method, that receives data from user config and returns fully configured Texy
     *
     * @param array $parameters
     * @return Texy
     */
    public function configure(array $parameters);
}