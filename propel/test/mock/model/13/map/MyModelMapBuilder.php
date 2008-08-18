<?php



class MyModelMapBuilder implements MapBuilder {

	
	const CLASS_NAME = 'plugins.sfPropelSearchPlugin.test.mock.model.13.map.MyModelMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap(MyModelPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(MyModelPeer::TABLE_NAME);
		$tMap->setPhpName('MyModel');
		$tMap->setClassname('MyModel');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

		$tMap->addColumn('NAME', 'Name', 'VARCHAR', false, 250);

		$tMap->addColumn('EYE_COLOR', 'EyeColor', 'VARCHAR', false, 50);

		$tMap->addColumn('AGE', 'Age', 'INTEGER', false, null);

	} 
} 