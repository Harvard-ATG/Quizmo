<?php
/**
 * Adding a unique key to the responses table
 * Should be loosely equivalent to: 
 * > ALTER TABLE response ADD CONSTRAINT uk_response
 * > UNIQUE (user_id, question_id, question_type, response, sort_order)
 * 
 * Intention is to not allow duplicate responses into the database
*/
class m141006_192555_uk_response extends CDbMigration
{
	public function up()
	{
		// http://www.yiiframework.com/doc/api/1.1/CDbMigration#createIndex-detail
		// response(100) because a BLOB/TEXT field requires a size
		$this->createIndex('uk_response', 'RESPONSES', 'user_id, question_id, question_type, response(100), sort_order', true);
	}

	public function down()
	{
		$this->dropIndex('uk_response', 'RESPONSES');
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
