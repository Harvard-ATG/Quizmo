<?php

$reset_order = array(
	'USERS_COLLECTIONS',
	'ANSWERS',
	'QUESTIONS',
	'QUIZES',
	'USERS',
	'COLLECTIONS',
);

$load_order = array_reverse($reset_order);

foreach($this->getFixtures() as $tableName=>$fixturePath){
	if(!in_array($tableName, $reset_order)){
		throw new CException("Table '$tableName' is not in the reset_order.");
	}
	if(!in_array($tableName, $load_order)){
		throw new CException("Table '$tableName' is not in the load_order.");
	}
}

foreach($reset_order as $tableName){
	//echo("resetting $tableName\n");
	// this runs the TABLE.init.php if it exists
	// otherwise it just does a $this->truncateTable($tableName);
	$this->resetTable($tableName);
}
foreach($load_order as $tableName){
	//echo("loading $tableName\n");
	$this->loadFixture($tableName);
}


?>
