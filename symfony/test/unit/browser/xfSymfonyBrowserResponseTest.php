<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'browser/xfSymfonyBrowserResponse.class.php';
require 'browser/xfSymfonyBrowserRequest.class.php';

$t = new lime_test(2, new lime_output_color);

$request = new xfSymfonyBrowserRequest('frontend', 'static', 'legal');
$response = new xfSymfonyBrowserResponse('foobar', $request);

$t->is($response->getRequest(), $request, '->getRequest() returns the request');
$t->is($response->getResponse(), 'foobar', '->getResponse() returns the response');
