<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A resource iterator of the responses.
 *
 * @package sfPropelSearch
 * @subpackage Utilities
 * @author Carl Vondrick
 */
final class xfPropelResourceIterator implements Iterator, Countable
{
  /**
   * The results.
   *
   * @var ResultSet
   */
  private $results;

  /**
   * The model name.
   *
   * @var string
   */
  private $name;

  /**
   * Constructor to set initial values.
   *
   * @param string $name The model name
   * @param ResultSet $results The results
   */
  public function __construct($name, ResultSet $results)
  {
    $this->name = $name;
    $this->results = $results;
  }

  /**
   * The destructor to close the ResultSet
   */
  public function __destruct()
  {
    $this->results->close();
  }

  /**
   * Counts the total number of rows.
   *
   * @returns int
   */
  public function count()
  {
    return $this->results->getRecordCount();
  }

  /**
   * Gets the current result by hydrating it on demand.
   *
   * @returns BaseObject The model
   */
  public function current()
  {
    $name = $this->name;
    $model = new $name;
    $model->hydrate($this->results);

    return $model;
  }

  /**
   * Returns the current key
   *
   * @returns int
   */
  public function key()
  {
    return $this->results->getCursorPos();
  }

  /**
   * Determines if it is valid.
   *
   * @returns bool True if vald, false otherwise
   */
  public function valid()
  {
    return !$this->results->isAfterLast();
  }

  /**
   * Advances the pointer
   */
  public function next()
  {
    $this->results->next();
  }

  /**
   * Rewinds the pointer
   */
  public function rewind()
  {
    $this->results->first();
  }
}
