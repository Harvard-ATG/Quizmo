<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


class m120410_165043_fk_submissions extends CDbMigration
{
	public function up()
	{
		$this->addForeignKey("FK_SUBMISSIONS_QUIZZES", "SUBMISSIONS", "QUIZ_ID", "QUIZZES", "ID");
	}

	public function down()
	{
		$this->dropForeignKey("FK_SUBMISSIONS_QUIZZES", "SUBMISSIONS");
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
