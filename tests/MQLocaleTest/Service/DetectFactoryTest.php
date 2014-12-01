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

use Zend\EventManager\EventManager;
use Zend\ServiceManager\ServiceManager;

class DetectorFactoryTest extends TestCase
{
    public function testFactoryInstantiatesDetector()
    {
        $sl = $this->getServiceLocator();
        $detector = $sl->get('MQLocale\Locale\Detector');

        $this->assertInstanceOf('MQLocale\Locale\Detector', $detector);
    }

    public function testDefaultLocaleIsSet()
    {
        $sl = $this->getServiceLocator(array(
            'default' => 'Foo'
        ));
        $detector = $sl->get('MQLocale\Locale\Detector');

        $this->assertEquals('Foo', $detector->getDefault());
    }

    public function testSupportedLocalesAreSet()
    {
        $sl = $this->getServiceLocator(array(
            'supported' => array('Foo', 'Bar')
        ));
        $detector = $sl->get('MQLocale\Locale\Detector');

        $this->assertEquals(array('Foo', 'Bar'), $detector->getSupported());
    }

	public function testDomainsAreSet()
    {
        $sl = $this->getServiceLocator(array(
            'domains' => array('Foo', 'Bar')
        ));
        $detector = $sl->get('MQLocale\Locale\Detector');

        $this->assertEquals(array('Foo', 'Bar'), $detector->getDomains());
    }
    
    public function testAliasesAreSet()
    {
        $sl = $this->getServiceLocator(array(
            'aliases' => array('Foo', 'Bar')
        ));
        $detector = $sl->get('MQLocale\Locale\Detector');

        $this->assertEquals(array('Foo', 'Bar'), $detector->getAliases());
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
