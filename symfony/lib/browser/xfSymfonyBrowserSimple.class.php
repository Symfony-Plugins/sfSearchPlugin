<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The symfony browser interacts with the symfony framework to dispatch requests
 * and retrieve data.
 *
 * Usage example:
 * <code>
 * $request = new xfSymfonyBrowserRequest('frontend', 'blog', 'showPost', array('id' => 42));
 *
 * $browser = new xfSymfonyBrowser;
 * $response = $browser->fetch($request);
 *
 * $content = $response->getContent();
 * $title = $response->getTitle();
 * </code>
 *
 * @package sfSymfonySearch
 * @subpackage Browser
 * @author Carl Vondrick
 */
final class xfSymfonyBrowserSimple implements xfSymfonyBrowser
{
  /**
   * A request method
   */
  const GET = 'GET';

  /**
   * A request method
   */
  const POST = 'POST';

  /**
   * The session ID
   *
   * @var string
   */
  private $sessionId;

  /**
   * The hostname
   *
   * @var string
   */
  private $hostName = 'localhost';

  /**
   * The server name
   *
   * @var string
   */
  private $serverName = 'localhost';

  /**
   * The remote address
   *
   * @var string
   */
  private $remoteAddress = '127.0.0.1';

  /**
   * The request method
   *
   * @var string
   */
  private $method = 'GET';

  /**
   * The request environment
   *
   * @var string
   */
  private $environment = 'prod';

  /**
   * The request debug mode
   *
   * WARNING: Must be true or symfony might throw a fatal error because of
   * core_compile.  In debug mode, core_compile does not load.
   *
   * @var bool
   */
  private $debug = true;

  /**
   * Instances of application configurations
   *
   * @var array
   */
  static private $configurations = array();

  /**
   * Constructor to set initial values
   *
   * @param string $method
   */
  public function __construct($method = self::GET)
  {
    $this->method = $method;
    $this->sessionId = md5(uniqid(rand(), true));
  }

  /**
   * @see xfSymfonyBrowser
   */
  public function fetch(xfSymfonyBrowserRequest $r)
  {
    $this->restart();
    $this->initialize($r);

    $config = $this->getConfiguration($r);
    $context = sfContext::createInstance($config);

    ob_start();
    $context->dispatch();
    $contents = ob_get_clean();

    $context->shutdown();
    unset($context);

    $this->restart();

    return new xfSymfonyBrowserResponse($contents, $r);
  } 

  /**
   * Gets the application configuration
   *
   * @param xfSymfonyBrowserRequest $r
   * @returns sfApplicationConfiguration
   */
  private function getConfiguration(xfSymfonyBrowserRequest $r)
  {
    $app = $r->getApplication();

    if (!isset(self::$configurations[$app]))
    {
      self::$configurations[$app] = sfProjectConfiguration::getApplicationConfiguration($app, $this->environment, $this->debug, null, new sfEventDispatcher);
    }

    // we must make this configuration the active

    $config = self::$configurations[$app];
    $config-> __construct($this->environment, $this->debug, null, new sfEventDispatcher);

    return $config;
  }

  /**
   * Restarts the session
   */
  private function restart()
  {
    $_GET       = array();
    $_POST      = array();
    $_REQUEST   = array();
    $_COOKIE    = array();
    $_SESSION   = array();
    $_SERVER    = array();
  }

  /**
   * Initializes the browser
   *
   * @param xfSymfonyBrowserRequest $r
   */
  private function initialize(xfSymfonyBrowserRequest $r)
  {
    $_SERVER['HTTP_HOST']       = $this->hostName;
    $_SERVER['SERVER_NAME']     = $this->serverName;
    $_SERVER['SERVER_PORT']     = 80;
    $_SERVER['HTTP_USER_AGENT'] = 'PHP5/sfSymfonySearch';
    $_SERVER['REMOTE_ADDR']     = $this->remoteAddress;
    $_SERVER['REQUEST_METHOD']  = $this->method;
    $_SERVER['PATH_INFO']       = '/' . $r->getModule() . '/' . $r->getAction();
    $_SERVER['REQUEST_URI']     = '/index.php/' . $r->getModule() . '/' . $r->getAction() . $r->getQueryString();
    $_SERVER['SCRIPT_NAME']     = '/index.php';
    $_SERVER['SCRIPT_FILENAME'] = '/index.php';
    $_SERVER['QUERY_STRING']    = $r->getQueryString();
    $_SERVER['session_id']      = $this->sessionId;

    $_GET['action'] = $r->getAction();
    $_GET['module'] = $r->getModule();
    $_GET           = array_merge($_GET, $r->getParameters());

    sfConfig::set('sf_rendering_filter', array('xfSymfonyBrowserRenderingFilter', null));
  }

  /**
   * Sets the hostname
   *
   * @param string $hostName
   */
  public function setHostName($hostName)
  {
    $this->hostName = $hostName;
  }

  /**
   * Sets the server name
   *
   * @param string $serverName
   */
  public function setServerName($serverName)
  {
    $this->serverName = $serverName;
  }

  /**
   * Sets the remote address
   *
   * @param string $remoteAddress
   */
  public function setRemoteAddress($remoteAddress)
  {
    $this->remoteAddress = $remoteAddress;
  }

  /**
   * Sets the method
   *
   * @param string $method
   */
  public function setMethod($method)
  {
    $this->method = $method;
  }

  /**
   * Sets the environment
   *
   * @param string $env
   */
  public function setEnvironment($env)
  {
    $this->environment = $env;
  }
}
