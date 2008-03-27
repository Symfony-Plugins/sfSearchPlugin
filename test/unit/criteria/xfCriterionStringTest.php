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
require 'mock/criteria/xfMockCriteria.class.php';
require 'mock/criteria/xfMockCriterionRewriter.class.php';

$t = new lime_test(8, new lime_output_color);

$c = new xfCriterionString('foo');
$t->is($c->getQuery(), 'foo', '->getQuery() returns the query');
$t->is($c->getMode(), xfCriterionString::FAILSAFE, '->getMode() returns the parse mode');
$t->is($c->getEncoding(), 'utf8', '->getEncoding() returns the query encoding');

$r = new xfMockCriterionRewriter;
$t->is($c->rewrite($r)->type, 'parse', '->rewrite() rewrites as a parseable query');
$t->is($c->rewrite($r)->options['query'], 'foo', '->rewrite() rewrites with correct query');
$t->is($c->rewrite($r)->options['encoding'], 'utf8', '->rewrite() rewrites with correct encoding');

$r->parse_fail = true;
$t->isa_ok($c->rewrite($r), 'xfMockCriterionRewriterItem', '->rewrite() fixes parse errors by default');

$c = new xfCriterionString('foo', xfCriterionString::FATAL);
$r->parse_fail = true;
try {
  $msg = '->rewrite() fails if string contains parse errors and mode is FATAL';
  $c->rewrite($r);
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

