<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A simple browser whose response is pluggable
 *
 * @package sfSymfonySearch
 * @subpackage Browser
 * @author Carl Vondrick
 */
final class xfSymfonyBrowserPluggable implements xfSymfonyBrowser
{
  /**
   * The response
   *
   * @var string
   */
  private $response;

  /**
   * Constructor to set initial response
   *
   * @param string $response
   */
  public function __construct($response = null)
  {
    $this->setResponse($response);
  }
  
  /**
   * Sets the response
   *
   * @param string $response
   */
  public function setResponse($response)
  {
    $this->response = $response;
  }

  /**
   * @see xfSymfonyBrowser
   */
  public function fetch(xfSymfonyBrowserRequest $request)
  {
    return new xfSymfonyBrowserResponse($this->response, $request);
  }
}
