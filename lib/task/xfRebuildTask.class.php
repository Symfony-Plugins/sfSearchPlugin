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
 * A task to rebuild a index.
 *
 * @package sfSearch
 * @subpackage Task
 * @author Carl Vondrick
 */
final class xfRebuildTask extends xfBaseTask
{
  /**
   * Configures the task.
   */
  protected function configure()
  {
    $this->addArguments(array(new sfCommandArgument('index', sfCommandArgument::REQUIRED, 'The index name to rebuild')));

    $this->namespace = 'search';
    $this->name = 'rebuild';

    $this->briefDescription = 'Rebuilds a search index';
    $this->detailedDescription = <<<EOF
The [search:rebuild|INFO] task empties, rebuilds, and optimizes an index
in the current project:

  [./symfony search:rebuild MySearch|INFO]

This task may take quite a while to run, depending on your configuration.
Avoid running this task on a production site, as it's primary purpose is
for development and testing.
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
    $index->rebuild();
    $index->optimize();
  }
}
