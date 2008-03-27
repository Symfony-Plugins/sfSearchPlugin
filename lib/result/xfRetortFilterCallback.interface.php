<?php
/**
 * A special filter for the xfRetortFilterer retort.
 *
 * @package sfSearch
 * @subpackage Result
 * @author Carl Vondrick
 */
interface xfRetortFilterCallback
{
  /**
   * Filters the response.
   *
   * @param string $response
   * @param xfDocumentHit $hit
   * @param string $method
   * @param array $args
   * @returns string
   */
  public function filter($response, xfDocumentHit $hit, $method, array $args = array());
}
