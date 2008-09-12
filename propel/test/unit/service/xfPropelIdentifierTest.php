<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require dirname(__FILE__) . '/../../bootstrap/unit.php';
require 'util/xfException.class.php';
require 'service/xfIdentifier.interface.php';
require 'service/xfPropelIdentifier.class.php';
require 'util/xfPropelResourceIterator.class.php';
require 'util/xfPropelVersion.class.php';

autoloadPropel(12);
setupPropel('identifier', 12);

class MyOtherModel extends MyModel
{
}

$t = new lime_test(15, new lime_output_color);

$m = new MyModel;
$id = new xfPropelIdentifier('MyModel');

$t->diag('->getName()');
$t->is($id->getName(), 'propel-MyModel', '->getName() returns the name');

$t->diag('->getGuid()');
$t->isa_ok($id->getGuid($m), 'string', '->getGuid() returns a GUID');

$t->diag('->match()');
$t->is($id->match($m), xfIdentifier::MATCH_YES, '->match() matches valid models');
$t->is($id->match('Foo'), xfIdentifier::MATCH_NO, '->match() does not match invalid models');
$id->addValidator('shouldIndex');
$t->is($id->match($m), xfIdentifier::MATCH_YES, '->match() matches models with true validator callbacks');
$m->shouldIndex = false;
$t->is($id->match($m), xfIdentifier::MATCH_IGNORED, '->match() ignores models with false validator callbacks');
$t->is($id->match(new MyOtherModel), xfIdentifier::MATCH_NO, '->match() does not match via model inheritance');

$t->diag('->discover()');
$results = $id->discover(0);
$t->isa_ok($results, 'xfPropelResourceIterator', '->discover() returns a xfPropelResourceIterator');
$t->is($results->count(), 250, '->discover() limits results to 250');
$t->is($id->discover(4)->count(), 0, '->discover() returns an empty result if pager is done');

$c = new Criteria;
$c->add(MyModelPeer::EYE_COLOR, 'Blue');
$c->setLimit(50);
$id->setDiscoverCriteria($c);

$t->is($id->discover(0)->count(), 50, '->discover() acknowledges a predefined count');
$t->is($id->discover(50)->count(), 0, '->discover() returns empty result if pager is done with custom criteria');

$ok = true;
foreach ($id->discover(0) as $key => $obj)
{
  if ($obj->getEyeColor() != 'Blue')
  {
    $t->diag('Failed on ' . $key);
    $ok = false;
    break;
  }
}

$t->ok($ok, '->discover() uses the select criteria');

$id->setPeerSelectMethod('doSelect', xfPropelIdentifier::HYDRATE_COMPLETE);
$t->is($id->getPeerselectMethod(), 'doSelect', '->setPeerSelectMethod() changes the select method');
$t->isa_ok($id->discover(0), 'array', '->discover() acknowledges the select method');

