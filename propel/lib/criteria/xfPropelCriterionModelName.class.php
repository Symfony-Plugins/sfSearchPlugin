<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A criterion to restrict results by model.
 *
 * @package sfPropelSearch
 * @subpackage Criteria
 * @author Carl Vondrick
 * @see xfPropelBuilderModelName
 */
final class xfPropelCriterionModelName implements xfCriterion
{
  /**
   * The model to use only.
   *
   * @var string
   */
  private $model;

  /**
   * Constructor to set model.
   *
   * @param string $model
   */
  public function __construct($model)
  {
    $this->model = $model;
  }

  /**
   * @see xfCriterion
   */
  public function translate(xfCriterionTranslator $translator)
  {
    $translator->setNextRequired();
    $translator->setNextField('_propel_model_name');
    $translator->createTerm(sha1($this->model));
  }

  /**
   * @see xfCriterion
   */
  public function toString()
  {
    return 'PROPEL_MODEL {' . $this->model . '}';
  }

  /**
   * @see xfCriterion
   */
  public function optimize()
  {
    return $this;
  }
}
