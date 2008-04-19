<?php
/**
 * This file is part of the sfSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The inde manager stores all the indices and provides a singleton access point.
 *
 * Example usage: <code>
 * xfIndexManager::getInstance()->initialize(sfContext::getInstance()->getEventDispatcher());
 *
 * // later on...
 *
 * $index = xfIndexManager::getInstance()->getIndex('MySearch');
 * </code>
 *
 * Note: You do not have to use the index manager.  The index manager provides a
 * way of maintaining a singleton of the indices.
 *
 * @todo Perhaps find a better way to do this.  The problem is in Propel
 * behaviors because each behavior needs an instance and we can't have dozens of
 * of the same index floating around.  Perhaps a goal for symfony 1.2.
 *
 * @package sfSearch
 * @subpackage Index
 * @author Carl Vondrick
 */
final class xfIndexManager
{
  /**
   * The indices registered.
   *
   * @var array
   */
  static private $indices = array();

  /**
   * The common event dispatcher.
   *
   * @var sfEventDispatcher
   */
  static private $dispatcher;

  /**
   * Initialize the index manager.
   *
   * @param sfEventDispatcher $dispatcher
   */
  static public function initialize(sfEventDispatcher $dispatcher)
  {
    self::$dispatcher = $dispatcher;
  }

  /**
   * Gets an index from the singleton
   *
   * @param string $name The index name
   */
  static public function get($name)
  {
    if (self::$dispatcher == null)
    {
      throw new xfException('xfIndexManager has not been initialized yet');
    }

    if (!isset(self::$indices[$name]))
    {
      $r = new ReflectionClass($name);
      if (!$r->isSubclassOf(new ReflectionClass('xfIndex')))
      {
        throw new xfException('xfIndexManager can only handle instances of xfIndex');
      }

      $index = new $name(self::$dispatcher);
      $index->setup();

      self::$indices[$name] = $index;
    }

    return self::$indices[$name];
  }
}
