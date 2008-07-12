<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A retort extends xfDocument to provide advanced functionality.
 *
 * @package sfSearch
 * @subpackage Result
 * @author Carl Vondrick
 */
interface xfRetort
{
  /**
   * Determines if this retort can in fact respond.
   *
   * @param xfDocument $doc The result
   * @param string $method The method called
   * @param array $args The args passed (optional)
   * @returns mixed The retort response
   */
  public function can(xfDocument $doc, $method, array $args = array());

  /**
   * Generates a response for this retort
   *
   * @param xfDocument $doc The result
   * @param string $method The method called
   * @param array $args The args passed (optional)
   * @returns mixed The retort response
   */
  public function respond(xfDocument $doc, $method, array $args = array());
}
