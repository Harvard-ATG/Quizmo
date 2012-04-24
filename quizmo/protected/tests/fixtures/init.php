<?php

$reset_order = array(
	'USERS_COLLECTIONS',
	'USERS',
	'COLLECTIONS',
);

$load_order = array(
	'USERS',
	'COLLECTIONS',
	'USERS_COLLECTIONS',
);

foreach($this->getFixtures() as $tableName=>$fixturePath){
	if(!in_array($tableName, $reset_order)){
		throw new CException("Table '$tableName' is not in the reset_order.");
	}
	if(!in_array($tableName, $load_order)){
		throw new CException("Table '$tableName' is not in the load_order.");
	}
	

}

foreach($reset_order as $tableName){
	echo("resetting $tableName\n");
	$this->resetTable($tableName);
}
foreach($load_order as $tableName){
	//echo("loading $tableName\n");
	//$this->loadFixture($tableName);
}

/*
foreach($this->getFixtures() as $tableName=>$fixturePath)
{
	echo(">>>>>$tableName\n");
	echo(var_export($this->getFixtures(), 1)."\n");

	$this->resetTable($tableName);
	$this->loadFixture($tableName);
}
*/

?>
