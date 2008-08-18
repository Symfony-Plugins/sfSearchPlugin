<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Identifier for the symfony request
 *
 * Usage example: <code>
 * $identifier = new xfSymfonyIdentifier('frontend', 'legal');
 * $identifier->addAction('privacyPolicy', array('verbose' => 'yes'));
 * $identifier->addAction('tos', array('page' => 1));
 * $identifier->addAction('tos', array('page' => 2));
 * $identifier->addAction('tos', array('page' => 3));
 * </code>
 *
 * @package sfSymfonySearch
 * @subpackage Service
 * @author Carl Vondrick
 */
final class xfSymfonyIdentifier implements xfIdentifier
{
  /**
   * The requests
   *
   * @var array
   */
  private $requests = array();

  /**
   * The application this identifies
   *
   * @var string
   */
  private $app;
  
  /**
   * The module this identifies
   *
   * @var string
   */
  private $module;

  /**
   * The name of the identifier
   *
   * @var string
   */
  private $name;

  /**
   * Constructor to set initial values 
   *
   * @param string $app The application to accept
   * @param string $module The module to accept
   */
  public function __construct($app, $module)
  {
    $this->app = $app;
    $this->module = $module;

    $this->name = 'symfony-' . $this->app . '-' . $this->module;
  }

  /**
   * Adds requests
   *
   * @param array $requests
   * @returns xfSymfonyIdentifier this object
   */
  public function addRequests(array $requests)
  {
    foreach ($requests as $request)
    {
      $this->addRequest($request);
    }

    return $this;
  }

  /**
   * Adds a single request
   *
   * @param xfSymfonyBrowserRequest $request
   * @returns xfSymfonyIdentifier this object
   */
  public function addRequest(xfSymfonyBrowserRequest $request)
  {
    if ($request->getApplication() != $this->app)
    {
      throw new xfSymfonyException('This identifier only accepts requests from the "' . $this->app . '" application, got "' . $request->getApplication() . '"');
    }

    if ($request->getModule() != $this->module)
    {
      throw new xfSymfonyException('This identifier only accepts requests from the "'. $this->module . '" module, got "' . $request->getModule() . '"');
    }

    $this->requests[] = $request;

    return $this;
  }

  /**
   * Adds a action
   *
   * @param string $action
   * @param array $params
   * @returns xfSymfonyIdentifier this object
   */
  public function addAction($action, array $params = array())
  {
    // micro-optimization to skip ->addRequest()
    $this->requests[] = new xfSymfonyBrowserRequest($this->app, $this->module, $action, $params);

    return $this;
  }

  /**
   * Changes the identifier name
   *
   * @param string $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
   * @see xfIdentifier
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @see xfIdentifier
   */
  public function getGuid($input)
  {
    return 's' . sha1($input->getAsString());
  }

  /**
   * @see xfIdentifier
   */
  public function discover($count)
  {
    if ($count > 0)
    {
      return array();
    }
    
    return $this->requests;
  }

  /**
   * @see xfIdentifer
   */
  public function match($input)
  {
    if (!($input instanceof xfSymfonyBrowserRequest))
    {
      return self::MATCH_NO;
    }

    if ($input->getApplication() != $this->app)
    {
      return self::MATCH_NO;
    }

    if ($input->getModule() != $this->module)
    {
      return self::MATCH_NO;
    }

    foreach ($this->requests as $request)
    {
      if ($request->equals($input))
      {
        return self::MATCH_YES;
      }
    }
    
    return self::MATCH_NO;
  }
}
