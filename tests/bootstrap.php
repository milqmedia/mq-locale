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

chdir(__DIR__);
$previousDir = '.';
while (!is_dir($previousDir . DIRECTORY_SEPARATOR . 'vendor')) {
    $appRoot = dirname(getcwd());

    if ($previousDir === $appRoot) {
        throw new RuntimeException('Unable to locate application root');
    }

    $previousDir = $appRoot;
    chdir($appRoot);
}

// Load composer autoloader
require_once $appRoot . '/vendor/autoload.php';