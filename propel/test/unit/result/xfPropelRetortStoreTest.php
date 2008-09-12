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
require 'document/xfDocument.class.php';
require 'document/xfField.class.php';
require 'document/xfFieldValue.class.php';
require 'result/xfRetort.interface.php';
require 'result/xfPropelRetortRestore.class.php';
require 'result/xfDocumentHit.class.php';
require 'document/xfDocumentException.class.php';
autoloadPropel(13);
setupPropel('composite', 13);

$t = new lime_test(8, new lime_output_color);
$retort = new xfPropelRetortRestore;

$doc = new xfDocument('guid');
$doc->addField(new xfFieldValue(new xfField('_model', xfField::STORED), 'Composite'));
$doc->addField(new xfFieldValue(new xfField('key1', xfField::KEYWORD), 10));
$doc->addField(new xfFieldValue(new xfField('key2', xfField::KEYWORD), 20));
$hit = new xfDocumentHit($doc);

$t->diag('->can()');
$t->is($retort->can($hit, 'getPropelModel'), true, '->can() returns true if method matches');
$t->is($retort->can($hit, 'foobar'), false, '->can() returns false if method does not match');

$t->diag('->respond()');
$response = $retort->respond($hit, 'getPropelModel');
$t->isa_ok($response, 'Composite', '->respond() returns an instance of the model');
$t->is($response->getKey1(), 10, '->respond() returns the correct instance');
$t->is($response->getKey2(), 20, '->respond() returns the correct instance');

$doc->addField(new xfFieldValue(new xfField('Key1', xfField::KEYWORD), 11));
try {
  $msg = '->respond() fails if the row does not exist';
  $retort->respond($hit, 'getPropelModel');
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

$doc->addField(new xfFieldValue(new xfField('_model', xfField::STORED), 'BadModel'));
try {
  $msg = '->respond() fails if the model does not exist';
  $retort->respond($hit, 'getPropelModel');
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

$doc->addField(new xfFieldValue(new xfField('_model', xfField::STORED), 'MyModel'));
try {
  $msg = '->respond() fails the document is missing a primary key';
  $retort->respond($hit, 'getPropelModel');
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

