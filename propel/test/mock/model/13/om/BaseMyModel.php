<?php


abstract class BaseMyModel extends BaseObject  implements Persistent {


	
	protected static $peer;

	
	protected $id;

	
	protected $name;

	
	protected $eye_color;

	
	protected $age;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function __construct()
	{
		$this->applyDefaultValues();
	}

	
	public function applyDefaultValues()
	{
	}

	
	public function getId()
	{
		return $this->id;
	}

	
	public function getName()
	{
		return $this->name;
	}

	
	public function getEyeColor()
	{
		return $this->eye_color;
	}

	
	public function getAge()
	{
		return $this->age;
	}

	
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = MyModelPeer::ID;
		}

		return $this;
	} 
	
	public function setName($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = MyModelPeer::NAME;
		}

		return $this;
	} 
	
	public function setEyeColor($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->eye_color !== $v) {
			$this->eye_color = $v;
			$this->modifiedColumns[] = MyModelPeer::EYE_COLOR;
		}

		return $this;
	} 
	
	public function setAge($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->age !== $v) {
			$this->age = $v;
			$this->modifiedColumns[] = MyModelPeer::AGE;
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

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->eye_color = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->age = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating MyModel object", $e);
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
			$con = Propel::getConnection(MyModelPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

				
		$stmt = MyModelPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
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

    foreach (sfMixer::getCallables('BaseMyModel:delete:pre') as $callable)
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
			$con = Propel::getConnection(MyModelPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		try {
			$con->beginTransaction();
			MyModelPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseMyModel:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save(PropelPDO $con = null)
	{

    foreach (sfMixer::getCallables('BaseMyModel:save:pre') as $callable)
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
			$con = Propel::getConnection(MyModelPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}

		try {
			$con->beginTransaction();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseMyModel:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			MyModelPeer::addInstanceToPool($this);
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

			if ($this->isNew() ) {
				$this->modifiedColumns[] = MyModelPeer::ID;
			}

						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = MyModelPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += MyModelPeer::doUpdate($this, $con);
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


			if (($retval = MyModelPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MyModelPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getEyeColor();
				break;
			case 3:
				return $this->getAge();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = MyModelPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getEyeColor(),
			$keys[3] => $this->getAge(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MyModelPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setEyeColor($value);
				break;
			case 3:
				$this->setAge($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MyModelPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setEyeColor($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setAge($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MyModelPeer::DATABASE_NAME);

		if ($this->isColumnModified(MyModelPeer::ID)) $criteria->add(MyModelPeer::ID, $this->id);
		if ($this->isColumnModified(MyModelPeer::NAME)) $criteria->add(MyModelPeer::NAME, $this->name);
		if ($this->isColumnModified(MyModelPeer::EYE_COLOR)) $criteria->add(MyModelPeer::EYE_COLOR, $this->eye_color);
		if ($this->isColumnModified(MyModelPeer::AGE)) $criteria->add(MyModelPeer::AGE, $this->age);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MyModelPeer::DATABASE_NAME);

		$criteria->add(MyModelPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setEyeColor($this->eye_color);

		$copyObj->setAge($this->age);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
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
			self::$peer = new MyModelPeer();
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
    if (!$callable = sfMixer::getCallable('BaseMyModel:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseMyModel::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 