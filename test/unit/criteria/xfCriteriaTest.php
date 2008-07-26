<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'criteria/xfCriterion.interface.php';
require 'criteria/xfCriteria.class.php';
require 'criteria/xfCriterionTerm.class.php';
require 'criteria/xfCriterionTranslator.interface.php';
require 'criteria/xfCriterionTranslatorString.class.php';

$t = new lime_test(3, new lime_output_color);

$c = new xfCriteria;
$c->add(new xfCriterionTerm('foobar'));
$c->add(new xfCriterionTerm('baz'));

$t->is(count($c->getCriterions()), 2, '->add() adds criterions to the boolean query');
$t->is($c->toString(), 'BOOLEAN {[foobar] AND [baz]}', '->toString() returns a string representation');

$trans = new xfCriterionTranslatorString;
$c->translate($trans);

$t->is($trans->getString(), '{{ foobar baz }}', '->translate() translates the query');

