<?php
/*
--------------------------------------------------------
--  DDL for Table QUIZMO_ANSWER
--------------------------------------------------------

  CREATE TABLE "ISITESTOOLS"."QUIZMO_ANSWER" 
   (	"ANSWER_ID" NUMBER, 
	"QUESTION_ID" NUMBER, 
	"QUESTION_TYPE" VARCHAR2(1 BYTE)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  DDL for Index SYS_C0037175
--------------------------------------------------------

  CREATE UNIQUE INDEX "ISITESTOOLS"."SYS_C0037175" ON "ISITESTOOLS"."QUIZMO_ANSWER" ("ANSWER_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  DDL for Index QUIZMO_ANSWER_QUESTION_ID
--------------------------------------------------------

  CREATE INDEX "ISITESTOOLS"."QUIZMO_ANSWER_QUESTION_ID" ON "ISITESTOOLS"."QUIZMO_ANSWER" ("QUESTION_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  Constraints for Table QUIZMO_ANSWER
--------------------------------------------------------

  ALTER TABLE "ISITESTOOLS"."QUIZMO_ANSWER" MODIFY ("ANSWER_ID" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_ANSWER" MODIFY ("QUESTION_ID" NOT NULL ENABLE);
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_ANSWER" ADD PRIMARY KEY ("ANSWER_ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS"  ENABLE;


"ANSWER_ID" NUMBER, 
"QUESTION_ID" NUMBER, 
"QUESTION_TYPE" VARCHAR2(1 BYTE)

*/
require_once("Autoincrement.php");

class m120402_195455_Answers extends CDbMigration
{
	public function up()
	{
		$this->createTable('ANSWERS', array(
			'ID' => 'pk',
			'QUESTION_ID' => 'integer NOT NULL',
			'QUESTION_TYPE' => 'string NOT NULL',
			'TEXTAREA_ROWS' => 'integer',
			'ANSWER' => 'string',
			'IS_CASE_SENSITIVE' => 'integer',
			'ANSWER_ORDER' => 'integer',
			'IS_CORRECT' => 'integer NOT NULL',
			'TOLERANCE' => 'float',
		));	
		
		Autoincrement::up('ANSWERS', Yii::app()->db->driverName);



		
	}

	public function down()
	{
		Autoincrement::down('ANSWERS', Yii::app()->db->driverName);

		$this->dropTable('ANSWERS');
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