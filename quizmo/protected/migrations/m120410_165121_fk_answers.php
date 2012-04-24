<?php

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