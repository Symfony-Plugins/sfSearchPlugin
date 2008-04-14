<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require_once dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'index/xfIndex.class.php';
require 'service/xfService.class.php';
require 'service/xfServiceRegistry.class.php';
require 'mock/service/xfMockIdentifier.class.php';
require 'mock/engine/xfMockEngine.class.php';
require 'document/xfDocument.class.php';
require 'document/xfField.class.php';
require 'document/xfFieldValue.class.php';
require 'mock/criteria/xfMockCriterionImplementer.class.php';
require 'result/xfResultIterator.class.php';
require 'result/xfDocumentHit.class.php';
require 'event/sfEvent.class.php';
require 'event/sfEventDispatcher.class.php';

class TestIndex extends xfIndex
{
  public $configured = false;

  protected function configure()
  {
    parent::configure();

    $this->configured = true;
  }
}

$t = new lime_test(14, new lime_output_color);
$dispatcher = new sfEventDispatcher;
$index = new TestIndex($dispatcher);

$t->diag('->get*(), ->set*(), ->setup()');
$t->is($index->getName(), 'TestIndex', '->getName() is initially the name of the class');
$index->setName('foobar');
$t->is($index->getName(), 'foobar', '->setName() changes the name');
$t->is($index->getEventDispatcher(), $dispatcher, '->getEventDispatcher() returns the dispatcher');
$t->isa_ok($index->getServiceRegistry(), 'xfServiceRegistry', '->getServiceRegistry() returns a service registry');
$registry = new xfServiceRegistry;
$index->setServiceRegistry($registry);
$t->is($index->getServiceRegistry(), $registry, '->setServiceRegistry() changes the service registry');
$engine = new xfMockEngine;
$index->setEngine($engine);
$t->is($index->getEngine(), $engine, '->setEngine() changes the engine');
$index->setup();
$t->ok($index->configured, '->setup() returns ->configure()');

$index = new TestIndex($dispatcher);
$registry = new xfServiceRegistry;
$registry->register(new xfService(new xfMockIdentifier));
$engine = new xfMockEngine;
$index->setServiceRegistry($registry);
$index->setEngine($engine);

$t->diag('->insert(), ->remove()');
$index->insert('foo');
$t->is(count($engine->getDocuments()), 1, '->insert() adds a document');
$index->remove('foo');
$t->is(count($engine->getDocuments()), 0, '->remove() deletes a document');

$t->diag('->optimize()');
$index->optimize();
$t->is($engine->optimized, 1, '->optimize() optimizes the engine');

$t->diag('->rebuild()');
$engine->add(new xfDocument('foo'));
$index->rebuild();
$t->is(count($engine->getDocuments()), 3, '->rebuild() erases the index and rebuilds all documents');

$t->diag('->find()');
$results = $index->find(new xfMockCriterion);
$t->isa_ok($results, 'xfResultIterator', '->find() returns an xfResultIterator');
$t->is($results->count(), 3, '->find() returns results that match');

$t->diag('->describe()');
$t->is($index->describe(), array('Engine' => 'Mock vINF'), '->describe() returns the engine\'s description');
