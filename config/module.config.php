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

return array(
    'mq_locale' => array(
    ),
    'view_helpers' => array(  
        'invokables' => array(  
            'language' => 'MQLocale\View\Helper\DefaultLanguage',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'language' => 'MQLocale\Controller\Plugin\DefaultLanguage',
		),
    ),
    'service_manager' => array(
	    'invokables' => array(
            'MQLocale\Strategy\StrategyManager' => 'MQLocale\Strategy\StrategyManager',
        ),
        'factories'  => array(
            'MQLocale\Locale\Detector' => 'MQLocale\Service\DetectorFactory',
        ),
    ),
);