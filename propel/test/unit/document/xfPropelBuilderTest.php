<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'document/xfBuilder.interface.php';
require 'document/xfPropelBuilder.class.php';
require 'document/xfDocument.class.php';
require 'document/xfField.class.php';
require 'document/xfFieldValue.class.php';
require 'util/xfException.class.php';
require 'util/xfToolkit.class.php';
autoloadPropel(12);

$t = new lime_test(6, new lime_output_color);

$doc = new xfDocument('guid');

$builder = new xfPropelBuilder(array(new xfField('name', xfField::KEYWORD), new xfField('eye_color', xfField::TEXT)));

$m = new MyModel;
$m->setName('carl');
$m->setEyeColor('blue');

$response = $builder->build($m, $doc);

$t->isa_ok($response, 'xfDocument', '->build() returns an xfDocument');
$t->is($response->getField('name')->getValue(), 'carl', '->build() indexes the model');
$t->is($response->getField('eye_color')->getValue(), 'blue', '->build() handles camel case correctly');
$t->is($response->getField('_model')->getValue(), 'MyModel', '->build() stores the model name');

$builder = new xfPropelBuilder;
$builder->addField(new xfField('foo', xfField::TEXT), 'getEyeColor');
$t->is($builder->build($m, new xfDocument('guid'))->getField('foo')->getValue(), 'blue', '->addField() can override the getter');

try {
  $msg = '->build() fails in input is not a Propel model';
  $builder->build('foo', $doc);
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

