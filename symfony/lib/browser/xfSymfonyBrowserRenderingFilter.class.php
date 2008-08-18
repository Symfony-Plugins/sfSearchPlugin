<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A simple rendering filter for xfSymfonyBrowserSimple
 *
 * @package sfSymfonySearch
 * @subpackage Browser
 * @author Carl Vondrick
 */
class xfSymfonyBrowserRenderingFilter extends sfFilter
{
  /**
   * @see sfFilter
   */
  public function execute($filterChain)
  {
    $filterChain->execute();

    $this->context->getResponse()->sendContent();
  }
}
