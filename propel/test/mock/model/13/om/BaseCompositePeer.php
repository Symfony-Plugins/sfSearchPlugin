<?php


abstract class BaseCompositePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'composite';

	
	const CLASS_DEFAULT = 'plugins.sfPropelSearchPlugin.test.mock.model.13.Composite';

	
	const NUM_COLUMNS = 2;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;

	
	const KEY1 = 'composite.KEY1';

	
	const KEY2 = 'composite.KEY2';

	
	public static $instances = array();

	
	private static $mapBuilder = null;

	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Key1', 'Key2', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('key1', 'key2', ),
		BasePeer::TYPE_COLNAME => array (self::KEY1, self::KEY2, ),
		BasePeer::TYPE_FIELDNAME => array ('key1', 'key2', ),
		BasePeer::TYPE_NUM => array (0, 1, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Key1' => 0, 'Key2' => 1, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('key1' => 0, 'key2' => 1, ),
		BasePeer::TYPE_COLNAME => array (self::KEY1 => 0, self::KEY2 => 1, ),
		BasePeer::TYPE_FIELDNAME => array ('key1' => 0, 'key2' => 1, ),
		BasePeer::TYPE_NUM => array (0, 1, )
	);

	
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new CompositeMapBuilder();
		}
		return self::$mapBuilder;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(CompositePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(CompositePeer::KEY1);

		$criteria->addSelectColumn(CompositePeer::KEY2);

	}

	
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(CompositePeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->getSelectColumns()) {
			CompositePeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(CompositePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
				$stmt = BasePeer::doCount($criteria, $con);

		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$count = (int) $row[0];
		} else {
			$count = 0; 		}
		$stmt->closeCursor();
		return $count;
	}
	
	public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = CompositePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return CompositePeer::populateObjects(CompositePeer::doSelectStmt($criteria, $con));
	}
	
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCompositePeer:doSelectStmt:doSelectStmt') as $callable)
    {
      call_user_func($callable, 'BaseCompositePeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(CompositePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			CompositePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

				return BasePeer::doSelect($criteria, $con);
	}
	
	public static function addInstanceToPool(Composite $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = serialize(array((string) $obj->getKey1(), (string) $obj->getKey2()));
			} 			self::$instances[$key] = $obj;
		}
	}

	
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof Composite) {
				$key = serialize(array((string) $value->getKey1(), (string) $value->getKey2()));
			} elseif (is_array($value) && count($value) === 2) {
								$key = serialize(array((string) $value[0], (string) $value[1]));
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Composite object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
				throw $e;
			}

			unset(self::$instances[$key]);
		}
	} 
	
	public static function getInstanceFromPool($key)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if (isset(self::$instances[$key])) {
				return self::$instances[$key];
			}
		}
		return null; 	}
	
	
	public static function clearInstancePool()
	{
		self::$instances = array();
	}
	
	
	public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
	{
				if ($row[$startcol + 0] === null && $row[$startcol + 1] === null) {
			return null;
		}
		return serialize(array((string) $row[$startcol + 0], (string) $row[$startcol + 1]));
	}

	
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
				$cls = CompositePeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
				while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = CompositePeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = CompositePeer::getInstanceFromPool($key))) {
																$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				CompositePeer::addInstanceToPool($obj, $key);
			} 		}
		$stmt->closeCursor();
		return $results;
	}

  static public function getUniqueColumnNames()
  {
    return array();
  }
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return CompositePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCompositePeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCompositePeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(CompositePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}


				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseCompositePeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseCompositePeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseCompositePeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCompositePeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(CompositePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(CompositePeer::KEY1);
			$selectCriteria->add(CompositePeer::KEY1, $criteria->remove(CompositePeer::KEY1), $comparison);

			$comparison = $criteria->getComparison(CompositePeer::KEY2);
			$selectCriteria->add(CompositePeer::KEY2, $criteria->remove(CompositePeer::KEY2), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseCompositePeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseCompositePeer', $values, $con, $ret);
    }

    return $ret;
  }

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(CompositePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; 		try {
									$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(CompositePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, PropelPDO $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(CompositePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
												CompositePeer::clearInstancePool();

						$criteria = clone $values;
		} elseif ($values instanceof Composite) {
						CompositePeer::removeInstanceFromPool($values);
						$criteria = $values->buildPkeyCriteria();
		} else {
			


			$criteria = new Criteria(self::DATABASE_NAME);
												if (count($values) == count($values, COUNT_RECURSIVE)) {
								$values = array($values);
			}

			foreach ($values as $value) {

				$criterion = $criteria->getNewCriterion(CompositePeer::KEY1, $value[0]);
				$criterion->addAnd($criteria->getNewCriterion(CompositePeer::KEY2, $value[1]));
				$criteria->addOr($criterion);

								CompositePeer::removeInstanceFromPool($value);
			}
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->beginTransaction();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);

			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(Composite $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(CompositePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(CompositePeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach ($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(CompositePeer::DATABASE_NAME, CompositePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = CompositePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            if(sfConfig::get('sf_compat_10')) {
               $request->setError($col, $failed->getMessage());
            }
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($key1, $key2, PropelPDO $con = null) {
		$key = serialize(array((string) $key1, (string) $key2));
 		if (null !== ($obj = CompositePeer::getInstanceFromPool($key))) {
 			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(CompositePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		$criteria = new Criteria(CompositePeer::DATABASE_NAME);
		$criteria->add(CompositePeer::KEY1, $key1);
		$criteria->add(CompositePeer::KEY2, $key2);
		$v = CompositePeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 

Propel::getDatabaseMap(BaseCompositePeer::DATABASE_NAME)->addTableBuilder(BaseCompositePeer::TABLE_NAME, BaseCompositePeer::getMapBuilder());

