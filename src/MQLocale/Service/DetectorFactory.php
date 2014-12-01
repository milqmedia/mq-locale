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
 
namespace MQLocale\Service;

use MQLocale\Locale\Detector;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DetectorFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Detector
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');
        $config = $config['mq_locale'];
        $detector = new Detector;
        
        if (array_key_exists('default', $config)) {
            $detector->setDefault($config['default']);
        }
        if (array_key_exists('supported', $config)) {
            $detector->setSupported($config['supported']);
        }
        if (array_key_exists('domains', $config)) {
            $detector->setDomains($config['domains']);
        }
        if (array_key_exists('aliases', $config)) {
            $detector->setAliases($config['aliases']);
        }
        
        return $detector;
    }
}