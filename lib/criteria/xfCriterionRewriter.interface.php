<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Interface for criterion rewriters.
 *
 * @package sfSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 */
interface xfCriterionRewriter
{
  /**
   * Creates a field query.
   *
   * @param string $name The field name
   * @param string $value The field value
   * @returns mixed
   */
  public function createField($name, $value);

  /**
   * Creates a boolean query.
   *
   * @param array $queries The subqueries
   * @returns mixed
   */
  public function createBoolean(array $queries);

  /**
   * Parses a query string query.
   *
   * @param string $query The query
   * @param string $encoding The encoding
   * @throws Exception if parsing fails
   * @returns mixed
   */
  public function parse($query, $encoding = 'utf8');

  /**
   * Attempts to fix the query from parse errors, but the new query may not be a
   * helpful query and may even still have errors.
   *
   * @param string $query The query
   * @param string $encding The encoding
   * @returns string
   */
  public function fixParseErrors($query, $encoding = 'utf8');
}
