<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A criterion that wraps another to signify that it MUST match.
 *
 * @package sfSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 */
final class xfCriterionRequirement extends xfCriterionDecorator
{
  public function toString()
  {
    return 'MUST {' . parent::toString() . '}';
  }

  /**
   * @see xfCriterion
   */
  public function translate(xfCriterionTranslator $translator)
  {
    $translator->createRequirement();

    $this->getCriterion()->translate($translator);

    $translator->closeRequirement();
  }
}

