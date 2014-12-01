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

use Zend\Http\Request;
use Zend\Http\Response;

class DetectorTest extends TestCase
{
	protected $domains;
	
	protected $supported;
	
	protected $aliases;
	
	public function setUp() {
		
		$this->domains = array('test.:locale');
		$this->supported = array('en_US');
		$this->aliases = array('nl' => 'nl_NL');
	}
	
    public function testUseDefaultLocaleWhenResultIsNotSupported()
    {
        $detector = new Detector;
        $detector->setDomains($this->domains);
        $detector->setSupported($this->supported);
		$detector->setDefault('Foo');

        $locale = $detector->detect(new Request, new Response);

        $this->assertEquals('Foo', $locale);
    }

    public function testEmptySupportedListIndicatesNoSupportedList()
    {
        $detector  = new Detector;
        $supported = array();
        $detector->setDomains($this->domains);
        $detector->setSupported($supported);

        $this->assertFalse($detector->hasSupported());
    }
    
    public function testInvalidDomainReturnsDefaultLocale()
    {
        $detector  = new Detector;
        $domains = array('invalid.:locale');
        $detector->setDomains($domains);
        $detector->setSupported($this->supported);
        $detector->setDefault('Foo');

        $locale = $detector->detect(new Request, new Response);
        
        $this->assertEquals('Foo', $locale);
    }
}
