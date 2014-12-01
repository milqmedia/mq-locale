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

namespace MQLocale\Locale;

use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;

use MQLocale\Strategy\StrategyManager;

class Detector
{
    /**
     * MQLocale\Locale\DetectorConfig object
     *
     * @var MQLocale\Locale\DetectorConfig
     */
    protected $config;
    
    public function getConfig()
    {
        return $this->config;
    }
    
    public function setConfig(\MQLocale\Locale\DetectorConfig $config)
    {
        $this->config = $config;
        return $this;
    }
    
    public function __construct(\MQLocale\Locale\DetectorConfig $config) {
	    
	    $this->setConfig($config);
    }

    public function detect(RequestInterface $request, StrategyManager $strategyManager)
    {
	    $config = $this->getConfig();
	    
        if (!$config->hasSupported()) {
            throw new Exception\InvalidArgumentException(
                'No supported languages are configured'
            );
        }

        if (!$config->hasStrategy()) {
            throw new Exception\InvalidArgumentException(
                'No strategy configured'
            );
        }
        
        $strategy = $config->getStrategy();
        $detectorStrategy = $strategyManager->get($strategy);
        $locale = $detectorStrategy->detect($config, $request);
                
        if (!in_array($locale, $config->getSupported())) {
            return $config->getDefault();
        }
		
        return $locale;
    }
}
