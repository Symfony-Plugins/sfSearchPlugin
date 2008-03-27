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
require 'criteria/xfCriterionToken.class.php';
require 'mock/criteria/xfMockCriteria.class.php';
require 'mock/criteria/xfMockCriterionRewriter.class.php';

$t = new lime_test(6, new lime_output_color);

$mock = new xfMockCriteria;
$c = new xfCriteria;

$t->diag('->add(), ->getCriterions()');
$t->is(count($c->getCriterions()), 0, '->getCriterions() is empty initially');
$c->add($mock);
$t->is($c->getCriterions(), array($mock), '->getCriterions() returns the criterions');

$t->diag('->tokenize()');
$c->add($mock);
$t->is(count($c->tokenize('foo')), 2, '->tokenize() returns tokens from all the criterions');

$t->diag('->rewrite()');
$response = $c->rewrite(new xfMockCriterionRewriter);
$t->is($response->type, 'boolean', '->rewrite() creates a boolean query');
$t->ok($mock->rewriten, '->rewrite() rewrites the subqueries');
$t->is(count($response->options), 2, '->rewrite() rewrites each subquery');
