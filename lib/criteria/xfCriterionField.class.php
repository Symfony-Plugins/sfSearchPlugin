<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A criterion to require a field to match.
 *
 * @package sfSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 */
final class xfCriterionField implements xfCriterion
{
  /**
   * Flag to match exactly.
   */
  const EXACT = 1;

  /**
   * Flag to tokenize match first.
   */
  const TOKENIZE = 2;

  /**
   * Flag for non-wildcards.
   */
  const TAMECARD = 4;
  
  /**
   * Flag to allow wildcards (dependent on engine implementation)
   */
  const WILDCARD = 8;

  /**
   * The field name to search on.
   *
   * @var string
   */
  private $name;

  /**
   * The field value
   *
   * @var string
   */
  private $value;

  /**
   * The match mode
   *
   * @var int
   */
  private $mode;

  /**
   * Constructor to set initial values.
   *
   * @param string $name The field name
   * @param string $value The field value
   * @param int $mode The field mode (optional)
   */
  public function __construct($name, $value, $mode = 0)
  {
    $this->name = $name;
    $this->value = $value;
    $this->mode = $mode;
  }

  /**
   * Gets the field name.
   *
   * @returns string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Gets the field value.
   *
   * @returns string
   */
  public function getValue()
  {
    return $this->value;
  }

  /**
   * Gets the match mdoe.
   *
   * @returns int
   */
  public function getMode()
  {
    return $this->mode;
  }

  /**
   * @see xfCriterionRewriter
   */
  public function rewrite(xfCriterionRewriter $rewriter)
  {
    return $rewriter->createField($this->name, $this->value);
  }

  /**
   * @see xfCriterion
   */
  public function tokenize($input)
  {
  }
}
