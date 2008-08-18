<?php


abstract class BaseComposite extends BaseObject  implements Persistent {


	
	protected static $peer;

	
	protected $key1;

	
	protected $key2;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function __construct()
	{
		$this->applyDefaultValues();
	}

	
	public function applyDefaultValues()
	{
	}

	
	public function getKey1()
	{
		return $this->key1;
	}

	
	public function getKey2()
	{
		return $this->key2;
	}

	
	public function setKey1($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->key1 !== $v) {
			$this->key1 = $v;
			$this->modifiedColumns[] = CompositePeer::KEY1;
		}

		return $this;
	} 
	
	public function setKey2($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->key2 !== $v) {
			$this->key2 = $v;
			$this->modifiedColumns[] = CompositePeer::KEY2;
		}

		return $this;
	} 
	
	public function hasOnlyDefaultValues()
	{
						if (array_diff($this->modifiedColumns, array())) {
				return false;
			}

				return true;
	} 
	
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->key1 = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->key2 = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Composite object", $e);
		}
	}

	
	public function ensureConsistency()
	{

	} 
	
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CompositePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = CompositePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); 
		if ($deep) {  
		} 	}

	
	public function delete(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseComposite:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CompositePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		try {
			$con->beginTransaction();
			CompositePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseComposite:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseComposite:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CompositePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		try {
			$con->beginTransaction();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseComposite:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			CompositePeer::addInstanceToPool($this);
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = CompositePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += CompositePeer::doUpdate($this, $con);
				}

				$this->resetModified(); 			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = CompositePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CompositePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getKey1();
				break;
			case 1:
				return $this->getKey2();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = CompositePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getKey1(),
			$keys[1] => $this->getKey2(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CompositePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setKey1($value);
				break;
			case 1:
				$this->setKey2($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CompositePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setKey1($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setKey2($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(CompositePeer::DATABASE_NAME);

		if ($this->isColumnModified(CompositePeer::KEY1)) $criteria->add(CompositePeer::KEY1, $this->key1);
		if ($this->isColumnModified(CompositePeer::KEY2)) $criteria->add(CompositePeer::KEY2, $this->key2);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(CompositePeer::DATABASE_NAME);

		$criteria->add(CompositePeer::KEY1, $this->key1);
		$criteria->add(CompositePeer::KEY2, $this->key2);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getKey1();

		$pks[1] = $this->getKey2();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setKey1($keys[0]);

		$this->setKey2($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setKey1($this->key1);

		$copyObj->setKey2($this->key2);


		$copyObj->setNew(true);

	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new CompositePeer();
		}
		return self::$peer;
	}

	
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} 
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseComposite:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseComposite::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 