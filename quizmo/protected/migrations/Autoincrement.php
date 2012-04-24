<?php

class Autoincrement {
	function up($table_name, $driver){
	
		if($driver == 'mysql') {
			$createAutoincrement = <<< SQL
ALTER TABLE $table_name MODIFY COLUMN id INT NOT NULL AUTO_INCREMENT
SQL;
			
			$this->execute($createAutoincrement);
		}

		if($driver == 'oci') {

			$createSequenceSql = <<< SQL
create sequence {$table_name}_SEQ 
start with 1 
increment by 1 
nomaxvalue
nocache
SQL;

			$createTriggerSql = <<< SQL
create or replace trigger {$table_name}_SEQ_TRIGGER
before insert on {$table_name}
for each row
begin
select {$table_name}_SEQ.nextval into :new.id from dual;
end;
SQL;

			$this->execute($createSequenceSql);
			$this->execute($createTriggerSql);
		}
	
	}
	
	function down($table_name, $driver){
		if($driver == 'oci') {
			// trigger needs to be dropped before the table or it gets "kindof" dropped with the table drop
			$this->execute("DROP SEQUENCE {$table_name}_SEQ");
			$this->execute("DROP TRIGGER {$table_name}_SEQ_TRIGGER");
		}
	}
	
	
}


?>