<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A simple form that just displays the search box and search button.
 *
 * If you wish to overload this class, create the class xfSimpleForm and extend
 * this class.
 *
 * @package sfSearch
 * @subpackage Form
 * @author Carl Vondrick
 */
abstract class xfSimpleFormBase extends xfForm
{
  /**
   * @see sfForm
   */
  public function configure()
  {
    $wschema = $this->getWidgetSchema();
    $wschema['query'] = new sfWidgetFormInput();

    $vschema = $this->getValidatorSchema();
    $vschema['query'] = new sfValidatorString(array('required' => true));
    $vschema['page'] = new sfValidatorInteger(array('required' => false, 'empty_value' => 1));
  }

  /**
   * @see xfForm
   */
  public function getCriterion()
  {
    return new xfCriterionString($this->getValue('query'), xfCriterionString::FAILSAFE);
  }

  /**
   * @see xfForm
   */
  public function getPageNumber()
  {
    $value = $this->getValue('page');

    return $value ? $value : 1;
  }

  /**
   * @see xfForm
   */
  public function getUrlFormat()
  {
    $url = '?';
    $values = array_merge($this->getValues(), array('page' => '%page%'));

    foreach ($values as $key => $value)
    {
      $key = urlencode(sprintf($this->getWidgetSchema()->getNameFormat(), $key));
      $url .= $key . '=' . $value . '&amp;';
    }

    return $url;
  }
}
