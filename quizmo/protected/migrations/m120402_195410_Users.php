<?php
require_once("Autoincrement.php");

class m120402_195410_Users extends CDbMigration
{
	public function up()
	{
		$this->createTable('USERS', array(
			'ID' => 'pk',
			'EXTERNAL_ID' => 'string',
			'NAME' => 'string',
			'FNAME' => 'string',
			'LNAME' => 'string',
		));	

		Autoincrement::up('USERS', Yii::app()->db->driverName);


	}

	public function down()
	{
		
		Autoincrement::down('USERS', Yii::app()->db->driverName);
		
		
		$this->dropTable('USERS');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}