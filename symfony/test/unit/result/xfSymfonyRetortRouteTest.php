<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'result/xfRetort.interface.php';
require 'result/xfSymfonyRetortRoute.class.php';
require 'result/xfDocumentHit.class.php';
require 'document/xfDocument.class.php';
require 'document/xfField.class.php';
require 'document/xfFieldValue.class.php';

$t = new lime_test(3, new lime_output_color);

$doc = new xfDocument('guid');
$doc->addField(new xfFieldValue(new xfField('symfony_route', xfField::STORED), 'frontend:module/action?key=value'));
$hit = new xfDocumentHit($doc);

$retort = new xfSymfonyRetortRoute;
$retort->setMethod('getSymfonyRoute');
$retort->setRouteFieldName('symfony_route');

$t->ok($retort->can($hit, 'getSymfonyRoute'), '->can() returns true if method matches');
$t->ok(!$retort->can($hit, 'foobar'), '->can() returns false if method does not match');

$t->is($retort->respond($hit, 'getSymfonyRoute'), 'module/action?key=value', '->respond() returns the route');
