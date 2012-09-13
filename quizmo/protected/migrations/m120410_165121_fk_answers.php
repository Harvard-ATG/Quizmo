<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


class m120410_165121_fk_answers extends CDbMigration
{
	public function up()
	{
		$this->addForeignKey("FK_ANSWERS_QUESTIONS", "ANSWERS", "QUESTION_ID", "QUESTIONS", "ID");
	}

	public function down()
	{
		$this->dropForeignKey("FK_ANSWERS_QUESTIONS", "ANSWERS");
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
