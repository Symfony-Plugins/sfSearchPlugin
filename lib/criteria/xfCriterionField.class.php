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
final class xfCriterionField extends xfCriterionDecorator
{
  /**
   * The fields it must match on.
   *
   * @var array
   */
  private $fields = array();

  /**
   * Constructor to set initial values.
   *
   * @param xfCriterion $criterion The criterion that must match this field.
   * @param string|array $fields The field or fields that the criterion must match
   */
  public function __construct(xfCriterion $criterion, $fields)
  {
    parent::__construct($criterion);
    
    if (is_string($fields))
    {
      $fields = array($fields);
    }
    
    $this->fields = $fields;
  }

  /**
   * Gets the fields
   *
   * @returns array
   */
  public function getFields()
  {
    return $this->fields;
  }

  /**
   * @see xfCriterion
   */
  public function toString()
  {
    if (count($this->fields) == 1)
    {
      return 'FIELD {' . $this->fields[0] . ' IS ' . $this->getCriterion()->toString() . '}';
    }

    return 'FIELD {' . implode($this->fields, ', ') . ' ARE ' . $this->getCriterion()->toString() . '}';
  }

  /**
   * @see xfCriterion
   */
  public function translate(xfCriterionTranslator $translator)
  {
    $this->openFields($this->fields);

    $this->getCriterion()->translate($translator);

    $this->closeFields();
  }
}
