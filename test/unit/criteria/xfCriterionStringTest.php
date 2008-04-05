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
require 'criteria/xfCriterionString.class.php';
require 'mock/criteria/xfMockCriterion.class.php';

$t = new lime_test(4, new lime_output_color);

$c = new xfCriterionString('foo');
$t->is($c->getQuery(), 'foo', '->getQuery() returns the query');
$t->is($c->getMode(), xfCriterionString::FAILSAFE, '->getMode() returns the parse mode');
$t->is($c->getEncoding(), 'utf8', '->getEncoding() returns the query encoding');
$t->is($c->breakdown(), $c, '->breakdown() returns itself (as it already is a fundamental)');
