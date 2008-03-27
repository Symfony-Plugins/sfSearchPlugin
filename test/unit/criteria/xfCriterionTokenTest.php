<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'criteria/xfCriterionToken.class.php';

$t = new lime_test(3, new lime_output_color);

$token = new xfCriterionToken('foobar', 4, 10);
$t->is($token->getTokenText(), 'foobar', '->getTokenText() returns the text');
$t->is($token->getStart(), 4, '->getStart() returns the start');
$t->is($token->getEnd(), 10, '->getEnd() returns the end');
