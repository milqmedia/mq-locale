<?php
  
namespace MQLocale\View\Helper;  

use Locale;

use Zend\View\Helper\AbstractHelper;  
use Zend\ServiceManager\ServiceLocatorAwareInterface;  
use Zend\ServiceManager\ServiceLocatorInterface;  

class DefaultLanguage extends AbstractHelper implements ServiceLocatorAwareInterface  
{  
	private $serviceLocator;
	
	public function __invoke() {
		
		return $this;
	}
	
	public function parseDefaultLanguage() {
		
		$locale = str_replace('_', '-', Locale::getDefault());

		$config = $this->getServiceLocator()->getServiceLocator()->get('Config');
		
		if(isset($config['mq_locale']['aliases'][$locale])) {
			return $locale;
		} else if($found = array_search($locale, $config['mq_locale']['aliases'])) {
			return $found;
		}

		$locale = array_search($config['mq_locale']['default'], $config['mq_locale']['aliases']);
		
		return $locale;
	}
	
	public function getCurrentLanguage() {
		
		$sl = $this->getServiceLocator()->getServiceLocator();
		$em = $sl->get('ApplicationEntityManager');
		
		$currentLanguageIso = $this->parseDefaultLanguage();
		$language = $em->getRepository('Application\Entity\Language')->findOneBy(array('isoCode' => $currentLanguageIso));
			
		return $language;
	}
	
	public function getLocale() {
		
		return Locale::getDefault();
	}
	
    /** 
     * Set the service locator. 
     * 
     * @param ServiceLocatorInterface $serviceLocator 
     * @return CustomHelper 
     */  
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)  
    {  
        $this->serviceLocator = $serviceLocator;  
        return $this;  
    }  

    /** 
     * Get the service locator. 
     * 
     * @return \Zend\ServiceManager\ServiceLocatorInterface 
     */  
    public function getServiceLocator()  
    {  
        return $this->serviceLocator;  
    } 
    
}