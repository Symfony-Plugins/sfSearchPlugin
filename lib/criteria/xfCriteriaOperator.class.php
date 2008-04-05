<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A criteria operator controls how criterions are combined together.
 *
 * @package sfSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 */
final class xfCriteriaOperator
{
  /**
   * Match mode for MUST
   */
  const MUST = 1;

  /**
   * Match mode for SHOULD
   */
  const SHOULD = 2;

  /**
   * Match mode for CANNOT
   */
  const CANNOT = 4;

  /**
   * The wrapped criterion.
   *
   * @var xfCriterion
   */
  private $criterion;

  /**
   * The mode of the criterion
   *
   * @var int
   */
  private $mode;

  /**
   * The constructor set the criteria.
   *
   * @param xfCriterion $crit The criteria
   * @param int $mode The match mode
   */
  public function __construct(xfCriterion $crit, $mode = 1)
  {
    $this->wrapped = $crit;
    $this->mode = (int) $mode;
  }

  /**
   * Gets the wrapped criterion
   *
   * @returns xfCriterion
   */
  public function getCriterion()
  {
    return $this->wrapped;
  }

  /**
   * Gets the match mode
   *
   * @returns int
   */
  public function getMode()
  {
    return $this->mode;
  }
}
