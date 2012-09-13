<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


class m120410_160720_fk_quizzes extends CDbMigration
{
	public function up()
	{
		$this->addForeignKey("FK_QUIZZES_COLLECTIONS", "QUIZZES", "COLLECTION_ID", "COLLECTIONS", "ID");
	}

	public function down()
	{
		$this->dropForeignKey("FK_QUIZZES_COLLECTIONS", "QUIZZES");
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
