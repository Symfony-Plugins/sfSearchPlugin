<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'criteria/xfCriterion.interface.php';
require 'criteria/xfPropelCriterionModelName.class.php';
require 'criteria/xfCriterionTranslator.interface.php';
require 'criteria/xfCriterionTranslatorString.class.php';

$t = new lime_test(3, new lime_output_color);

$trans = new xfCriterionTranslatorString;
$c = new xfPropelCriterionModelName('MyModel');
$c->translate($trans);

$t->is($trans->getString(), '_propel_model_name:+' . sha1('MyModel'), '->translate() creates a required query in the _propel_model_name field.');

$t->is($c->toString(), 'PROPEL_MODEL {MyModel}', '->toString() creates a string representation');

$t->is($c->optimize(), $c, '->optimize() returns itself');
