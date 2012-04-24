<?php

class m120410_165101_fk_questions extends CDbMigration
{
	public function up()
	{
		$this->addForeignKey("FK_QUESTIONS_QUIZES", "QUESTIONS", "QUIZ_ID", "QUIZES", "ID");
	}

	public function down()
	{
		$this->dropForeignKey("FK_QUESTIONS_QUIZES", "QUESTIONS");
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