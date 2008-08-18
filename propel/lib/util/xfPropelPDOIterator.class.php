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
final class xfPropelPDOIterator implements Iterator, Countable
{
  /**
   * The statement.
   *
   * @var PDOStatement
   */
  private $statement;

  /**
   * The model name.
   *
   * @var string
   */
  private $name;

  /**
   * The cursor position
   *
   * @var int
   */
  private $pos = 0;

  /**
   * The current row
   *
   * @var mixed
   */
  private $row;

  /**
   * The fake count.  We can't accurately count the number of results returned,
   * but we don't really need to either.  We just need to know if we have one or
   * more.  So, this count toggles between 0 and 1.
   *
   * @var int
   */
  private $count = 0;

  /**
   * Constructor to set initial values.
   *
   * @param string $name The model name
   * @param PDOStatement $statement The statement
   */
  public function __construct($name, PDOStatement $statement)
  {
    $this->name = $name;
    $this->statement = $statement;

    $this->row = $this->statement->fetch(PDO::FETCH_NUM);

    $this->count = $this->valid() ? 1 : 0;
  }

  /**
   * Closes the cursor.
   */
  public function __destruct()
  {
    $this->statement->closeCursor();
  }

  /**
   * Counts the total number of rows.
   *
   * @returns int
   */
  public function count()
  {
    return $this->count;
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
    $model->hydrate($this->row);

    return $model;
  }

  /**
   * Returns the current key
   *
   * @returns int
   */
  public function key()
  {
    return $this->pos;
  }

  /**
   * Determines if it is valid.
   *
   * @returns bool True if vald, false otherwise
   */
  public function valid()
  {
    return $this->row ? true : false;
  }

  /**
   * Advances the pointer
   */
  public function next()
  {
    $this->pos++;

    $this->row = $this->statement->fetch(PDO::FETCH_NUM);
  }

  /**
   * Rewinds the pointer
   */
  public function rewind()
  {
    if ($this->pos > 0)
    {
      throw new xfException('xfPropelPDOIterator cannot rewind.');
    }
  }
}
