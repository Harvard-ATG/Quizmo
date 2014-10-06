<?php

class m141006_192555_uk_response extends CDbMigration
{
	public function up()
	{
		$this->createIndex('uk_response', 'RESPONSES', 'user_id, question_id, question_type, response(100), sort_order', true);
		//$pkCommand = new CDbCommand($this->dbConnection, 'ALTER TABLE RESPONSES ADD CONSTRAINT uk_response UNIQUE (user_id, question_id, question_type, response, sort_order)');
		//$pkCommand->execute();
	}

	public function down()
	{
		$this->dropIndex('uk_response', 'RESPONSES');
		//$pkCommand = new CDbCommand($this->dbConnection, 'ALTER TABLE RESPONSES R
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
