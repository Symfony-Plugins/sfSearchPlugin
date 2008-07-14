<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A retort for fields.
 *
 * This is a simple shortcut retort to mask:
 * <code>
 * $hit->getDocument()->getField('field')->getValue();
 * </code>
 * with:
 * <code>
 * $hit->getField();
 * </code>
 *
 * @package sfSearch
 * @subpackage Result
 * @author Carl Vondrick
 */
final class xfRetortField implements xfRetort
{
  /**
   * Only accepts the call if the method starts with "get" and the field exists.
   *
   * @see xfRetort
   */
  public function can(xfDocumentHit $hit, $method, array $args = array())
  {
    if (substr($method, 0, 3) == 'get')
    {
      $field = $this->normalize($method);

      return $hit->getDocument()->hasField($field);
    }

    return false;
  }

  /**
   * @see xfRetort
   */
  public function respond(xfDocumentHit $hit, $method, array $args = array())
  {
    $field = $this->normalize($method);

    return $hit->getDocument()->getField($field)->getValue();
  }

  /**
   * Converts the camelized name to underscore format.
   *
   * @param string $camel
   * @returns underscored format
   */
  private function normalize($camel)
  {
    $camel = substr($camel, 3);
    $camel = preg_replace('/([A-Z]+)([A-Z][a-z])/', '$1_$2', $camel);
    $camel = preg_replace('/([a-z\d])([A-Z])/', '$1_$2', $camel);
    $camel = strtolower($camel);

    return $camel;
  }
}
