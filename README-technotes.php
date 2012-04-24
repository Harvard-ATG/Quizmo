*******************************************************************************
--Facebook-opengraph extension
in config/main.php
<?
'components'=>array(
  'facebook'=>array(
    'class' => 'ext.yii-facebook-opengraph.SFacebook',
    'appId'=>'YOUR_FACEBOOK_APP_ID', // needed for JS SDK, Social Plugins and PHP SDK
    'secret'=>'YOUR_FACEBOOK_APP_SECRET', // needed for the PHP SDK 
    //'locale'=>'en_US', // override locale setting (defaults to en_US)
    //'jsSdk'=>true, // don't include JS SDK
    //'async'=>true, // load JS SDK asynchronously
    //'jsCallback'=>false, // declare if you are going to be inserting any JS callbacks to the async JS SDK loader
    //'status'=>true, // JS SDK - check login status
    //'cookie'=>true, // JS SDK - enable cookies to allow the server to access the session
    //'oauth'=>true,  // JS SDK -enable OAuth 2.0
    //'xfbml'=>true,  // JS SDK - parse XFBML / html5 Social Plugins
    //'html5'=>true,  // use html5 Social Plugins instead of XFBML
    //'ogTags'=>array(  // set default OG tags
        //'title'=>'MY_WEBSITE_NAME',
        //'description'=>'MY_WEBSITE_DESCRIPTION',
        //'image'=>'URL_TO_WEBSITE_LOGO',
    //),
  ),
),
?>

in components/Controller.php
<?
protected function afterRender($view, &$output)
{
    parent::afterRender($view,$output);
    //Yii::app()->facebook->addJsCallback($js); // use this if you are registering any $js code you want to run asyc
    Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
    Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags
    return true;
}
?>

*********************************************************************************
--HarvardPerson "extension"
	Tried to use the class as it exists in other projects (CATool, WCScheduler)
	Had to make some modifications
in extensions/harvard_person/HarvardPerson.php
    had to extend HarvardPerson off of CApplicationComponent
<?
    class HarvardPerson extends CApplicationComponent
?>
    make the 3 settings public so the CApplicationComponent can replace them from the config/main
<?
	public $ldap_app;
	public $ldap_pass;
	public $ldap_server;
?>
    changed the constructor to "setup" since CApplicationComponent doesn't want us to overload the constructor
<?
    function setup($huid=''){
?>


in config/main.php
<?
'components'=>array(
	'HarvardPerson'=>array(
		'class' => 'ext.harvard_person.HarvardPerson',
		'ldap_app'=>'icg',
		'ldap_pass'=>'5b3w9yDm',			
		'ldap_server'=>'ldaps://hu-ldap-test.harvard.edu',			
	),
),

?>


*********************************************************************************
--isitestool extension
extensions/isitestool/Isitestool.php

in config/main.php
<?
'isitestool'=>array(
	'class' => 'ext.isitestool.Isitestool',
	'encryptionKey' => 'icgaskrjbsdlknsdaouvggfgfxkhpojdfgkjgretmnvsytcffthpokjyudjhvsefhgcewrfkjdgjkgicg',	
),
?>

*********************************************************************************

--PHPUnit
in app/yii/framework/test/CTestCase.php
  because we're using an older version of php, which in turn means an older version of phpunit
  we have to replace the require for Autoload to require Framework:
<?
  //require_once('PHPUnit/Autoload.php');
  require_once('PHPUnit/Framework.php');
?>  


