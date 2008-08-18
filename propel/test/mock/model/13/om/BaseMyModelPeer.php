<?php


abstract class BaseMyModelPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'my_model';

	
	const CLASS_DEFAULT = 'plugins.sfPropelSearchPlugin.test.mock.model.13.MyModel';

	
	const NUM_COLUMNS = 4;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;

	
	const ID = 'my_model.ID';

	
	const NAME = 'my_model.NAME';

	
	const EYE_COLOR = 'my_model.EYE_COLOR';

	
	const AGE = 'my_model.AGE';

	
	public static $instances = array();

	
	private static $mapBuilder = null;

	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Name', 'EyeColor', 'Age', ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'name', 'eyeColor', 'age', ),
		BasePeer::TYPE_COLNAME => array (self::ID, self::NAME, self::EYE_COLOR, self::AGE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'name', 'eye_color', 'age', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Name' => 1, 'EyeColor' => 2, 'Age' => 3, ),
		BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'name' => 1, 'eyeColor' => 2, 'age' => 3, ),
		BasePeer::TYPE_COLNAME => array (self::ID => 0, self::NAME => 1, self::EYE_COLOR => 2, self::AGE => 3, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'name' => 1, 'eye_color' => 2, 'age' => 3, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, )
	);

	
	public static function getMapBuilder()
	{
		if (self::$mapBuilder === null) {
			self::$mapBuilder = new MyModelMapBuilder();
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
		return str_replace(MyModelPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(MyModelPeer::ID);

		$criteria->addSelectColumn(MyModelPeer::NAME);

		$criteria->addSelectColumn(MyModelPeer::EYE_COLOR);

		$criteria->addSelectColumn(MyModelPeer::AGE);

	}

	
	public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
	{
				$criteria = clone $criteria;

								$criteria->setPrimaryTableName(MyModelPeer::TABLE_NAME);

		if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->setDistinct();
		}

		if (!$criteria->getSelectColumns()) {
			MyModelPeer::addSelectColumns($criteria);
		}

		$criteria->clearOrderByColumns(); 		$criteria->setDbName(self::DATABASE_NAME); 
		if ($con === null) {
			$con = Propel::getConnection(MyModelPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
		$objects = MyModelPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, PropelPDO $con = null)
	{
		return MyModelPeer::populateObjects(MyModelPeer::doSelectStmt($criteria, $con));
	}
	
	public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseMyModelPeer:doSelectStmt:doSelectStmt') as $callable)
    {
      call_user_func($callable, 'BaseMyModelPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(MyModelPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			MyModelPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

				return BasePeer::doSelect($criteria, $con);
	}
	
	public static function addInstanceToPool(MyModel $obj, $key = null)
	{
		if (Propel::isInstancePoolingEnabled()) {
			if ($key === null) {
				$key = (string) $obj->getId();
			} 			self::$instances[$key] = $obj;
		}
	}

	
	public static function removeInstanceFromPool($value)
	{
		if (Propel::isInstancePoolingEnabled() && $value !== null) {
			if (is_object($value) && $value instanceof MyModel) {
				$key = (string) $value->getId();
			} elseif (is_scalar($value)) {
								$key = (string) $value;
			} else {
				$e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or MyModel object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
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
				if ($row[$startcol + 0] === null) {
			return null;
		}
		return (string) $row[$startcol + 0];
	}

	
	public static function populateObjects(PDOStatement $stmt)
	{
		$results = array();
	
				$cls = MyModelPeer::getOMClass();
		$cls = substr('.'.$cls, strrpos('.'.$cls, '.') + 1);
				while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$key = MyModelPeer::getPrimaryKeyHashFromRow($row, 0);
			if (null !== ($obj = MyModelPeer::getInstanceFromPool($key))) {
																$results[] = $obj;
			} else {
		
				$obj = new $cls();
				$obj->hydrate($row);
				$results[] = $obj;
				MyModelPeer::addInstanceToPool($obj, $key);
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
		return MyModelPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseMyModelPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMyModelPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(MyModelPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		if ($criteria->containsKey(MyModelPeer::ID) && $criteria->keyContainsValue(MyModelPeer::ID) ) {
			throw new PropelException('Cannot insert a value for auto-increment primary key ('.MyModelPeer::ID.')');
		}


				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->beginTransaction();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseMyModelPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseMyModelPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseMyModelPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseMyModelPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(MyModelPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(MyModelPeer::ID);
			$selectCriteria->add(MyModelPeer::ID, $criteria->remove(MyModelPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseMyModelPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseMyModelPeer', $values, $con, $ret);
    }

    return $ret;
  }

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(MyModelPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		$affectedRows = 0; 		try {
									$con->beginTransaction();
			$affectedRows += BasePeer::doDeleteAll(MyModelPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(MyModelPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		if ($values instanceof Criteria) {
												MyModelPeer::clearInstancePool();

						$criteria = clone $values;
		} elseif ($values instanceof MyModel) {
						MyModelPeer::removeInstanceFromPool($values);
						$criteria = $values->buildPkeyCriteria();
		} else {
			


			$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(MyModelPeer::ID, (array) $values, Criteria::IN);

			foreach ((array) $values as $singleval) {
								MyModelPeer::removeInstanceFromPool($singleval);
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

	
	public static function doValidate(MyModel $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(MyModelPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(MyModelPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(MyModelPeer::DATABASE_NAME, MyModelPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = MyModelPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            if(sfConfig::get('sf_compat_10')) {
               $request->setError($col, $failed->getMessage());
            }
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, PropelPDO $con = null)
	{

		if (null !== ($obj = MyModelPeer::getInstanceFromPool((string) $pk))) {
			return $obj;
		}

		if ($con === null) {
			$con = Propel::getConnection(MyModelPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$criteria = new Criteria(MyModelPeer::DATABASE_NAME);
		$criteria->add(MyModelPeer::ID, $pk);

		$v = MyModelPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, PropelPDO $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(MyModelPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria(MyModelPeer::DATABASE_NAME);
			$criteria->add(MyModelPeer::ID, $pks, Criteria::IN);
			$objs = MyModelPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 

Propel::getDatabaseMap(BaseMyModelPeer::DATABASE_NAME)->addTableBuilder(BaseMyModelPeer::TABLE_NAME, BaseMyModelPeer::getMapBuilder());

