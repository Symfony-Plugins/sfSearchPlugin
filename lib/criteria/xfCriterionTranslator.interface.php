<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A criterion translator is passed to a criterion object which is then
 * used to create a concrete criterion that the engine can understand.
 *
 * It is important for the translator to have no dependency on the xfCriterion
 * interface.
 *
 * Implementation suggestion: a stack should be created.
 *
 * @package sfSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 */
interface xfCriterionTranslator
{
  /**
   * Opens a new boolean query.
   */
  public function openBoolean();

  /**
   * Closes the current boolean query.
   */
  public function closeBoolean();

  /**
   * Opens a new item in a boolean query.
   */
  public function openBooleanItem();
  
  /**
   * Closes the current item in the boolean quer.
   */
  public function closeBooleanItem();

  /**
   * Sets these queries to have this boost.
   */
  public function openBoost($boost);

  /**
   * Closes the current boost.
   */
  public function closeBoost();

  /**
   * Opens a new requirement query.
   */
  public function openRequirement();

  /**
   * Closes a requirement query.
   */
  public function closeRequirement();

  /**
   * Opens a new negative query.
   */
  public function openNegate();

  /**
   * Closes the current negative query.
   */
  public function closeNegate();

  /**
   * Opens a new fields query.
   */
  public function openFields(array $fields);

  /**
   * Closes the current fields query.
   */
  public function closeFields();

  /**
   * Creates a phrase query.
   */
  public function createPhrase($phrase);

  /**
   * Creates a range query.
   */
  public function createRange($start, $end);

  /**
   * Creates a term query.
   */
  public function createTerm($term);

  /**
   * Creates a wildcard query.
   */
  public function createWildcard($pattern);
}
