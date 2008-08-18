<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A builder that adds the Propel model name.
 *
 * @package sfPropelSearch
 * @subpackage Builder
 * @author Carl Vondrick
 * @see xfPropelCriterionModelName
 */
final class xfPropelBuilderModelName implements xfBuilder
{
  /**
   * @see xfBuilder
   */
  public function build($input, xfDocument $doc)
  {
    $name = sha1(get_class($input)); // we must hash it because we do not want to return this value when a user does a query search

    $doc->addField(new xfFieldValue(new xfField('_propel_model_name', xfField::INDEXED), $name));
  }
}
