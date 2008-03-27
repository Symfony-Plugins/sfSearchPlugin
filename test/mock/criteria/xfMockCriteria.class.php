<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require_once 'criteria/xfCriterion.interface.php';
require_once 'criteria/xfCriterionRewriter.interface.php';

class xfMockCriteria implements xfCriterion
{
  public $rewriten = false;

  public function rewrite(xfCriterionRewriter $rewriter)
  {
    $this->rewriten = true;

    return $this;
  }

  public function tokenize($input)
  {
    return array(new xfCriterionToken('foo', 3, 6));
  }
}
