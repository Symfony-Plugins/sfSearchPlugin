<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'browser/xfSymfonyBrowserRequest.class.php';
require 'util/xfException.class.php';
require 'util/xfSymfonyException.class.php';

$t = new lime_test(30, new lime_output_color);

$params = array(
  'key' => 'value',
  'foo' => array('bar', 'baz')
);

$r = new xfSymfonyBrowserRequest('frontend', 'static', 'privacy', $params);

$t->is($r->getApplication(), 'frontend', '->getApplication() returns the application');
$t->is($r->getModule(), 'static', '->getModule() returns the module');
$t->is($r->getAction(), 'privacy', '->getAction() returns the action');
$t->is($r->getParameters(), $params, '->getParameters() returns the parameters');

$r->setParameter('a', 'b');
$params['a'] = 'b';
$t->is($r->getParameters(), $params, '->setParameter() sets a parameter');

$t->is($r->getQueryString(), '?key=value&foo[0]=bar&foo[1]=baz&a=b', '->getQueryString() returns the query string');

$t->is($r->getAsString(), 'frontend:static/privacy?key=value&foo[0]=bar&foo[1]=baz&a=b', '->getAsString() returns the request as a string');

$t->is($r->__toString(), 'frontend:static/privacy?key=value&foo[0]=bar&foo[1]=baz&a=b', '->__toString() returns the request as a string');

$r = new xfSymfonyBrowserRequest('public', 'mod', 'action', array('a' => array('b' => array('c' => 'd'), 'e' => 'f'), 'g' => 'h'));
$t->is($r->getQueryString(), '?a[b][c]=d&a[e]=f&g=h', '->getQueryString() deals with complex queries arrays');

$tests = array(
  'backend:show/all' => array('backend', 'show', 'all', array()),
  'backend:show/all?' => array('backend', 'show', 'all', array()),
  'backend:show/all?key=value' => array('backend', 'show', 'all', array('key' => 'value')),
  'backend:show/all?foo[]=bar&foo[]=baz' => array('backend', 'show', 'all', array('foo' => array('bar', 'baz')))
);

foreach ($tests as $string => $values)
{
  $r2 = xfSymfonyBrowserRequest::createFromString($string);
  $t->is($r2->getApplication(), $values[0], '::createFromString() parses the application correctly');
  $t->is($r2->getModule(), $values[1], '::createFromString() parses the module correctly');
  $t->is($r2->getAction(), $values[2], '::createFromString() parses the action correctly');
  $t->is_deeply($r2->getParameters(), $values[3], '::createFromString() parses the parameters correctly');
}

$invalid = array('foo', 'frontend/module/action', 'baz?foo=baz');

foreach ($invalid as $test)
{
  try {
    $msg = '::createFromString() fails if the string is invalid';
    xfSymfonyBrowserRequest::createFromString($test);
    $t->fail($msg);
  } catch (Exception $e) {
    $t->pass($msg);
  }
}

$r1 = new xfSymfonyBrowserRequest('app', 'mod', 'act', array('foo' => 'bar'));
$r2 = new xfSymfonyBrowserRequest('app', 'mod', 'act', array('foo' => 'bar'));
$r3 = new xfSymfonyBrowserRequest('app', 'mod', 'act', array('bar' => 'foo'));

$t->ok($r1->equals($r2), '->equals() returns true if the two requests are equal');
$t->ok(!$r1->equals($r3), '->equals() returns false if the two requests are not equal');
