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
  public function translate(xfCriterionTranslator $translator)
  {
    if (count($this->criterions) > 0)
    {
      $translator->openBoolean();

      foreach ($this->criterions as $crit)
      {
        $translator->openBooleanItem();
        $crit->translate($translator);
        $translator->closeBooleanItem();
      }

      $translator->closeBoolean();
    }
  }

  /**
   * @see xfCriterion
   */
  public function toString()
  {
    $string = 'BOOLEAN {';

    if (count($this->criterions) > 0)
    {
      foreach ($this->criterions as $crit)
      {
        $string .= '[' . $crit->toString() . '] AND ';
      }

      $string = substr($string, 0, -5);
    }

    return $string . '}';
  }
}
