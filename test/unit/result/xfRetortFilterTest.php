<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'result/xfRetort.interface.php';
require 'result/xfRetortFilter.class.php';
require 'result/xfRetortFilterCallback.interface.php';
require 'result/xfResultException.class.php';
require 'mock/result/xfMockRetort.class.php';
require 'mock/result/xfMockRetortFilterCallback.class.php';
require 'document/xfDocument.class.php';

$doc = new xfDocument('guid');

$t = new lime_test(6, new lime_output_color);

$t->diag('->can()');
$wrapped = new xfMockRetort;
$retort = new xfRetortFilter($wrapped);
$t->ok($retort->can($doc, 'getFoo'), '->can() wraps the internal retort');
$wrapped->can = false;
$t->ok(!$retort->can($doc, 'getFoo'), '->can() wraps the internal retort');

$t->diag('->respond() - no callable');
$wrapped = new xfMockRetort;
$retort = new xfRetortFilter($wrapped);
$t->is($retort->respond($doc, 'getFoo'), 42, '->respond() wraps the internal retort');

$t->diag('->respond() - php callable');
$retort->registerFilter('md5');
$retort->registerFilter('strtoupper');
$t->is($retort->respond($doc, 'getFoo'), strtoupper(md5(42)), '->respond() filters response with registered php callable filters in order');

$t->diag('->respond() - xfRetortFilterCallback callable');
$wrapped = new xfMockRetort;
$retort = new xfRetortFilter($wrapped);
$retort->registerFilter(new xfMockRetortFilterCallback);
$t->is($retort->respond($doc, 'getFoo'), md5(42), '->respond() filters response with registered xfRetortFilterCallback filters');

$t->diag('->registerFilter() - invalid callable');
$wrapped = new xfMockRetort;
$retort = new xfRetortFilter($wrapped);
try {
  $msg = '->registerFilter() fails if filter is invalid';
  $retort->registerFilter(array());
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

