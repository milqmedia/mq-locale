<?php
/**
 * MQLocale
 *
 * @author      Johan Kuijt <johan@milq.nl>
 * @license     http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link        http://milq.nl
 */
 
namespace MQLocale\Service;

use MQLocale\Locale\Detector;
use MQLocale\Locale\DetectorConfig;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DetectorFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Detector
     */
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = NULL)
    {
        $config 		= $container->get('config');
        $config 		= $config['mq_locale'];
        $detectorConfig = new DetectorConfig;
        
        if (array_key_exists('default', $config)) {
            $detectorConfig->setDefault($config['default']);
        }
        if (array_key_exists('supported', $config)) {
            $detectorConfig->setSupported($config['supported']);
        }
        if (array_key_exists('domains', $config)) {
            $detectorConfig->setDomains($config['domains']);
        }
        if (array_key_exists('aliases', $config)) {
            $detectorConfig->setAliases($config['aliases']);
        }
        if (array_key_exists('strategy', $config)) {
            $detectorConfig->setStrategy($config['strategy']);
        }
        
        return new Detector($detectorConfig);
    }
 
    public function createService(ServiceLocatorInterface $services)
    {
        return $this($services, 'Detector');
    }
}
