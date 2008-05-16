<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'util/xfTokenInterface.interface.php';
require 'util/xfToken.class.php';

$t = new lime_test(4, new lime_output_color);

$token = new xfToken('foobar', 5, 11);

$t->is($token->getText(), 'foobar', '->getText() returns the text');
$t->is($token->getStart(), 5, '->getStart() returns the start');
$t->is($token->getEnd(), 11, '->getEnd() returns the end');
$t->is($token->getLength(), 6, '->getLength() returns the length');
