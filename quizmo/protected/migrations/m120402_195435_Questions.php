<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


/*
--------------------------------------------------------
--  DDL for Table QUIZMO_QUESTION
--------------------------------------------------------

  CREATE TABLE "ISITESTOOLS"."QUIZMO_QUESTION" 
   (	"QUESTION_ID" NUMBER, 
	"PAGE_ID" NUMBER, 
	"QUESTION_TYPE" VARCHAR2(1 BYTE), 
	"TITLE" VARCHAR2(256 BYTE), 
	"BODY" VARCHAR2(4000 BYTE), 
	"QUESTION_ORDER" NUMBER DEFAULT '1', 
	"POINTS" NUMBER DEFAULT '0', 
	"FEEDBACK" VARCHAR2(4000 BYTE), 
	"DELETED" NUMBER(1,0) DEFAULT '0'
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  DDL for Index SYS_C0037172
--------------------------------------------------------

  CREATE UNIQUE INDEX "ISITESTOOLS"."SYS_C0037172" ON "ISITESTOOLS"."QUIZMO_QUESTION" ("QUESTION_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  DDL for Index QUIZMO_QUESTION_PAGE_ID
--------------------------------------------------------

  CREATE INDEX "ISITESTOOLS"."QUIZMO_QUESTION_PAGE_ID" ON "ISITESTOOLS"."QUIZMO_QUESTION" ("PAGE_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  Constraints for Table QUIZMO_QUESTION
--------------------------------------------------------

  ALTER TABLE "ISITESTOOLS"."QUIZMO_QUESTION" MODIFY ("QUESTION_ID" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_QUESTION" MODIFY ("PAGE_ID" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_QUESTION" MODIFY ("QUESTION_TYPE" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_QUESTION" MODIFY ("QUESTION_ORDER" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_QUESTION" MODIFY ("POINTS" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_QUESTION" MODIFY ("DELETED" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_QUESTION" ADD PRIMARY KEY ("QUESTION_ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS"  ENABLE;


*/
require_once("Autoincrement.php");

class m120402_195435_Questions extends CDbMigration
{
	public function up()
	{
		$this->createTable('QUESTIONS', array(
			'ID' => 'pk',
			'QUIZ_ID' => 'integer NOT NULL',
			'QUESTION_TYPE' => 'string NOT NULL',
			'TITLE' => 'string',
			'BODY' => "text",
			'SORT_ORDER' => 'integer',
			'POINTS' => 'integer',
			'FEEDBACK' => 'text',
			'DELETED' => 'integer NOT NULL',
		));	

		Autoincrement::up('QUESTIONS', Yii::app()->db->driverName);


		
	}

	public function down()
	{
		Autoincrement::down('QUESTIONS', Yii::app()->db->driverName);
		
		$this->dropTable('QUESTIONS');
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
