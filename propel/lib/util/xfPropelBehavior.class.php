<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The Propel behavior to enable auto-saving and auto-updating.
 *
 * @package sfPropelSearch
 * @subpackage Behavior
 * @author Carl Vondrick
 */
final class xfPropelBehavior 
{
  /**
   * Flag for whether the behavior has already been setup.
   *
   * @var bool
   */
  static private $setup = false;

  /**
   * The lock status of the automatic indexing behavior.
   *
   * @var bool
   */
  static private $locked = false;

  /**
   * The index hash that relates models to index names
   *
   * @var array
   */
  static private $indexNameHash = array();

  /**
   * The index hash that relates models to index instances
   *
   * @var array
   */
  static private $indexInstanceHash = array();

  /**
   * Stores the objects in the queue that were flagged to be updated.
   * 
   * @var array
   */
  private $updateQueue = array();

  /**
   * Stores the objects in the queue that were flagged to be inserted.
   *
   * @var array
   */
  private $insertQueue = array();

  /**
   * Stores the objects in the queue that are flagged to be deleted.
   *
   * @var array
   */
  private $deleteQueue = array();

  /**
   * Sets up the behavior for a model.
   *
   * @param string $model The model name
   * @param array $indices The indices to call to
   */
  static public function register($model, array $indices)
  {
    if (!self::$setup)
    {
      sfPropelBehavior::registerHooks('search', array(
        ':save:pre'     => array('xfPropelBehavior', 'preSave'),
        ':save:post'    => array('xfPropelBehavior', 'postSave'),
        ':delete:pre'   => array('xfPropelBehavior', 'preDelete'),
        ':delete:post'  => array('xfPropelBehavior', 'postDelete')
      ));

      sfPropelBehavior::registerMethods('search', array(
        array('xfPropelBehavior', 'addToIndex'),
        array('xfPropelBehavior', 'deleteFromIndex')
      ));

      self::$setup = true;
    }

    self::$indexNameHash[$model] = $indices;

    sfPropelBehavior::add($model, array(
      'search' => array()
    ));
  }

  /**
   * Disables the behavior.
   */
  static public function disable()
  {
    self::$locked = true;
  }

  /**
   * Enables the behavior.
   */
  static public function enable()
  {
    self::$locked = false;
  }

  /**
   * Adds the node to the save queue if and only if it is modified or new.
   *
   * @param BaseObject $node
   */
  public function preSave(BaseObject $node)
  {
    if (self::$locked)
    {
      return;
    }

    if ($node->isModified() || $node->isNew())
    {
      foreach (array_merge($this->updateQueue, $this->insertQueue) as $item)
      {
        if ($node->equals($item))
        {
          // already in queue, abort
          return;
        }
      }

      // not in queue, add it
      if ($node->isNew())
      {
        $this->insertQueue[] = $node;
      }
      else
      {
        $this->updateQueue[] = $node;
      }
    }
  }

  /**
   * Finds the node in the save queue and if it exists, updates the index.
   *
   * @param BaseObject $node
   */
  public function postSave(BaseObject $node)
  {
    // if anyone has a DRY way of doing this, please submit a patch

    foreach ($this->insertQueue as $key => $item)
    {
      if ($node->equals($item))
      {
        $this->addToIndex($node);

        unset($this->insertQueue[$key]);
        
        return;
      }
    }
    
    foreach ($this->updateQueue as $key => $item)
    {
      if ($node->equals($item))
      {
        $this->deleteFromIndex($node);
        $this->addToIndex($node);

        unset($this->updateQueue[$key]);

        return;
      }
    }
  }

  /**
   * Adds the node of the delete queue if and only if it is not new.
   *
   * @param BaseObject $node
   */
  public function preDelete(BaseObject $node)
  {
    if (self::$locked)
    {
      return;
    }

    if (!$node->isNew())
    {
      foreach ($this->deleteQueue as $item)
      {
        if ($node->equals($item))
        {
          // already in queue, abort
        }
      }

      $this->deleteQueue[] = $node;
    }
  }

  /**
   * Finds the node in the delete queue and deletes it if it exists.
   *
   * @param BaseObject $node
   */
  public function postDelete(BaseObject $node)
  {
    foreach ($this->deleteQueue as $key => $item)
    {
      if ($node->equals($item))
      {
        $this->deleteFromIndex($node);

        unset($this->deleteQueue[$key]);

        return;
      }
    }
  }

  /**
   * Adds the node to the index.
   *
   * @param BaseObject $node
   */
  public function addToIndex(BaseObject $node)
  {
    foreach ($this->getIndices($node) as $index)
    {
      $index->insert($node);
    }
  }

  /**
   * Deletes the node from the index.
   *
   * @param BaseObject $node
   */
  public function deleteFromIndex(BaseObject $node)
  {
    foreach ($this->getIndices($node) as $index)
    {
      $index->remove($node);
    }
  }

  /**
   * Gets indcies for a node.
   *
   * @param BaseObject $node
   */
  private function getIndices(BaseObject $node)
  {
    $class = get_class($node);

    if (!isset(self::$indexInstanceHash[$class]))
    {
      self::$indexInstanceHash[$class] = array();

      foreach (self::$indexNameHash[$class] as $name)
      {
        self::$indexInstanceHash[$class][] = xfIndexManager::get($name);
      }
    }

    return self::$indexInstanceHash[$class];
  }
}
