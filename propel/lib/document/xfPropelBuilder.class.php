<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The Propel builder to generate xfDocument's from Propel objects.
 *
 * @package sfPropelSearch
 * @subpackage Builder
 * @author Carl Vondrick
 */
final class xfPropelBuilder implements xfBuilder
{
  /**
   * The fields to build on.
   *
   * @var array
   */
  private $fields = array();

  /**
   * Constructor to store fields
   *
   * @param array $fields The fields to index
   */
  public function __construct(array $fields = array())
  {
    $this->addFields($fields);
  }

  /**
   * @see xfBuilder
   */
  public function build($input, xfDocument $doc)
  {
    if (!($input instanceof BaseObject))
    {
      throw new xfException("Input must be a Propel model.");
    }

    foreach ($this->fields as $getter => $field)
    {
      $doc->addField(new xfFieldValue($field, $input->$getter()));
    }

    $doc->addField(new xfFieldValue(new xfField('_model', xfField::STORED), get_class($input)));

    return $doc;
  }

  /**
   * Adds a field to be indexed.
   *
   * If no getter is passed, it will derivied from the field name.
   *
   * @param xfField $field The field
   * @param string $getter The getter for this field (optional)
   */
  public function addField(xfField $field, $getter = null)
  {
    if ($getter === null)
    {
      $getter = 'get' . ucfirst(xfToolkit::camelize($field->getName()));
    }

    $this->fields[$getter] = $field;
  }

  /**
   * Adds multiple fields.
   *
   * The index is the getter. If the index is an integer, then the getter is derivied.
   *
   * @param array $fields
   */
  public function addFields(array $fields)
  {
    foreach ($fields as $getter => $field)
    {
      if (is_int($getter))
      {
        $getter = null;
      }

      $this->addField($field, $getter);
    }
  }
}
