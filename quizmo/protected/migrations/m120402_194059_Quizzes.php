<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

/*
 CREATE TABLE IF NOT EXISTS QUIZ (
	"ID" NUMBER NOT NULL,
	"COLLECTION_ID" VARCHAR2(50) NOT NULL,
	"TITLE" VARCHAR2(200),
	"DESCRIPTION" VARCHAR2(4000),
	"VISIBILITY" NUMBER(1, 0) DEFAULT '0' NOT NULL,
	"STATE" VARCHAR2(1),
	"SHOW_FEEDBACK" NUMBER(1), DEFAULT '0' NOT NULL,
	"START_DATE" DATE,
	"END_DATE" DATE,
	"DATE_MODIFIED" DATE,
	"DELETED" NUMBER(1, 0) DEFAULT '0' NOT NULL,
	"QUIZ_ORDER" NUMBER,
	PRIMARY_KEY("id")
	)
 */
require_once("Autoincrement.php");

class m120402_194059_Quizzes extends CDbMigration
{
	public function up()
	{
		
		$this->createTable('QUIZZES', array(
			'ID' => 'pk',
			'COLLECTION_ID' => 'integer NOT NULL',
			'TITLE' => 'string NOT NULL',
			'DESCRIPTION' => 'text',
			'VISIBILITY' => "integer NOT NULL",
			'STATE' => 'string',
			'SHOW_FEEDBACK' => 'integer',
			'SORT_ORDER' => "integer",
			'START_DATE' => 'datetime',
			'END_DATE' => 'datetime',
			'DATE_MODIFIED' => 'datetime',
			'DELETED' => "integer NOT NULL",
		));	
		
		Autoincrement::up('QUIZZES', Yii::app()->db->driverName);


	}

	public function down()
	{

		Autoincrement::down('QUIZZES', Yii::app()->db->driverName);
		
		$this->dropTable('QUIZZES');
		
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
