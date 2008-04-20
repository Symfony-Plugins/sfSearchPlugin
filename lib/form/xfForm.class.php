<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The base sfSearch form.
 *
 * @package sfSearch
 * @subpackage Form
 * @author Carl Vondrick
 */
abstract class xfForm extends sfForm
{
  /**
   * Gets a criteria object from the object.
   *
   * @returns xfCriterion
   */
  abstract public function getCriterion();

  /**
   * Gets the page number.
   *
   * @returns int
   */
  abstract public function getPageNumber();

  /**
   * Returns the URL format with %s in place of the page.
   *
   * @returns string
   */
  abstract public function getUrlFormat();
}
