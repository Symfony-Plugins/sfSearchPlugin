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
require 'mock/criteria/xfMockCriteria.class.php';
require 'mock/criteria/xfMockCriterionRewriter.class.php';

$t = new lime_test(6, new lime_output_color);

$c = new xfCriterionField('name', 'Carl', xfCriterionField::WILDCARD | xfCriterionField::TOKENIZE);
$t->is($c->getName(), 'name', '->getName() returns the name');
$t->is($c->getValue(), 'Carl', '->getValue() returns the value');
$t->is($c->getMode(), xfCriterionField::WILDCARD | xfCriterionField::TOKENIZE, '->getMode() returns the mode');

$r = new xfMockCriterionRewriter;
$t->is($c->rewrite($r)->type, 'field', '->rewrite() rewrites as a field');
$t->is($c->rewrite($r)->options['name'], 'name', '->rewrite() rewrites with correct name');
$t->is($c->rewrite($r)->options['value'], 'Carl', '->rewrite() rewrites with correct value');

