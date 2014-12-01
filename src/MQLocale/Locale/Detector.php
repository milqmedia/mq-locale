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


class Detector
{
	const LOCALE_KEY = ':locale';
	
    /**
     * Default locale
     *
     * @var string
     */
    protected $default;

    /**
     * List of supported locales
     *
     * @var array
     */
    protected $supported;
    
    /**
     * Lis of supported domains
     *
     * @var array
     */
    protected $domains;
    
    /**
     * List of supported aliases
     *
     * @var array
     */
    protected $aliases;


    public function getDefault()
    {
        return $this->default;
    }

    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }
    
    public function getSupported()
    {
        return $this->supported;
    }
    
    public function setSupported(array $supported)
    {
        $this->supported = $supported;
        return $this;
    }
    
    public function hasSupported()
    {
        return (is_array($this->supported) && count($this->supported));
    }
    
    public function getDomains()
    {
        return $this->domains;
    }
    
    public function setDomains(array $domains)
    {
        $this->domains = $domains;
        return $this;
    }
    
    public function getAliases()
    {
        return $this->aliases;
    }
    
    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
        return $this;
    }
    
    protected function isHttpRequest(RequestInterface $request)
    {
        return $request instanceof HttpRequest;
    }

    public function detect(RequestInterface $request, ResponseInterface $response = null)
    {
        if (!$this->hasSupported()) {
            throw new Exception\InvalidArgumentException(
                'No supported languages are configured'
            );
        }
        
        $domains = $this->getDomains();
        $host    = $request->getUri()->getHost();
        $matched = null;

        if (null === $domains || empty($domains)) {
            throw new Exception\InvalidArgumentException(
                'No domains where configured'
            );
        }

        foreach($domains as $domain) {
	       
	        if (strpos($domain, self::LOCALE_KEY) === false) {
	            throw new Exception\InvalidArgumentException(sprintf(
	                'The domain %s must contain a locale key part "%s"', $domain, self::LOCALE_KEY
	            ));
	        }
	                
	        $pattern = str_replace(self::LOCALE_KEY, '([a-zA-Z-_.]+)', $domain);
	        $pattern = sprintf('@%s@', $pattern);
	        $result  = preg_match($pattern, $host, $matches);
	     	        
	        if ($result) 
	            $matched = $matches;         
       }

        $locale = $matched[1];
        $aliases = $this->getAliases();
        
        if (null !== $aliases && array_key_exists($locale, $aliases)) {
            $locale = $aliases[$locale];
        }
        
        if (!in_array($locale, $this->getSupported())) {
            return $this->getDefault();
        }
		
        return $locale;
    }
}
