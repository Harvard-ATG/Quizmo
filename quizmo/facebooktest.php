<?php


require_once("/web/quizmo/app/quizmo/protected/extensions/yii-facebook-opengraph/php-sdk-3.1.1/facebook.php");
error_reporting(E_ALL);


//facebook application
    $fbconfig['appid' ]     = "105687629555089";
    $fbconfig['secret']     = "a345a7c98ca4aafbf1a73d2a277d65df";
    $fbconfig['baseurl']    = "http://dev2.webroots.fas.harvard.edu:8240/index.php";

	// Create our Application instance (replace this with your appId and secret).
	$facebook = new Facebook(array(
	  'appId'  => '105687629555089',
	  'secret' => 'a345a7c98ca4aafbf1a73d2a277d65df',
	));

	// Get User ID
	$user = $facebook->getUser();

	// We may or may not have this data based on whether the user is logged in.
	//
	// If we have a $user id here, it means we know the user is logged into
	// Facebook, but we don't know if the access token is valid. An access
	// token is invalid if the user logged out of Facebook.

	if ($user) {
	  try {
	    // Proceed knowing you have a logged in user who's authenticated.
	    $user_profile = $facebook->api('/me');
	  } catch (FacebookApiException $e) {
	    error_log(var_export($e, 1));
	    $user = null;
	  }
	}

	// Login or logout url will be needed depending on current user state.
	if ($user) {
	  $logoutUrl = $facebook->getLogoutUrl();
	} else {
	  $loginUrl = $facebook->getLoginUrl();
	}

	// This call will always work since we are fetching public data.
	$naitik = $facebook->api('/naitik');

	?>
	<!doctype html>
	<html xmlns:fb="http://www.facebook.com/2008/fbml">
	  <head>
	    <title>php-sdk</title>
	    <style>
	      body {
	        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
	      }
	      h1 a {
	        text-decoration: none;
	        color: #3b5998;
	      }
	      h1 a:hover {
	        text-decoration: underline;
	      }
	    </style>
	  </head>
	  <body>
	    <h1>php-sdk</h1>

	    <?php if ($user): ?>
	      <a href="<?php echo $logoutUrl; ?>">Logout</a>
	    <?php else: ?>
	      <div>
	        Login using OAuth 2.0 handled by the PHP SDK:
	        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
	      </div>
	    <?php endif ?>

	    <h3>PHP Session</h3>
	    <pre><?php print_r($_SESSION); ?></pre>

	    <?php if ($user): ?>
	      <h3>You</h3>
	      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

	      <h3>Your User Object (/me)</h3>
	      <pre><?php print_r($user_profile); ?></pre>
	    <?php else: ?>
	      <strong><em>You are not Connected.</em></strong>
	    <?php endif ?>

	    <h3>Public profile of Naitik</h3>
	    <img src="https://graph.facebook.com/naitik/picture">
	    <?php echo $naitik['name']; ?>
	  </body>
	</html>
?>