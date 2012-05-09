<?php

// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../../yii/framework/yiit.php';
$config=dirname(__FILE__).'/../config/test.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',1);

require_once($yiit);
require_once(dirname(__FILE__).'/WebTestCase.php');

Yii::createWebApplication($config);
