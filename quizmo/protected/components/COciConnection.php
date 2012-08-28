<?php
/**
 * COciConnection class file
 *
 * @author Ricardo Grana <rickgrana@yahoo.com.br>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2009 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

class COciConnection extends CDbConnection
{
        /**
         * Initializes the open db connection.
         * This method is invoked right after the db connection is established.  
         * @param PDO the PDO instance
         */
        protected function initConnection($pdo)
        {
                parent::initConnection($pdo);

                //Yii::trace('Setting Oracle case','system.db.schema.oci.CDbConnection');         
                //$pdo->setAttribute(PDO::ATTR_CASE,PDO::CASE_LOWER);
                
                Yii::trace('Setting NLS_DATE_FORMAT','system.db.schema.oci.CDbConnection');
                //$stmt=$pdo->prepare("alter session set NLS_DATE_FORMAT='dd/MM/yyyy HH24:MI:SS'");
				$stmt=$pdo->prepare("alter session set NLS_DATE_FORMAT='MM/dd/yyyy HH24:MI:SS'");
				$stmt->execute();       

                Yii::trace('Setting NLS_TIMESTAMP_FORMAT','system.db.schema.oci.CDbConnection');                
                //$stmt=$pdo->prepare("alter session set NLS_TIMESTAMP_FORMAT='dd/MM/yyyy HH24:MI:SS'");
                $stmt=$pdo->prepare("alter session set NLS_TIMESTAMP_FORMAT='MM/dd/yyyy HH24:MI:SS'");
				$stmt->execute();               
        }
}