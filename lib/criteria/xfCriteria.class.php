<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A common criteria to combine criterions.
 *
 * @package sfSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 */
final class xfCriteria implements xfCriterion
{
  /**
   * The registered criterions.
   *
   * @var array
   */
  private $criterions = array();

  /**
   * Adds a criterion.
   *
   * @param xfCriterion $crit The criterion
   */
  public function add(xfCriterion $crit)
  {
    $this->criterions[] = $crit;
  }

  /**
   * Returns all the criterions.
   *
   * @returns array
   */
  public function getCriterions()
  {
    return $this->criterions;
  }

  /**
   * @see xfCriterion
   */
  public function rewrite(xfCriterionRewriter $rewriter)
  {
    $queries = array();

    foreach ($this->criterions as $crit)
    {
      $queries[] = $crit->rewrite($rewriter);
    }

    return $rewriter->createBoolean($queries);
  }

  /**
   * @see xfCriterion
   */
  public function tokenize($input)
  {
    $tokens = array();

    foreach ($this->criterions as $crit)
    {
      $tokens = array_merge($tokens, $crit->tokenize($input));
    }

    return $tokens;
  }
}
