<?php

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'result/xfRetort.interface.php';
require 'result/xfRetortField.class.php';
require 'result/xfDocumentHit.class.php';
require 'document/xfDocument.class.php';
require 'document/xfField.class.php';
require 'document/xfFieldValue.class.php';
require 'mock/criteria/xfMockCriteria.class.php';

$doc = new xfDocument('guid');
$doc->addField(new xfFieldValue(new xfField('name', xfField::KEYWORD), 'carl'));
$hit = new xfDocumentHit($doc, new xfMockCriteria);

$t = new lime_test(4, new lime_output_color);

$retort = new xfRetortField;

$t->diag('->can()');
$t->ok($retort->can($hit, 'getName'), '->can() returns true if method matches a field in the document');
$t->ok(!$retort->can($hit, 'getFoo'), '->can() returns false if method does not match a field in the document');
$t->ok(!$retort->can($hit, 'fetchName'), '->can() returns false if method is invalid syntax');

$t->diag('->respond()');
$t->is($retort->respond($hit, 'getName'), 'carl', '->respond() returns the field response');
