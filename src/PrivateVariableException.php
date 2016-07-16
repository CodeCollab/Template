<?php declare(strict_types=1);
/**
 * Exception which gets thrown when trying to access a private template variable
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Template
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace CodeCollab\Template;

/**
 * Exception which gets thrown when trying to access a private template variable
 *
 * @category   CodeCollab
 * @package    Template
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class PrivateVariableException extends \Exception
{
}
