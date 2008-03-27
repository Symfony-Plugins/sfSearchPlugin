<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A criterion for user entered input.
 *
 * @package sfSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 */
final class xfCriterionString implements xfCriterion
{
  /**
   * Flag to fail on invalid parses.
   */
  const FATAL = 1;

  /**
   * Flag to work around invalid parses.
   */
  const FAILSAFE = 2;

  /**
   * The querystring
   *
   * @var string
   */
  private $query;

  /**
   * The query parse mode.
   *
   * @var int
   */
  private $mode;

  /**
   * The query encodng.
   *
   * @var string
   */
  private $encoding;

  /**
   * Constructor to set initial values.
   *
   * @param string $query The query
   * @param int $mode The mode
   */
  public function __construct($query, $mode = 2, $encoding = 'utf8')
  {
    $this->query = $query;
    $this->mode = $mode;
    $this->encoding = $encoding;
  }

  /**
   * Gets the query.
   *
   * @returns string
   */
  public function getQuery()
  {
    return $this->query;
  }

  /**
   * Gets the query mode.
   *
   * @returns int
   */
  public function getMode()
  {
    return $this->mode;
  }

  /**
   * Gets the query encoding.
   *
   * @returns string
   */
  public function getEncoding()
  {
    return $this->encoding;
  }

  /**
   * @see xfCriterionRewriter
   */
  public function rewrite(xfCriterionRewriter $rewriter)
  {
    try
    {
      return $rewriter->parse($this->query, $this->encoding);
    }
    catch (Exception $e)
    {
      if ($this->mode & self::FAILSAFE)
      {
        $query = $rewriter->fixParseErrors($this->query);
        return $rewriter->parse($query, $this->encoding);
      }
      else
      {
        throw $e;
      }
    }
  }

  /**
   * @todo
   * @see xfCriterionRewriter
   */
  public function tokenize($input)
  {
  }
}
