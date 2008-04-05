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
   * The encoding
   *
   * @var string
   */
  private $encoding = 'utf8';

  /**
   * Constructor to set initial values.
   *
   * @param string $name The field name
   * @param string $value The field value
   * @param string $encoding The value encoding (optional)
   */
  public function __construct($name, $value, $encoding = 'utf8')
  {
    $this->name = $name;
    $this->value = $value;
    $this->encoding = $encoding;
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
   * Gets the field encoding.
   *
   * @returns string
   */
  public function getEncoding()
  {
    return $this->encoding;
  }

  /**
   * @see xfCriterion
   */
  public function breakdown()
  {
    return $this;
  }
}
