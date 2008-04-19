<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A base task for xfSearch tasks.
 *
 * @package sfSearch
 * @subpackage Task
 * @author Carl Vondrick
 */
abstract class xfBaseTask extends sfBaseTask
{
  /**
   * Flag for when autoloader is already setup (true if setup)
   *
   * @var bool
   */
  static private $done = false;

  /**
   * @see sfTask
   */
  public function initialize(sfEventDispatcher $dispatcher, sfFormatter $formatter)
  {
    parent::initialize($dispatcher, $formatter);

    if (!self::$done)
    {
      $auto = sfSimpleAutoload::getInstance();
      $auto->addDirectory(sfConfig::get('sf_lib_dir'));
      $auto->addDirectory(sfConfig::get('sf_root_dir') . '/lib');
      $auto->addDirectory(sfConfig::get('sf_plugins_dir') . '/*/lib');
      $auto->register();

      foreach (sfFinder::type('file')->name('config.php')->in(sfConfig::get('sf_plugins_dir')) as $config)
      {
        require_once $config;
      }

      self::$done = true;
    }
  }

  /**
   * Checks to see if index exists.
   *
   * @param string $index The index name
   * @throws sfException if index does not exist
   */
  protected function checkIndexExists($index)
  {
    if (!class_exists($index, true))
    {
      throw new sfException('Index ' . $index . ' does not exist');
    }
  }

  /**
   * Connects the logging output to the dispatcher.
   */
  protected function connectLogging()
  {
    $this->dispatcher->connect('search.log', array($this, 'handleLogEvent'));
  }

  /**
   * Initializes the index manager.
   */
  protected function initializeManager()
  {
    xfIndexManager::initialize($this->dispatcher);
  }

  /**
   * Sends a log notice to the dispatcher.
   *
   * @param sfEvent $event
   */
  public function handleLogEvent(sfEvent $event)
  {
    $parameters = $event->getParameters();

    $section = isset($parameters['name']) ? $parameters['name'] : 'search';
    $options = isset($parameters['options']) ? $parameters['options'] : array();

    foreach ($parameters as $key => $parameter)
    {
      if (is_numeric($key))
      {
        $parameter = preg_replace('/"(.+?)"/e', '$this->formatter->format("\\1", array("fg" => "blue", "bold" => true));', $parameter);
        $parameter = preg_replace('/\.{3}$/e', '$this->formatter->format("...", array("fg" => "red", "bold" => true));', $parameter);

        $this->log($this->formatter->format($section, array('fg' => 'green', 'bold' => true)) . ' >> ' . $parameter);
      }
    }
  }
}
