<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

/*
--------------------------------------------------------
--  DDL for Table QUIZMO_SUBMISSION
--------------------------------------------------------

  CREATE TABLE "ISITESTOOLS"."QUIZMO_SUBMISSION" 
   (	"SUBMISSION_ID" NUMBER, 
	"QUIZ_ID" NUMBER, 
	"USER_ID" VARCHAR2(10 BYTE), 
	"STATUS" VARCHAR2(1 BYTE), 
	"DATE_MODIFIED" DATE
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  DDL for Index SYS_C0037814
--------------------------------------------------------

  CREATE UNIQUE INDEX "ISITESTOOLS"."SYS_C0037814" ON "ISITESTOOLS"."QUIZMO_SUBMISSION" ("SUBMISSION_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  DDL for Index QUIZMO_SUBMISSION_QID
--------------------------------------------------------

  CREATE INDEX "ISITESTOOLS"."QUIZMO_SUBMISSION_QID" ON "ISITESTOOLS"."QUIZMO_SUBMISSION" ("QUIZ_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  DDL for Index QUIZMO_SUBMISSION_UID
--------------------------------------------------------

  CREATE INDEX "ISITESTOOLS"."QUIZMO_SUBMISSION_UID" ON "ISITESTOOLS"."QUIZMO_SUBMISSION" ("USER_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  Constraints for Table QUIZMO_SUBMISSION
--------------------------------------------------------

  ALTER TABLE "ISITESTOOLS"."QUIZMO_SUBMISSION" MODIFY ("SUBMISSION_ID" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_SUBMISSION" MODIFY ("QUIZ_ID" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_SUBMISSION" MODIFY ("USER_ID" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_SUBMISSION" ADD PRIMARY KEY ("SUBMISSION_ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS"  ENABLE;


*/
require_once("Autoincrement.php");

class m120402_195425_Submissions extends CDbMigration
{
	public function up()
	{
		$this->createTable('SUBMISSIONS', array(
			'ID' => 'pk',
			'QUIZ_ID' => 'integer',
			'USER_ID' => 'integer',
			'STATUS' => 'string',
			'DATE_MODIFIED' => 'datetime',
		));	

		Autoincrement::up('SUBMISSIONS', Yii::app()->db->driverName);




	}

	public function down()
	{
		Autoincrement::down('SUBMISSIONS', Yii::app()->db->driverName);

		
		$this->dropTable('SUBMISSIONS');
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
