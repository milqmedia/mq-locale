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
use MQLocale\Locale\DetectorConfig;

use Zend\ServiceManager\ServiceManager;

class DetectorFactoryTest extends TestCase
{
	protected $config;
	
	public function setUp() {
		
		$config = new DetectorConfig();
		
		$config->setDomains(array('test.:locale'));
		$config->setSupported(array('en_US'));
		$config->setAliases(array('nl' => 'nl_NL'));
		$config->setDefault('nl_NL');
		
		$this->config = $config;
	}
	
    public function testFactoryInstantiatesDetector()
    {
        $sl = $this->getServiceLocator();
        $detector = $sl->get('MQLocale\Locale\Detector');
        
        $detector->setConfig($this->config);

        $this->assertInstanceOf('MQLocale\Locale\Detector', $detector);
    }

    public function testDefaultLocaleIsSet()
    {
        $sl = $this->getServiceLocator(array(
            'default' => 'Foo'
        ));
        $detector = $sl->get('MQLocale\Locale\Detector');

        $this->assertEquals('Foo', $detector->getConfig()->getDefault());
    }

    public function testSupportedLocalesAreSet()
    {
        $sl = $this->getServiceLocator(array(
            'supported' => array('Foo', 'Bar')
        ));
        $detector = $sl->get('MQLocale\Locale\Detector');

        $this->assertEquals(array('Foo', 'Bar'), $detector->getConfig()->getSupported());
    }

	public function testDomainsAreSet()
    {
        $sl = $this->getServiceLocator(array(
            'domains' => array('Foo', 'Bar')
        ));
        
        $detector = $sl->get('MQLocale\Locale\Detector');

        $this->assertEquals(array('Foo', 'Bar'), $detector->getConfig()->getDomains());
    }
    
    public function testAliasesAreSet()
    {
        $sl = $this->getServiceLocator(array(
            'aliases' => array('Foo', 'Bar')
        ));
        $detector = $sl->get('MQLocale\Locale\Detector');

        $this->assertEquals(array('Foo', 'Bar'), $detector->getConfig()->getAliases());
    }
    
    public function testStrategyIsSet()
    {
        $sl = $this->getServiceLocator(array(
            'strategy' => 'Foo'
        ));
        $detector = $sl->get('MQLocale\Locale\Detector');

        $this->assertEquals('Foo', $detector->getConfig()->getStrategy());
    }
    
    public function getServiceLocator(array $config = array())
    {
        $config = array(
            'mq_locale' => $config
        );
        $serviceLocator = new ServiceManager;
        $serviceLocator->setFactory('MQLocale\Locale\Detector', 'MQLocale\Service\DetectorFactory');
        $serviceLocator->setService('config', $config);

        return $serviceLocator;
    }
}
