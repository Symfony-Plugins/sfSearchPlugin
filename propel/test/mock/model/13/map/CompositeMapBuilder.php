<?php



class CompositeMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'plugins.sfPropelSearchPlugin.test.mock.model.13.map.CompositeMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(CompositePeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(CompositePeer::TABLE_NAME);
		$tMap->setPhpName('Composite');
		$tMap->setClassname('Composite');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('KEY1', 'Key1', 'INTEGER', true, null);

		$tMap->addPrimaryKey('KEY2', 'Key2', 'INTEGER', true, null);

	} 
} 