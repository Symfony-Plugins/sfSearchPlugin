<?php
/**
 * This file is part of the sfCachedSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'engine/xfEngine.interface.php';
require 'engine/xfEngineDecorator.class.php';
require 'engine/xfCachedEngine.class.php';
require 'mock/engine/xfMockEngine.class.php';
require 'document/xfDocument.class.php';
require 'criteria/xfCriterion.interface.php';
require 'criteria/xfCriterionTerm.class.php';
require 'result/xfDocumentHit.class.php';
require 'cache/sfCache.class.php';
require 'cache/sfFileCache.class.php';

$t = new lime_test(10, new lime_output_color);

$real = new xfMockEngine;
$real->add(new xfDocument('foo'));

$cache = new sfFileCache(array('lifetime' => 1, 'cache_dir' => realpath(dirname(__FILE__) . '/../../sandbox')));
$cache->clean(sfCache::ALL);

$cengine = new xfCachedEngine($real, $cache);
$t->is($cengine->getCache(), $cache, '->getCache() returns the cache');

$query = new xfCriterionTerm('foobar');
$key = sha1($query->toString());

$t->ok(!$cache->has($key), 'cache is empty');

$cengine->find($query);
$t->ok($cache->has($key), '->find() adds an element to the cache');

$real->add(new xfDocument('bar'));
$t->is(count($cengine->find($query)), 1, '->find() retrieves from the cache');
$t->is(count($cengine->find(new xfCriterionTerm('baz'))), 2, '->find() does not retrieve from cache if unseen query');

$t->diag('sleeping 1 second');
sleep(1);
$t->is(count($cengine->find($query)), 2, '->find() acknowledges the cache lifetime');

$real->add(new xfDocument('sf'));
$t->diag('sleeping 1 second');
sleep(1);
$cengine->optimize();
$t->is(count($cengine->find($query)), 3, '->optimize() clears old cache entries');

$cengine->erase();
$t->ok(!$cache->has($key), '->erase() clears the cache');

$t->isa_ok($cengine->describe(), 'array', '->describe() produces an array');

$t->is($cengine->id(), 'cached_mock', '->id() produces an ID');

$cache->clean(sfCache::ALL);
