<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The request object to indicate what to fetch
 *
 * @package sfSymfonySearch
 * @subpackage Browser
 * @author Carl Vondrick
 */
final class xfSymfonyBrowserRequest
{
  /**
   * The application
   *
   * @var string
   */
  private $app;

  /**
   * The module
   *
   * @var string
   */
  private $module;

  /**
   * The action
   *
   * @var string
   */
  private $action;

  /**
   * The parameters
   *
   * @var array
   */
  private $params = array();

  /**
   * Constructor to set initial values
   *
   * @param string $app
   * @param string $module
   * @param string $action
   * @param array $params
   */
  public function __construct($app, $module, $action, array $params = array())
  {
    $this->app = $app;
    $this->module = $module;
    $this->action = $action;
    $this->params = $params;
  }

  /**
   * Parses a route to create a request object
   *
   * Route syntax is:
   *  app/module/action?key1=value1&key2=value2
   *
   * @param string $request
   * @returns array the parsed pieces
   */
  static public function createFromString($route)
  {
    if (!preg_match('#^(\w+):(\w+)/(\w+)(\?.*)?$#', $route, $matches))
    {
      throw new xfSymfonyException('Route syntax invalid, must be in form app/module/action[?key=value[&key=value ... ]], got "' . $route . '"');
    }

    $app    = $matches[1];
    $module = $matches[2];
    $action = $matches[3];
    $params = array();

    if (isset($matches[4]))
    {
      parse_str(substr($matches[4], 1), $params);
    }

    return new self($app, $module, $action, $params);
  }

  /**
   * Converts this request as a string
   *
   * @returns string
   */
  public function getAsString()
  {
    $route = sprintf('%s:%s/%s', $this->app, $this->module, $this->action);

    if (count($this->params))
    {
      $route .= $this->getQueryString();
    }

    return $route;
  }

  /**
   * Magical wrapper to convert to string
   *
   * @returns string
   */
  public function __toString()
  {
    return $this->getAsString();
  }

  /**
   * Gets the application
   *
   * @returns string
   */
  public function getApplication()
  {
    return $this->app;
  }

  /**
   * Gets the module
   *
   * @returns string
   */
  public function getModule()
  {
    return $this->module;
  }

  /**
   * Gets the action
   *
   * @returns string
   */
  public function getAction()
  {
    return $this->action;
  }

  /**
   * Gets the request parameters
   *
   * @returns array
   */
  public function getParameters()
  {
    return $this->params;
  }

  /**
   * Sets a request parameter
   *
   * @param string $name The parameter name
   * @param mixed $value The parameter value
   */
  public function setParameter($name, $value)
  {
    $this->params[$name] = $value;
  }

  /**
   * Gets the query string
   *
   * @returns string
   */
  public function getQueryString()
  {
    return '?' . urldecode(http_build_query($this->params, null, '&'));
  }

  /**
   * Tests to see if the two requests are equal
   *
   * @param xfSymfonyBrowserRequst $request
   */
  public function equals(xfSymfonyBrowserRequest $request)
  {
    return 
            $this->app    == $request->app    &&
            $this->module == $request->module &&
            $this->action == $request->action &&
            $this->params == $request->params
            ;
  }
}
