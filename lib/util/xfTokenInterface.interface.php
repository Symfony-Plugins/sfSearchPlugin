<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A common token interface
 *
 * @package sfSearch
 * @subpackage Utilities
 * @author Carl Vondrick
 */
interface xfTokenInterface
{
  /**
   * Gets the token text
   *
   * @returns string
   */
  public function getText();

  /**
   * Gets the token start position
   *
   * @returns int
   */
  public function getStart();
  
  /**
   * Gets the token end position
   *
   * @returns int
   */
  public function getEnd();

  /**
   * Gets the token length
   *
   * @returns int
   */
  public function getLength();
}
