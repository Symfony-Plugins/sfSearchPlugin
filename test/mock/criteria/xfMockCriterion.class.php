<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once 'criteria/xfCriterion.interface.php';

class xfMockCriterion implements xfCriterion
{
  public function breakdown()
  {
    return $this;
  }
}
