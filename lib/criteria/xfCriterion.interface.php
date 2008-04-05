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
   * Breaks down the criterion into fundamental pieces.
   *
   * @returns xfCriterion a broken down criterion that is part of the core
   */
  public function breakdown();
}
