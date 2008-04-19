<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'index/xfIndexManager.class.php';
require 'mock/index/xfMockIndex.class.php';
require 'event/sfEventDispatcher.class.php';
require 'util/xfException.class.php';

$dispatcher = new sfEventDispatcher;

$t = new lime_test(null, new lime_output_color);

try {
  $msg = '->getIndex() fails if manager has not been initialized';
  xfIndexManager::get('foobar');
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

xfIndexManager::initialize($dispatcher);

$index = xfIndexManager::get('xfMockIndex');
$t->isa_ok($index, 'xfMockIndex', '->getIndex() retuns an instance of the index');
$t->ok($index === xfIndexManager::get('xfMockIndex'), '->getIndex() is a singleton method');
$t->ok($index->configured, '->getIndex() runs ->setup()');

try {
  $msg = '->getIndex() fails if index does not inherit xfIndex';
  xfIndexManager::get('Exception');
  $t->fail($msg);
} catch (Exception $e)
{
  $t->pass($msg);
}