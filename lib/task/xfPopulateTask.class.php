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
 * A task to populate a index.
 *
 * @package sfSearch
 * @subpackage Task
 * @author Carl Vondrick
 */
final class xfPopulateTask extends xfBaseTask
{
  /**
   * Configures the task.
   */
  protected function configure()
  {
    $this->addArguments(array(new sfCommandArgument('index', sfCommandArgument::REQUIRED, 'The index name to populate')));

    $this->namespace = 'search';
    $this->name = 'populate';

    $this->briefDescription = 'Populates a search index';
    $this->detailedDescription = <<<EOF
The [search:populate|INFO] task empties, populates, and optimizes an index
in the current project:

  [./symfony search:populate MySearch|INFO]

This task may take quite a while to run, depending on your configuration.
Avoid running this task on a production site, as it's primary purpose is
for development and testing.
EOF;
  }

  /**
   * Populates an index.
   *
   * @param array $arguments
   * @param array $options
   */
  public function execute($arguments = array(), $options = array())
  {
    $index = $arguments['index'];

    $this->checkIndexExists($index);

    // this is a hack and will be hopefully removed
    // see http://groups.google.com/group/symfony-devs/browse_thread/thread/dc399312da49598a
    $db = new sfDatabaseManager(new xfSearchConfiguration('cli', false, $this->configuration->getRootDir(), $this->dispatcher));

    $index = new $index;
    $index->setLogger(new xfLoggerTask($this->dispatcher, $this->formatter));
    $index->populate();
    $index->optimize();
  }
}
