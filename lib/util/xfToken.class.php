<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A token
 *
 * @package sfSearch
 * @subpackage Utilities
 * @author Carl Vondrick
 */
final class xfToken implements xfTokenInterface
{
  /**
   * The token text
   *
   * @var string
   */
  private $text;
  
  /**
   * The token start
   *
   * @var int
   */
  private $start;

  /**
   * The token end
   *
   * @var int
   */
  private $end;

  /**
   * Constructor
   *
   * @param string $text The token text
   * @param int $start The token start
   * @param int $end The token end
   */
  public function __construct($text, $start, $end)
  {
    $this->text = $text;
    $this->start = $start;
    $this->end = $end;
  }

  /**
   * Gets the text
   *
   * @returns string
   */
  public function getText()
  {
    return $this->text;
  }

  /**
   * Gets the start position
   *
   * @returns int
   */
  public function getStart()
  {
    return $this->start;
  }

  /**
   * Gets the end position
   *
   * @returns int
   */
  public function getEnd()
  {
    return $this->end;
  }

  /**
   * Gets the length
   *
   * @returns int
   */
  public function getLength()
  {
    return $this->end - $this->start;
  }
}
