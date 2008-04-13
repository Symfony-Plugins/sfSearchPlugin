<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * An index that manages services and controls indexing.
 *
 * @package sfSearch
 * @subpackage Index
 * @author Carl Vondrick
 */
abstract class xfIndex 
{
  /**
   * The event dispatcher.
   *
   * @var sfEventDispatcher 
   */
  private $dispatcher;

  /**
   * The service registry.
   *
   * @var xfServiceRegistry
   */
  private $registry;

  /**
   * The backend search engine.
   *
   * @var xfEngine
   */
  private $engine;

  /**
   * The name of this index.
   *
   * @var string
   */
  private $name;

  /**
   * Constructor to configure an index.
   *
   * @param sfEventDispatcher $dispatcher The dispatcher
   */
  final public function __construct(sfEventDispatcher $dispatcher)
  {
    $this->dispatcher = $dispatcher;
    $this->registry = new xfServiceRegistry;
    $this->name = get_class($this);
  }

  /**
   * Sets the index name.
   *
   * @param string $name
   */
  final public function setName($name)
  {
    $this->name = $name;
  }

  /**
   * Gets the index name.
   *
   * @returns string
   */
  final public function getName()
  {
    return $this->name;
  }

  /**
   * Gets the event dispatcher.
   *
   * @returns sfEventDispatcher
   */
  final public function getEventDispatcher()
  {
    return $this->dispatcher;
  }

  /**
   * Sets the service registry.
   *
   * @param xfServiceRegistry $registry
   */
  final public function setServiceRegistry(xfServiceRegistry $registry)
  {
    $this->registry = $registry;
  }

  /**
   * Gets the service registry.
   *
   * @returns xfServiceRegistry
   */
  final public function getServiceRegistry()
  {
    return $this->registry;
  }

  /**
   * Sets the engine index.
   *
   * @param xfEngine $index
   */
  final public function setEngine(xfEngine $engine)
  {
    $this->engine = $engine;
  }

  /**
   * Gets the engine.
   *
   * @returns xfEngine
   */
  final public function getEngine()
  {
    return $this->engine;
  }

  /**
   * Runs the setup procedure.
   */
  final public function setup()
  {
    $this->configure();
  }

  /**
   * Runs the internal setup procedure.
   *
   * This method should be overloaded by search indexes.  This method should
   * initialize the service registry and setup the backend engine.
   */
  protected function configure()
  {
    // nothing to do
  }

  /**
   * Inserts an input into the index.
   *
   * @param mixed $input
   */
  final public function insert($input)
  {
    try
    {
      $doc = $this->registry->locate($input)->buildDocument($input);
      $this->engine->add($doc);
      $this->log('Inserted document "' . $doc->getGuid() . '" from the index');
    }
    catch (xfServiceIgnoredException $e)
    {
    }
  }

  /**
   * Removes an input from the index.
   *
   * @param mixed $input
   */
  final public function remove($input)
  {
    try
    {
      $guid = $this->registry->locate($input)->getIdentifier()->getGuid($input);
      $this->engine->delete($guid);
      $this->log('Removed document "' . $guid . '" from the index');
    }
    catch (xfServiceIgnoredException $e)
    {
    }
  }

  /**
   * Rebuilds the index from scratch.
   */
  final public function rebuild()
  {
    $start = microtime(true);
    $this->log('Index rebuild in progress...');
    $this->engine->erase();
    $this->log('Index erased.');

    $this->engine->open();
    $this->log('Index opene.');

    $services = $this->registry->getServices();

    $this->log('Processing ' . count($services) . ' services now...');
   
    foreach ($services as $service)
    {
      $name = $service->getIdentifier()->getName();

      $this->log('Processing "' . $name . '" now...');

      for ($x = 0; $objects = $service->getIdentifier()->discover($x); $x++)
      {
        foreach ($service->getIdentifier()->discover($x) as $object)
        {
          $doc = $service->buildDocument($object);
          $this->engine->add($doc);
          $this->log('Document "' . $doc->getGuid() . '" inserted.');
        }
      }

      $this->log('Service "' . $name . '" successfully processed.');
    }

    $this->log('Index successfully rebuilt in "' . (microtime(true) - $start) . '" seconds.');
  }

  /**
   * Optimizes the index.
   */
  final public function optimize()
  {
    $start = microtime(true);
    $this->log('Index optimization in progress...');
    $this->engine->optimize();
    $this->log('Index successfully optimized in "' . (microtime(true) - $start) . '" seconds.');
  }

  /**
   * Searches the index from a criterion.
   *
   * @param xfCriterion $crit The query
   * @returns xfResultIterator 
   */
  final public function find(xfCriterion $crit)
  {
    return new xfResultIterator($this->engine->find($crit), $this->registry);
  }

  /**
   * Notify the dispatcher to log.
   *
   * @param string $message The message
   */
  final private function log($message)
  {
    $this->dispatcher->notify(new sfEvent($this, 'search.log', array($message, 'name' => $this->name)));
  }
}
