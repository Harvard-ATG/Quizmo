<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


class m120410_161722_fk_userscollections extends CDbMigration
{
	public function up()
	{
		$this->addForeignKey("FK_USERSCOLL_COLLECTIONS", "USERS_COLLECTIONS", "COLLECTION_ID", "COLLECTIONS", "ID");
		$this->addForeignKey("FK_USERSCOLL_USERS", "USERS_COLLECTIONS", "USER_ID", "USERS", "ID");
	}

	public function down()
	{
		$this->dropForeignKey("FK_USERSCOLL_COLLECTIONS", "USERS_COLLECTIONS");
		$this->dropForeignKey("FK_USERSCOLL_USERS", "USERS_COLLECTIONS");
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
