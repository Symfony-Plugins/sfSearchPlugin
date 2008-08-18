<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A browser response that contains the data returned by xfSymfonyBrowser
 *
 * @package sfSymfonySearch
 * @subpackage Browser
 * @author Carl Vondrick
 */
final class xfSymfonyBrowserResponse
{
  /**
   * The symfony response
   *
   * @var string
   */
  private $response;  

  /**
   * The request
   *
   * @var xfSymfonyBrowserRequest
   */
  private $request;

  /**
   * Constructor to set initial values
   *
   * @param string $response
   * @param xfSymfonyBrowserRequest $request
   */
  public function __construct($response, xfSymfonyBrowserRequest $request)
  {
    $this->response = $response;
    $this->request = $request;
  }

  /**
   * Gets the request
   *
   * @returns xfSymfonyBrowserRequest
   */
  public function getRequest()
  {
    return $this->request;
  }

  /**
   * Gets the response
   *
   * @returns string
   */
  public function getResponse()
  {
    return $this->response;
  }
}
