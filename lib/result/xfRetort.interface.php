<?php
/**
 * A retort extends xfDocumentHit to provide advanced functionality.
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
   * @param xfDocumentHit $result The result
   * @param string $method The method called
   * @param array $args The args passed (optional)
   * @returns mixed The retort response
   */
  public function can(xfDocumentHit $result, $method, array $args = array());

  /**
   * Generates a response for this retort
   *
   * @param xfDocumentHit $result The result
   * @param string $method The method called
   * @param array $args The args passed (optional)
   * @returns mixed The retort response
   */
  public function respond(xfDocumentHit $result, $method, array $args = array());
}
