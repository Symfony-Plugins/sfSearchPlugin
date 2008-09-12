<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'util/xfException.class.php';
require 'util/xfPropelPDOIterator.class.php';

autoloadPropel(13);
setupPropel('iterator', 13);

$t = new lime_test(10, new lime_output_color);

$c = new Criteria;
$c->setLimit(2);

$stmt = MyModelPeer::doSelectStmt($c);
$it = new xfPropelPDOIterator('MyModel', $stmt);

$t->is($it->count(), 1, '->count() returns 1 if rows were returned');

$it->rewind();
$t->is($it->key(), 0, '->key() starts at 0');
$t->isa_ok($it->current(), 'MyModel', '->current() returns the model');
$t->is($it->current()->getEyeColor(), 'Blue', '->current() hydrates the model');
$it->next();
$t->is($it->key(), 1, '->next() increases the key by 1');
$t->is($it->current()->getEyeColor(), 'Red', '->current() hydrates the new model');
$t->ok($it->valid(), '->valid() returns true if the row is valid');
$it->next();
$t->ok(!$it->valid(), '->valid() returns false if the row does not exist');

try {
  $msg = '->rewind() fails if not at start';
  $it->rewind();
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

$c = new Criteria;
$c->setLimit(1);
$c->setOffset(999999);
$stmt = MyModelPeer::doSelectStmt($c);
$it = new xfPropelPDOIterator('MyModel', $stmt);

$t->is($it->count(), 0, '->count() returns 0 if no rows were returned');
