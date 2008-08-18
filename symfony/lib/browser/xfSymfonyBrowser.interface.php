<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The interface for a symfony browser
 *
 * @package sfSymfonySearch
 * @subpackage Browser
 * @author Carl Vondrick
 */
interface xfSymfonyBrowser
{
  /**
   * Fetches the response
   *
   * @param xfSymfonyBrowserRequest $r The request to fetch
   * @returns xfSymfonyBrowserResponse The response
   */
  public function fetch(xfSymfonyBrowserRequest $r);
}
