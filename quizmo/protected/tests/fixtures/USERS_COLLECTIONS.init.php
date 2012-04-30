<?php
$this->truncateTable('USERS_COLLECTIONS');


/*
$db=$this->getDbConnection();
$schema=$db->getSchema();
//echo("USERS_COLLECTIONS.init\n");

$tableName = 'USERS_COLLECTIONS';
if(($table=$schema->getTable($tableName))!==null){
	echo("$tableName...\n");
	
	$db->createCommand('DELETE FROM '.$table->rawName)->execute();
	$schema->resetSequence($table,1);
}
else
	throw new CException("Table '$tableName' does not exist.");

$tableName = 'USERS';
if(($table=$schema->getTable($tableName))!==null){
	echo("$tableName...\n");
	
	$db->createCommand('DELETE FROM '.$table->rawName)->execute();
	$schema->resetSequence($table,1);
}
else
	throw new CException("Table '$tableName' does not exist.");

$tableName = 'COLLECTIONS';
if(($table=$schema->getTable($tableName))!==null){
	echo("$tableName...\n");
	
	$db->createCommand('DELETE FROM '.$table->rawName)->execute();
	$schema->resetSequence($table,1);
}
else
	throw new CException("Table '$tableName' does not exist.");

	*/

?>
