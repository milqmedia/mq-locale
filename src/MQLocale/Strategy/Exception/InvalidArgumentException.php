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
namespace MQLocale\Strategy\Exception;

use InvalidArgumentException as StdInvalidArgumentException;
use MQLocale\Exception\ExceptionInterface;

class InvalidArgumentException
    extends StdInvalidArgumentException
    implements ExceptionInterface
{
}