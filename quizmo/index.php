<?php

error_reporting(E_ALL);
// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';
$deploy_stage = dirname(__FILE__).'/protected/config/deploy_stage.php';

// remove the following lines when in production mode
if($deploy_stage == 'dev')
	defined('YII_DEBUG') or define('YII_DEBUG',true);

// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

//putenv('ORACLE_HOME=/oracle');
//putenv("NLS_LANG=AMERICAN_AMERICA.UTF8");
 
require_once($yii);
Yii::createWebApplication($config)->run();



?>