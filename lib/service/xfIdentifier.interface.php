<?php
/**
 * Identifiers provide the meta data to a service and builder.
 *
 * @package sfSearch
 * @subpackage Builder
 * @author Carl Vondrick
 */
interface xfIdentifier
{
  /**
   * Gets the name for this service.
   *
   * @returns string
   */
  public function getName();

  /**
   * Calculates a GUID for an object.
   *
   * @param mixed $input
   * @returns string
   */
  public function getGuid($input);

  /**
   * Tests to see if the identifier can identify it.
   *
   * @param mixed $input
   * @returns bool true if can identify, false otherwise
   */
  public function match($input);

  /**
   * Discovers all objects that this identifier can match.
   *
   * @returns array
   */
  public function discover();
}
