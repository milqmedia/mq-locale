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

    'service_manager' => array(
        'factories'  => array(
            'MQLocale\Locale\Detector' => 'MQLocale\Service\DetectorFactory',
        ),
    ),
);