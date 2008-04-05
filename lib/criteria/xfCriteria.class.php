<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A common criteria to combine operators.
 *
 * @package sfSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 */
final class xfCriteria implements xfCriterion
{
  /**
   * The registered operators.
   *
   * @var array
   */
  private $operators = array();

  /**
   * Adds a criterion.
   *
   * @param xfCriteriaOperator $crit The criterion
   */
  public function add(xfCriteriaOperator $crit, $mode = 1)
  {
    $this->operators[] = $crit;
  }

  /**
   * Returns all the operators.
   *
   * @returns array
   */
  public function getOperators()
  {
    return $this->operators;
  }

  /**
   * @see xfCriterion
   */
  public function breakdown()
  {
    return $this;
  }
}
