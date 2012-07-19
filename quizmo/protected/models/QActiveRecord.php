<?php
// https://gist.github.com/2312855
/**
* This is the base class for all models
* 
* Currently only does the auto_increment for Oracle
* @link http://blogs.law.harvard.edu/acts/2012/04/05/yii-handling-getlastinsertid-with-oracle/
* @package app.Model
*/
class QActiveRecord extends CActiveRecord {
	
	/**
	* currently only does anything for Oracle
	*/
	public function afterSave(){


		if(Yii::app()->db->driverName == 'oci'){
			if(!isset($this->ID)){
				try {
					$connection=Yii::app()->db;
					$sql = "select {$this->sequenceName}.currval from dual";
					$result = $connection->createCommand($sql)->queryRow();
							
					$this->ID = $result['CURRVAL'];

				} catch (Exception $e) {
					//echo("Error: $e\n");
				}
			}
			
		} else {
			// not implemented yet, doubt this will work
			
		}
		
	}
	
	public function scopes()
    {
        return array(
            'sort_order'=>array(
                'order'=>'SORT_ORDER ASC'
            ),
            'id_order'=>array(
                'order'=>'ID ASC'
            ),
        );
    }
	
	public function defaultScope()
	{
	    return array(
	    	'order'=>'ID ASC'
	    );
	}
	
}

?>