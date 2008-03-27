<?php

$doc = new xfDocument('guid');
$doc->addField(new xfFieldValue(new xfField('title', xfField::KEYWORD), 'Test title'));

$engine = new xfLuceneEngine(dirname('dd'));
$engine->add($doc);

$service = new xfService('name', new xfPropelIdentifier('Forum'));
$service->addBuilder(new xfPropelBuilder(array(new xfField('title', xfField::TEXT))));
$service->addRetort(new xfPropelRetort);

$registry = new xfServiceRegistry;
$registry->register($service);
$registry->locate(new ForumModel) === $service;
$registry->reverseLocate(new xfEngineHit);

$c = new xfCriteria;
$c->add(new xfCriterionString('foo', xfCriterionString::SAFE));
$c->add(new xfCriterionWrapper(new Zend_Search_Lucene_Search_Query));
$c->rewrite(new xfLuceneCriterionRewriter); // not public, used to rewrite into fundamental query for engine

foreach ($engine->find($criteria) as $hit)
{
  echo $hit->getField('title');
}

$system = new xfSystem(new sfEventDispatcher);
$results = $system->getIndex('english')->find($criteria) instanceof xfResults;

foreach ($results as $result)
{
  $result instanceof xfResult === true;

  $result->getPropelModel() instanceof Forum === true;
  $result->getName(); // calls retort
}


