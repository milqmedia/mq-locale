<?php
/**
 * MQLocale
 * Copyright (c) 2014 Milq Media.
 *
 * @author      Johan Kuijt <johan@milq.nl>
 * @copyright   2014 Milq Media.
 * @license     http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link        http://milq.nl
 */
 
namespace MQLocale\Strategy;

use Zend\ServiceManager\AbstractPluginManager;

class StrategyManager extends AbstractPluginManager
{
    protected $invokableClasses = array(
       'host'    => 'MQLocale\Strategy\HostStrategy',
       'url'     => 'MQLocale\Strategy\UrlStrategy',
    );

    public function validatePlugin($plugin)
    {
        if ($plugin instanceof StrategyInterface) {
            return;
        }

        throw new Exception\InvalidStrategyException(sprintf(
            'Strategy of type %s is invalid; ',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}