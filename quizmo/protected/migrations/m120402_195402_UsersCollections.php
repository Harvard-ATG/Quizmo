<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

/*
--------------------------------------------------------
--  DDL for Table QUIZMO_USERSCOLLECTIONS
--------------------------------------------------------

  CREATE TABLE "ISITESTOOLS"."QUIZMO_USERSCOLLECTIONS" 
   (	"USER_ID" NUMBER, 
	"COLLECTION_ID" VARCHAR2(20 BYTE), 
	"PERMISSION" VARCHAR2(20 BYTE)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  DDL for Index QUIZMO_USERSCOLLECTIONS_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "ISITESTOOLS"."QUIZMO_USERSCOLLECTIONS_PK" ON "ISITESTOOLS"."QUIZMO_USERSCOLLECTIONS" ("USER_ID", "COLLECTION_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  Constraints for Table QUIZMO_USERSCOLLECTIONS
--------------------------------------------------------

  ALTER TABLE "ISITESTOOLS"."QUIZMO_USERSCOLLECTIONS" ADD CONSTRAINT "QUIZMO_USERSCOLLECTIONS_PK" PRIMARY KEY ("USER_ID", "COLLECTION_ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS"  ENABLE;
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_USERSCOLLECTIONS" MODIFY ("USER_ID" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_USERSCOLLECTIONS" MODIFY ("COLLECTION_ID" NOT NULL ENABLE);

*/
require_once("Autoincrement.php");

class m120402_195402_UsersCollections extends CDbMigration
{
	public function up()
	{
		$this->createTable('USERS_COLLECTIONS', array(
			'ID' => 'pk',
			'COLLECTION_ID' => 'integer NOT NULL',
			'USER_ID' => 'integer NOT NULL',
			'PERMISSION' => 'string',
		));	

		Autoincrement::up('USERS_COLLECTIONS', Yii::app()->db->driverName);

		
	}

	public function down()
	{
		Autoincrement::down('USERS_COLLECTIONS', Yii::app()->db->driverName);

		
		
		$this->dropTable('USERS_COLLECTIONS');
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
