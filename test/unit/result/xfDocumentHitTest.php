<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'document/xfDocument.class.php';
require 'result/xfDocumentHit.class.php';
require 'result/xfResultException.class.php';
require 'mock/criteria/xfMockCriterionImplementer.class.php';
require 'mock/result/xfMockRetort.class.php';

$t = new lime_test(10, new lime_output_color);

$document = new xfDocument('guid');
$criterion = new xfMockCriterionImplementer;
$hit = new xfDocumentHit($document, $criterion, array('score' => 0.2));

$t->diag('->getOption(), hasOption(), setOption()');
$t->is($hit->getOption('score'), 0.2, '->getOption() returns the option value');
$t->is($hit->getOption('foobar'), null, '->getOption() returns null for unset options');
$t->is($hit->getOption('foobar', 42), 42, '->getOption() returns the default for unset options');
$t->ok($hit->hasOption('score'), '->hasOption() returns true for options that exist');
$t->ok(!$hit->hasOption('foobar'), '->hasOption() returns false for options that do not exist');
$hit->setOption('foobar', 'baz');
$t->is($hit->getOption('foobar'), 'baz', '->getOption() returns the option value');

$t->diag('->getDocument(), ->getCriterion()');
$t->is($hit->getDocument(), $document, '->getDocument() returns the wrapped document');
$t->is($hit->getCriterion(), $criterion, '->getCriterion() returns the criterion');

$t->diag('->__call()');
$retort = new xfMockRetort;
$retort->can = false;
$hit->setRetorts(array($retort));
try {
  $msg = '->__call() throws exception when a retort is not found';
  $hit->getWhatever();
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}
$hit->setRetorts(array(new xfMockRetort));
$t->is($hit->getWhatever(), 42, '->__call() returns the retort response');
