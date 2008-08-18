<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../bootstrap/functional.php';
require 'browser/xfSymfonyBrowserRequest.class.php';
require 'browser/xfSymfonyBrowserResponse.class.php';
require 'browser/xfSymfonyBrowser.interface.php';
require 'browser/xfSymfonyBrowserSimple.class.php';
bootstrap('frontend');
require 'browser/xfSymfonyBrowserRenderingFilter.class.php';

$t = new lime_test(11, new lime_output_color);

$browser = new xfSymfonyBrowserSimple;
$request = new xfSymfonyBrowserRequest('frontend', 'legal', 'privacyPolicy');
$response = $browser->fetch($request);
$t->like($response->getResponse(), '/Privacy Policy/', '->fetch() launches a request');
$t->is($response->getRequest(), $request, '->fetch() binds the response to the requst');
$t->ok(false === stripos($response->getResponse(), 'sfWebDebug'), '->fetch() configures the environment correctly');

$request = new xfSymfonyBrowserRequest('backend', 'static', 'index');
$response = $browser->fetch($request);
$t->like($response->getResponse(), '/backend module/', '->fetch() can handle different applications');

$request = new xfSymfonyBrowserRequest('frontend', 'legal', 'termsOfService', array('name' => 'Carl Vondrick'));
$response = $browser->fetch($request);
$t->like($response->getResponse(), '/Carl Vondrick/', '->fetch() uses query strings');

$request = new xfSymfonyBrowserRequest('frontend', 'legal', 'privacyPolicy');
$response = $browser->fetch($request);

$browser->setHostName('hostname');
$browser->setServername('servername');
$browser->setRemoteAddress('127.42.42.42');
$browser->setMethod(xfSymfonyBrowserSimple::POST);
$browser->setEnvironment('dev');
$request = new xfSymfonyBrowserRequest('frontend', 'dump', 'index');
$response = $browser->fetch($request)->getResponse();

preg_match('/\[REQUEST\](.*?)\[\/REQUEST\]/s', $response, $matches);
$request = unserialize($matches[1]);

$t->is($request->getUri(), 'http://hostname/index.php/dump/index?', '->fetch() configures the request object URI correctly');
$t->is($request->getPathInfo(), '/dump/index', '->fetch() configures the request path info correctly');
$t->is($request->getHost(), 'hostname', '->fetch() configures the request host correctly');
$t->is($request->getScriptName(), '/index.php', '->fetch() configures the script name');
$t->ok($request->isMethod('post'), '->fetch() configures the method correctly');

$t->ok(false !== stripos($response, 'sfWebDebug'), '->fetch() configures the environment correctly');
