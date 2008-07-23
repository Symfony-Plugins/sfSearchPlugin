<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A criterion that wraps another to signify that it CANNOT match.
 *
 * @package sfSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 */
final class xfCriterionNegate extends xfCriterionDecorator
{
  /**
   * @see xfCriterion
   */
  public function translate(xfCriterionTranslator $translator)
  {
    $translator->openNegate();

    $this->getCriterion()->translate($translator);

    $translator->closeNegate();
  }

  /**
   * @see xfCriterion
   */
  public function toString()
  {
    return 'NOT {' . parent::toString() . '}';
  }
}
