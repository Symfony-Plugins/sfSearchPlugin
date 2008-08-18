<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'service/xfIdentifier.interface.php';
require 'service/xfSymfonyIdentifier.class.php';
require 'browser/xfSymfonyBrowserRequest.class.php';
require 'util/xfSymfonyException.class.php';
require 'event/sfEventDispatcher.class.php';

$t = new lime_test(20, new lime_output_color);

$id = new xfSymfonyIdentifier('frontend', 'static');

$t->diag('->discover(), ->addRequest(), ->addRequests(), ->addAction()');

$r1 = new xfSymfonyBrowserRequest('frontend', 'static', 'tos', array('page' => 1));
$r2 = new xfSymfonyBrowserRequest('frontend', 'static', 'tos', array('page' => 2));
$r3 = new xfSymfonyBrowserRequest('frontend', 'static', 'privacy');

$t->is(count($id->discover(0)), 0, '->discover() is empty initially');

$t->is($id->addRequests(array($r1, $r2)), $id, '->addRequests() returns $this');
$t->is($id->addRequest($r3), $id, '->addRequest() returns $this');

$t->is($id->discover(0), array($r1, $r2, $r3), '->addRequests(), ->addRequest() add requests');

$t->is($id->addAction('aup', array('verbose' => true)), $id, '->addAction() returns $this');
$results = $id->discover(0);
$t->is($results[3]->getApplication(), 'frontend', '->addAction() configures a result with the correct application');
$t->is($results[3]->getModule(), 'static', '->addAction() configures a result with the correct module');
$t->is($results[3]->getAction(), 'aup', '->addAction() configures a result with the correct action');
$t->is($results[3]->getParameters(), array('verbose' => true), '->addAction() configures a result with the correct parameters');

try {
  $msg = '->addRequest() fails if request is not in the application';
  $id->addRequest(new xfSymfonyBrowserRequest('foobar', 'static', 'action'));
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

try {
  $msg = '->addRequest() fails if request is not in the module';
  $id->addRequest(new xfSymfonyBrowserRequest('frontend', 'blog', 'action'));
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

$t->is($id->discover(1), array(), '->discover() returns an empty array if pager is greater than 0');

$t->diag('->getName(), ->setName()');
$t->is($id->getName(), 'symfony-frontend-static', '->getName() returns a default name');
$id->setName('foobar');
$t->is($id->getName(), 'foobar', '->setName() changes the name');

$t->diag('->getGuid()');
$t->is($id->getGuid($r1), 's' . sha1('frontend:static/tos?page=1'), '->getGuid() generates a guid');

$t->diag('->match()');
$t->is($id->match('foo'), xfIdentifier::MATCH_NO, '->match() does not match for non xfSymfonyBrowserRequest instances');
$t->is($id->match(new xfSymfonyBrowserRequest('foobar', 'static', 'action')), xfIdentifier::MATCH_NO, '->match() does not match for requests outside of the application');
$t->is($id->match(new xfSymfonyBrowserRequest('frontend', 'baz', 'action')), xfIdentifier::MATCH_NO, '->match() does not match for requests outside of the module');
$t->is($id->match(new xfSymfonyBrowserRequest('frontend', 'static', 'foobar')), xfIdentifier::MATCH_NO, '->match() does not match for requests that are not registered');
$t->is($id->match(new xfSymfonyBrowserRequest('frontend', 'static', 'privacy')), xfIdentifier::MATCH_YES, '->match() matches for requests that are registered');
