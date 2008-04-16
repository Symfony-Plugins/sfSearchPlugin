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
}
