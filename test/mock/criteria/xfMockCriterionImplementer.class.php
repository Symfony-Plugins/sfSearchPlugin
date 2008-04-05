<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once 'criteria/xfCriterionImplementer.interface.php';
require_once 'mock/criteria/xfMockCriterion.class.php';

class xfMockCriterionImplementer implements xfCriterionImplementer
{
  public $c, $tokens = array();

  public function __construct()
  {
    $this->c = new xfMockCriterion;
  }

  public function getAbstractCriterion()
  {
    return $this->c;
  }

  public function getConcreteCriterion()
  {
    return $this->c;
  }

  public function tokenize($input)
  {
    return $this->tokens;
  }
}
