<?php



class MyModelMapBuilder {

	
	const CLASS_NAME = 'plugins.sfPropelSearchPlugin.test.mock.model.12.map.MyModelMapBuilder';

	
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
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('my_model');
		$tMap->setPhpName('MyModel');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 250);

		$tMap->addColumn('EYE_COLOR', 'EyeColor', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('AGE', 'Age', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 