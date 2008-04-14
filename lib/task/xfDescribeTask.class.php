<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'xfBaseTask.class.php';

/**
 * A task to describe an index.
 *
 * @package sfSearch
 * @subpackage Task
 * @author Carl Vondrick
 */
final class xfDescribeTask extends xfBaseTask
{
  /**
   * Configures the task.
   */
  protected function configure()
  {
    $this->addArguments(array(new sfCommandArgument('index', sfCommandArgument::REQUIRED, 'The index name to describe')));

    $this->namespace = 'search';
    $this->name = 'describe';

    $this->briefDescription = 'Describes a search index';
    $this->detailedDescription = <<<EOF
The [search:describe|INFO] task dumps infoformation about the index
in the current project:

  [./symfony search:describe MySearch|INFO]

This task is useful for debugging and determing the configuration
of the index.
EOF;
  }

  /**
   * Rebuilds an index.
   *
   * @param array $arguments
   * @param array $options
   */
  public function execute($arguments = array(), $options = array())
  {
    $index = $arguments['index'];

    $this->bindAutoloader();
    $this->checkIndexExists($index);
    $this->connectLogging();

    $index = new $index($this->dispatcher);
    $index->setup();

    $this->log($this->formatter->format($arguments['index'], array('fg' => 'red', 'bold' => true)) . ':');
    
    foreach ($index->describe() as $key => $value)
    {
      $this->outputRow($key, $value);
    }
  }

  /**
   * Outputs info in a list to the dispatcher.
   *
   * @param string $key
   * @param string|array $value
   */
  private function outputRow($key, $value)
  {
    if (is_array($value))
    {
      $value = implode($value, ', ');
    }

    $value = str_replace(sfConfig::get('sf_root_dir') . '/', '', $value);

    // str_pad() doesn't like ansi formatting
    $padding = str_repeat(' ', 20 - strlen($key));

    $this->log(str_repeat(' ', 2) . $this->formatter->format($key, array('fg' => 'green', 'bold' => true)) . ':' . $padding . ' ' . $value); 
  }
}
