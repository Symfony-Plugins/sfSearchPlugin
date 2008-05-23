<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A document to hold a collection of fields.
 *
 * @package sfSearch
 * @subpackage Document
 * @author Carl Vondrick
 */
final class xfDocument 
{
  /**
   * The fields registered.
   *
   * @var array
   */
  private $fields = array();

  /**
   * The document GUID
   *
   * @var string
   */
  private $guid;

  /**
   * The document boost.
   *
   * @var float
   */
  private $boost = 1.0;

  /**
   * The sub documents
   *
   * @var array
   */
  private $children = array();

  /**
   * Constructor to set initial values.
   *
   * @param string $guid The document GUID
   */
  public function __construct($guid)
  {
    $this->guid = $guid;
  }

  /**
   * Gets the document GUID
   *
   * @returns string
   */
  public function getGuid()
  {
    return $this->guid;
  }

  /**
   * Sets the document boost.
   *
   * @param float $boost The boost
   */
  public function setBoost($boost)
  {
    $this->boost = (float) $boost;
  }

  /**
   * Gets the document boost.
   *
   * @returns float
   */
  public function getBoost()
  {
    return $this->boost;
  }

  /**
   * Adds a child document.
   *
   * @param xfDocument $doc The child document
   */
  public function addChild(xfDocument $doc)
  {
    $this->checkCircularReference($doc);

    $this->children[$doc->getGuid()] = $doc;
  }

  /**
   * Checks for circular references and throws exception if found.
   *
   * @param xfDocument $child The child document
   * @throws xfDocumentException if circular reference found
   */
  private function checkCircularReference(xfDocument $child)
  {
    if ($child === $this)
    {
      throw new xfDocumentException('Circular reference detected: A child document cannot be the same instance as the parent');
    }
    
    foreach ($child->getChildren() as $grandchild)
    {
      $this->checkCircularReference($grandchild);
    }
  }

  /**
   * Gets all the children documents.
   *
   * @returns array
   */
  public function getChildren()
  {
    return $this->children;
  }

  /**
   * Adds a field to the document.
   *
   * @param xfFieldValue $fieldValue The field with a value
   */
  public function addField(xfFieldValue $fieldValue)
  {
    $this->fields[strtolower($fieldValue->getField()->getName())] = $fieldValue;
  }

  /**
   * Gets all the fields.
   *
   * @returns array
   */
  public function getFields()
  {
    return $this->fields;
  }

  /**
   * Gets a field by name.
   *
   * @param string $name The field name
   * @returns xfFieldValue The field
   */
  public function getField($name)
  {
    $name = strtolower($name);
    if (!isset($this->fields[$name]))
    {
      throw new xfDocumentException('Field ' . $name . ' not found in document');
    }

    return $this->fields[$name];
  }

  /**
   * Tests to see if a field exists.
   *
   * @param string $name The field name.
   * @returns bool true if exists, false otherwise
   */
  public function hasField($name)
  {
    return isset($this->fields[$name]);
  }
}
