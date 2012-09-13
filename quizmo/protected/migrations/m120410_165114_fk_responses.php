<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


class m120410_165114_fk_responses extends CDbMigration
{
	public function up()
	{
		$this->addForeignKey("FK_RESPONSES_USERS", "RESPONSES", "USER_ID", "USERS", "ID");
		$this->addForeignKey("FK_RESPONSES_QUESTIONS", "RESPONSES", "QUESTION_ID", "QUESTIONS", "ID");
	}

	public function down()
	{
		$this->dropForeignKey("FK_RESPONSES_USERS", "RESPONSES");
		$this->dropForeignKey("FK_RESPONSES_QUESTIONS", "RESPONSES");
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
