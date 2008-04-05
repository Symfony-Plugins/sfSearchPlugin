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
require 'criteria/xfCriteriaOperator.class.php';
require 'mock/criteria/xfMockCriterion.class.php';

$t = new lime_test(3, new lime_output_color);

$mock = new xfMockCriterion;
$c = new xfCriteria;

$t->diag('->add(), ->getOperators()');
$t->is(count($c->getOperators()), 0, '->getOperators() is empty initially');
$c->add(new xfCriteriaOperator($mock));
$t->is($c->getOperators(), array(new xfCriteriaOperator($mock)), '->getOperators() returns the criterions');
$t->is($c->breakdown(), $c, '->breakdown() returns itself (as it already is a fundamental)');
