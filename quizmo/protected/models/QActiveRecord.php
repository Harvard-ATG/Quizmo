<?php
// https://gist.github.com/2312855
class QActiveRecord extends CActiveRecord {
	
	
	public function afterSave(){

		if(Yii::app()->db->driverName == 'oci'){

			try {
				$connection=Yii::app()->db;
				$sql = "select {$this->sequenceName}.currval from dual";
				$result = $connection->createCommand($sql)->queryRow();
							
				$this->ID = $result['CURRVAL'];

			} catch (Exception $e) {
				//echo("Error: $e\n");
			}
			
		} else {
			// not implemented yet, doubt this will work
			$this->ID = Yii::app()->db->getLastInsertID();
			
		}
		
	}
	
	
}

?>