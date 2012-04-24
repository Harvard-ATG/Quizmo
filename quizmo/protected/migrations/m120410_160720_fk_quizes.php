<?php

class m120410_160720_fk_quizes extends CDbMigration
{
	public function up()
	{
		$this->addForeignKey("FK_QUIZES_COLLECTIONS", "QUIZES", "COLLECTION_ID", "COLLECTIONS", "ID");
	}

	public function down()
	{
		$this->dropForeignKey("FK_QUIZES_COLLECTIONS", "QUIZES");
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