<?php

namespace MQLocale\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DefaultLanguage extends AbstractPlugin implements ServiceLocatorAwareInterface  
{
	private $serviceLocator;
	
    public function __invoke() {
		
		return $this;
	}
	
	public function getCurrentLanguage() {
		
		$sl = $this->getServiceLocator()->getServiceLocator();
		$em = $sl->get('ApplicationEntityManager');
		
		$currentLanguageIso = $this->parseDefaultLanguage();
		$language = $em->getRepository('Application\Entity\Language')->findOneBy(array('isoCode' => $currentLanguageIso));
			
		return $language;
	}
	
	public function parseDefaultLanguage() {
		
		$sl = $this->getServiceLocator()->getServiceLocator();
		$viewHelperManager = $sl->get('viewHelperManager');
		
		$localeHelper = $viewHelperManager->get('language');
		$locale = $localeHelper->parseDefaultLanguage();
		
		return $locale;
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