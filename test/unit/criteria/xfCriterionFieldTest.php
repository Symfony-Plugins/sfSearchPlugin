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
require 'criteria/xfCriterionField.class.php';
require 'mock/criteria/xfMockCriterion.class.php';

$t = new lime_test(4, new lime_output_color);

$c = new xfCriterionField('name', 'Carl', 'ascii');
$t->is($c->getName(), 'name', '->getName() returns the name');
$t->is($c->getValue(), 'Carl', '->getValue() returns the value');
$t->is($c->getEncoding(), 'ascii', '->getEncoding() returns the encoding');
$t->is($c->breakdown(), $c, '->breakdown() returns itself (as it already is a fundamental)');
