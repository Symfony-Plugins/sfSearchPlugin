<?php
/**
 * This file is part of the sfSymfonySearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'util/xfException.class.php';
require 'document/xfBuilder.interface.php';
require 'document/xfSymfonyBuilder.class.php';
require 'document/xfDocument.class.php';
require 'document/xfField.class.php';
require 'document/xfFieldValue.class.php';
require 'browser/xfSymfonyBrowser.interface.php';
require 'browser/xfSymfonyBrowserPluggable.class.php';
require 'browser/xfSymfonyBrowserRequest.class.php';
require 'browser/xfSymfonyBrowserResponse.class.php';
require 'util/xfSymfonyException.class.php';

$t = new lime_test(11, new lime_output_color);

$browser = new xfSymfonyBrowserPluggable('<html><head><title id="foo">This is a title</title></head><body id="body">This is the <strong>strong</strong> body</body></html>');
$document = new xfDocument('guid');

$builder = new xfSymfonyBuilder(null, null, null, $browser);

try {
  $msg = '->build() fails of input is not an instance of xfSymfonyBrowserRequest';
  $builder->build('foobar', $document);
  $t->fail($msg);
} catch (Exception $e) {
  $t->pass($msg);
}

$request = new xfSymfonyBrowserRequest('app', 'module', 'action', array('key' => 'value'));
$document = $builder->build($request, $document);

$t->isa_ok($document, 'xfDocument', '->build() returns an xfDocument');
$t->is($document->getField('title')->getValue(), 'This is a title', '->build() builds the title');
$t->is($document->getField('body')->getValue(), 'This is the strong body', '->build() builds the body and strips tags');
$t->is($document->getField('uri')->getValue(), 'app:module/action?key=value', '->build() builds the route');

$browser->setResponse('foo');
$document = $builder->build($request, new xfDocument('guid'));
$t->ok(!$document->hasField('title'), '->build() skips building title if a <title> tag cannot be found');
$t->ok(!$document->hasField('body'), '->build() skips building body if a <body> tag cannot be found');

$builder->setBrowser(new xfSymfonyBrowserPluggable('<html><head><title>foo</title></head><body>bar</body></html>'));
$builder->setTitleField(new xfField('subject', xfField::KEYWORD));
$builder->setBodyField(new xfField('description', xfField::KEYWORD));
$builder->setRouteField(new xfField('path', xfField::KEYWORD));

$document = $builder->build($request, new xfDocument('guid2'));
$t->ok($document->hasField('subject'), '->setTitleField() changes the title field');
$t->ok($document->hasField('description'), '->setBodyField() changes the body field');
$t->ok($document->hasField('path'), '->setRouteField() changes the route field');

class xfSymfonyBrowserSimple
{
  public function fetch(xfSymfonyBrowserRequest $request)
  {
    return new xfSymfonyBrowserResponse('<title>baz</title><body>bar</body>', $request);
  }
}

$builder = new xfSymfonyBuilder;
$t->is($builder->build($request, new xfDocument('guid'))->getField('title')->getValue(), 'baz', '->__construct() creates an xfSymfonyBrowserSimple as default');
