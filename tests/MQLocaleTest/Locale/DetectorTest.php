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
namespace MQLocaleTest\Locale;

use PHPUnit_Framework_TestCase as TestCase;
use MQLocale\Locale\Detector;
use MQLocale\Locale\DetectorConfig;

use Zend\Http\Request;
use Zend\Http\Response;
use Zend\ServiceManager\ServiceManager;

class DetectorTest extends TestCase
{
	protected $config;
	
	public function setUp() {
		
		$config = new DetectorConfig();
		
		$config->setDomains(array('test.:locale'));
		$config->setSupported(array('en_US'));
		$config->setAliases(array('nl' => 'nl_NL'));
		$config->setDefault('nl_NL');
		$config->setStrategy('host');

		$this->config = $config;
	}
	
	public function testEmptyStrategy()
    {
        $this->config->setStrategy(null);

        $detector = new Detector($this->config);
		$sl = $this->getServiceLocator();
		$error = null;
		
		try {
			$locale = $detector->detect(new Request, $sl->get('MQLocale\Strategy\StrategyManager'));
		} catch(\MQLocale\Locale\Exception\InvalidArgumentException $e) {
			
			$error = $e->getMessage();	
		}
		
		$this->assertEquals('No strategy configured', $error);
    }

    public function testUseDefaultLocaleWhenResultIsNotSupported()
    {
        $this->config->setDefault('Foo');

        $detector = new Detector($this->config);
		$sl = $this->getServiceLocator();
		
		$locale = $detector->detect(new Request, $sl->get('MQLocale\Strategy\StrategyManager'));

        $this->assertEquals('Foo', $locale);
    }

    public function testEmptySupportedListIndicatesNoSupportedList()
    {
        $this->config->setSupported(array());

        $detector = new Detector($this->config);
		$sl = $this->getServiceLocator();
		
		$this->assertFalse($detector->getConfig()->hasSupported());
    }
    
    public function testInvalidDomainReturnsDefaultLocale()
    {
	    $domains = array('invalid.:locale');
	    
		$this->config->setDomains($domains);
		$this->config->setDefault('Foo');
		
        $detector = new Detector($this->config);
        $sl = $this->getServiceLocator();
		
		$locale = $detector->detect(new Request, $sl->get('MQLocale\Strategy\StrategyManager'));
        
        $this->assertEquals('Foo', $locale);
    }
    
    public function getServiceLocator()
    {
		$serviceLocator = new ServiceManager;
        $serviceLocator->setInvokableClass('MQLocale\Strategy\StrategyManager', 'MQLocale\Strategy\StrategyManager');
        return $serviceLocator;
    }
}
