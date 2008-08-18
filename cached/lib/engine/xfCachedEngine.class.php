<?php
/**
 * This file is part of the sfCachedSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A engine that caches search results by the criterions.
 *
 * @package sfCachedSearch
 * @subpackage Engine
 * @author Carl Vondrick
 */
final class xfCachedEngine extends xfEngineDecorator
{
  /**
   * The cache instance
   *
   * @var sfCache
   */
  private $cache;

  /**
   * @see xfEngine
   * @param sfCache $cache The cache object
   */
  public function __construct(xfEngine $engine, sfCache $cache)
  {
    parent::__construct($engine);
    
    $cache->setOption('prefix', 'sfCachedSearch:' . $engine->id() . ':results');

    $this->cache = $cache;
  }

  /**
   * Gets the cache object
   *
   * @returns sfCache
   */
  public function getCache()
  {
    return $this->cache;
  }

  /**
   * @see xfEngine
   */
  public function find(xfCriterion $query)
  {
    $key = sha1($query->toString());

    if ($this->cache->has($key))
    {
      return unserialize($this->cache->get($key));
    }
    
    $results = parent::find($query);
    $this->cache->set($key, serialize($results));

    return $results;
  }

  /**
   * @see xfEngine
   */
  public function erase()
  {
    $this->cache->clean(sfCache::ALL);

    parent::erase();
  }

  /**
   * @see xfEngine
   */
  public function optimize()
  {
    $this->cache->clean(sfCache::OLD);

    parent::optimize();
  }

  /**
   * @see xfEngine
   */
  public function describe()
  {
    $options = array();
    $options['Status'] = 'Enabled';
    $options['Lifetime'] = $this->cache->getOption('lifetime') . ' seconds';
    $options['Engine'] = get_class($this->cache);


    return array_merge(parent::describe(), array('Cache' => $options));
  }

  /**
   * @see xfEngine
   */
  public function id()
  {
    return 'cached_' . parent::id();
  }
}
