<?php
/*
--------------------------------------------------------
--  DDL for Table QUIZMO_COLLECTIONS
--------------------------------------------------------

  CREATE TABLE "ISITESTOOLS"."QUIZMO_COLLECTIONS" 
   (	"ID" VARCHAR2(50 BYTE), 
	"NAME" VARCHAR2(50 BYTE)
   ) PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  DDL for Index QUIZMO_COLLECTIONS_PK
--------------------------------------------------------

  CREATE UNIQUE INDEX "ISITESTOOLS"."QUIZMO_COLLECTIONS_PK" ON "ISITESTOOLS"."QUIZMO_COLLECTIONS" ("ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS" ;
--------------------------------------------------------
--  Constraints for Table QUIZMO_COLLECTIONS
--------------------------------------------------------

  ALTER TABLE "ISITESTOOLS"."QUIZMO_COLLECTIONS" ADD CONSTRAINT "QUIZMO_COLLECTIONS_PK" PRIMARY KEY ("ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 COMPUTE STATISTICS 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT)
  TABLESPACE "ISITESTOOLS"  ENABLE;
 
  ALTER TABLE "ISITESTOOLS"."QUIZMO_COLLECTIONS" MODIFY ("ID" NOT NULL ENABLE);

--------------------------------------------------------
--  DDL for Trigger QUIZMO_COLLECTIONS_TRIGGER
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "ISITESTOOLS"."QUIZMO_COLLECTIONS_TRIGGER" 
BEFORE INSERT ON QUIZMO_COLLECTIONS
FOR EACH ROW
BEGIN
SELECT QUIZMO_COLLECTIONS_SEQ.nextval INTO :new.id FROM dual;
END;
/
ALTER TRIGGER "ISITESTOOLS"."QUIZMO_COLLECTIONS_TRIGGER" DISABLE;

*/
require_once("Autoincrement.php");

class m120402_195340_Collections extends CDbMigration
{
	public function up()
	{

		$this->createTable('COLLECTIONS', array(
			'ID' => 'pk',
			'OTHER_ID' => 'string',
			'TITLE' => 'string NOT NULL',
			'DESCRIPTION' => 'string',
			'DELETED' => "integer NOT NULL",
		));	

		Autoincrement::up('COLLECTIONS', Yii::app()->db->driverName);


	}

	public function down()
	{

		Autoincrement::down('COLLECTIONS', Yii::app()->db->driverName);
		
		$this->dropTable('COLLECTIONS');
		
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