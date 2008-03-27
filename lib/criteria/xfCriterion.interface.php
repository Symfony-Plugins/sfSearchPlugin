<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * An interface for criterions.
 *
 * @package sfSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 */
interface xfCriterion
{
  /**
   * Rewrites the query into fundamental elements that the engine can
   * understand.
   *
   * @param xfCriterionRewriter $rewriter 
   * @returns mixed
   */
  public function rewrite(xfCriterionRewriter $rewriter);

  /**
   * Tokenizes input to return token positions.
   *
   * @param string $input
   * @returns array
   */
  public function tokenize($input);
}
