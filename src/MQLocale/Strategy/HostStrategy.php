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

use MQLocale\Strategy\Exception\InvalidArgumentException;
use MQLocale\Locale\DetectorConfig;

class HostStrategy extends AbstractStrategy
{
    const LOCALE_KEY = ':locale';
    
    public function detect(DetectorConfig $config, RequestInterface $request)
    {
		$domains = $config->getDomains();
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
		$aliases = $config->getAliases();

		if (null !== $aliases && array_key_exists($locale, $aliases)) {
		    $locale = $aliases[$locale];
		}
		
		return $locale;
    }
}