<?php

return array(
	'components'=>array(
		
		'facebook'=>array(
		    'class' => 'ext.yii-facebook-opengraph.SFacebook',
		    'appId'=>'105687629555089', // needed for JS SDK, Social Plugins and PHP SDK
		    'secret'=>'a345a7c98ca4aafbf1a73d2a277d65df', // needed for the PHP SDK 
		    //'locale'=>'en_US', // override locale setting (defaults to en_US)
		    //'jsSdk'=>false, // don't include JS SDK
		    //'async'=>true, // load JS SDK asynchronously
		    //'jsCallback'=>false, // declare if you are going to be inserting any JS callbacks to the async JS SDK loader
		    'status'=>true, // JS SDK - check login status
		    //'cookie'=>true, // JS SDK - enable cookies to allow the server to access the session
		    //'oauth'=>true,  // JS SDK -enable OAuth 2.0
		    //'xfbml'=>true,  // JS SDK - parse XFBML / html5 Social Plugins
		    //'html5'=>true,  // use html5 Social Plugins instead of XFBML
		    //'ogTags'=>array(  // set default OG tags
		    //    'title'=>'quizmo',
		    //    'description'=>'splizam?',
		    //    'image'=>'URL_TO_WEBSITE_LOGO',
		    //),
		),

				
	),
);


?>
