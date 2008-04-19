<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require 'index/xfIndex.class.php';
require 'mock/engine/xfMockEngine.class.php';
require 'service/xfServiceRegistry.class.php';

class xfMockIndex extends xfIndex
{
  public $configured = false;

  public function configure()
  {
    $this->configured = true;
  }
}
