<?php
/**
 * This file is part of the sfPropelSearch package.
 * (c) Carl Vondrick <carl.vondrick@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The restore retort allows restoring the Propel model from the search results.
 *
 * @package sfPropelSearch
 * @subpackage Result
 * @author Carl Vondrick
 */
final class xfPropelRetortRestore implements xfRetort
{
  /**
   * The method to bind to
   *
   * @var string
   */
  private $method;

  /**
   * Constructor to set the method
   *
   * @param string $method
   */
  public function __construct($method = 'getPropelModel')
  {
    $this->method = strtolower($method);
  }

  /**
   * @see xfRetort
   */
  public function can(xfDocumentHit $hit, $method, array $args = array())
  {
    return strtolower($method) == $this->method;
  }

  /**
   * @see xfRetort
   */
  public function respond(xfDocumentHit $hit, $method, array $args = array())
  {
    $model = $hit->getDocument()->getField('_model')->getValue(); 
    $peer = $model . 'Peer';

    if (!class_exists($peer, true))
    {
      throw new xfException('The model "' . $model . '" does not exist');
    }

    $c = new Criteria;

    $mapBuilder = call_user_func(array($peer, 'getMapBuilder'));
    if (!$mapBuilder->isBuilt())
    {
      $mapBuilder->doBuild();
    }
    $map = $mapBuilder->getDatabaseMap()->getTable(constant($peer . '::TABLE_NAME'));
    foreach ($map->getColumns() as $pk)
    {
      // cannot use ->getPrimaryKeyColumns() because Propel 1.2 does not support
      if ($pk->isPrimaryKey())
      {
        try
        {
          $value = $hit->getDocument()->getField($pk->getPhpName())->getValue();
        }
        catch (xfException $e)
        {
          throw new xfException('The field "' . $pk->getPhpName() . '" must be indexed for the "' . $model . '" model: [' . $e->getMessage() . ']');
        }

        $c->add($pk->getFullyQualifiedName(), $value);
      }
    }

    $obj = call_user_func(array($peer, 'doSelectOne'), $c);

    if ($obj == null)
    {
      throw new xfException('Unable to restore "' . $model . '" because it does not exist in the database');
    }

    return $obj;
  }
}
