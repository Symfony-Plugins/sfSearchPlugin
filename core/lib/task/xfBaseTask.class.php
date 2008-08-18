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
  protected function doRun(sfCommandManager $commandManager, $options)
  {
    if (!self::$done)
    {
      $auto = sfSimpleAutoload::getInstance();
      $auto->addDirectory(sfConfig::get('sf_lib_dir'));
      $auto->addDirectory(sfConfig::get('sf_root_dir') . '/lib');
      $auto->addDirectory(sfConfig::get('sf_plugins_dir') . '/*/lib');
      $auto->register();

      self::$done = true;
    }

    return parent::doRun($commandManager, $options);
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
}
