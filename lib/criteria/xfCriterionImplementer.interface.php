<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A criterion implementer that binds criterions to the engine implementation.
 *
 * @package sfSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 */
interface xfCriterionImplementer
{
  /**
   * Gets the abstract criterion
   *
   * @returns xfCriterion
   */
  public function getAbstractCriterion();

  /**
   * Gets the concrete criterion
   *
   * @returns mixed
   */
  public function getConcreteCriterion();

  /**
   * Tokenizes the input to see what it matched.
   *
   * @returns array of xfCriterionToken
   */
  public function tokenize($input);
}
