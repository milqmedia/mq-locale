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

use Zend\Stdlib\RequestInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Uri\Uri;
use Zend\Mvc\Router\Http\TreeRouteStack;

use MQLocale\Strategy\Exception\InvalidArgumentException;
use MQLocale\Locale\DetectorConfig;

class UrlStrategy extends AbstractStrategy implements ServiceLocatorAwareInterface
{    
	protected $sl;
	
	public function setServiceLocator(ServiceLocatorInterface $sl)
    {
        $this->sl = $sl;
    }

    public function getServiceLocator()
    {
        return $this->sl;
    }
    protected function getRouter()
    {
        return $this->getServiceLocator()->getServiceLocator()->get('router');
    }
    
    public function detect(DetectorConfig $config, RequestInterface $request)
    {
		$base   = $this->getBasePath();
        $locale = $this->getFirstSegmentInPath($request->getUri(), $base);
        
        $aliases = $config->getAliases();

		if (null !== $aliases && array_key_exists($locale, $aliases)) {
		    $locale = $aliases[$locale];
		}
		
		return $locale;
    }
    
    protected function getFirstSegmentInPath(Uri $uri, $base = null)
    {
        $path = $uri->getPath();
        if ($base) {
            $path = substr($path, strlen($base));
        }
        $parts  = explode('/', trim($path, '/'));
        $locale = array_shift($parts);
        return $locale;
    }

    protected function getBasePath()
    {
        $base   = null;
        $router = $this->getRouter();
        if ($router instanceof TreeRouteStack) {
            $base = $router->getBaseUrl();
        }
        return $base;
    }
}