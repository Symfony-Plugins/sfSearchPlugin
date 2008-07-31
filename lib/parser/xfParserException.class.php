<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'util' . DIRECTORY_SEPARATOR . 'xfException.class.php';

/**
 * An exception to indicate that parsing failed.
 *
 * @package sfSearch
 * @subpackage Parser
 * @author Carl Vondrick
 */
class xfParserException extends xfException
{
}
