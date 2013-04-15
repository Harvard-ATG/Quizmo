<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

class m130412_185633_Responses_add_SORT_ORDER extends CDbMigration
{
	public function up()
	{
		$this->addColumn('RESPONSES', 'SORT_ORDER', 'integer');	
	}

	public function down()
	{
		$this->dropColumn('RESPONSES', 'SORT_ORDER');	
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