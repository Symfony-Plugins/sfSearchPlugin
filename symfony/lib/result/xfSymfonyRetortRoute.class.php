<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A route retort dedicated to symfony actions
 *
 * @package sfSymfonySearch
 * @subpackage Result
 * @author Carl Vondrick
 */
final class xfSymfonyRetortRoute implements xfRetort
{
  /**
   * The method to respond to
   *
   * @var string
   */
  private $method = 'getRoute';

  /**
   * The route field name
   *
   * @var string
   */
  private $routeField = 'uri';

  /**
   * Changes the method to respond to
   *
   * @param string $method
   */
  public function setMethod($method)
  {
    $this->method = $method;
  }

  /**
   * The route field name
   *
   * @param string $field
   */
  public function setRouteFieldName($field)
  {
    $this->routeField = $field;
  }

  /**
   * @see xfRetort
   */
  public function can(xfDocumentHit $hit, $method, array $args = array())
  {
    return strtolower($this->method) == strtolower($method);
  }

  /**
   * @todo handle different applications (pending support from symfony)
   * @see xfRetort
   */
  public function respond(xfDocumentHit $hit, $method, array $args = array())
  {
    $route = $hit->getDocument()->getField($this->routeField)->getValue();
    $pos = strpos($route, ':') + 1;

    return substr($route, $pos);
  }
}
