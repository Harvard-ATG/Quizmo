<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


/* example of the facebookuser object
array (
  'id' => '1074810815',
  'name' => 'JaZahn Clevenger',
  'first_name' => 'JaZahn',
  'last_name' => 'Clevenger',
  'link' => 'http://www.facebook.com/jazahn',
  'username' => 'jazahn',
  'work' => 
  array (
    0 => 
    array (
      'employer' => 
      array (
        'id' => '105930651606',
        'name' => 'Harvard University',
      ),
      'position' => 
      array (
        'id' => '125275397516332',
        'name' => 'Sr. Software Eng.',
      ),
      'start_date' => '2008-01',
      'end_date' => '0000-00',
    ),
  ),
  'education' => 
  array (
    0 => 
    array (
      'school' => 
      array (
        'id' => '109564489069752',
        'name' => 'Delsea Regional High School',
      ),
      'year' => 
      array (
        'id' => '144503378895008',
        'name' => '1999',
      ),
      'type' => 'High School',
    ),
    1 => 
    array (
      'school' => 
      array (
        'id' => '105930651606',
        'name' => 'Harvard University',
      ),
      'type' => 'College',
    ),
  ),
  'gender' => 'male',
  'timezone' => -4,
  'locale' => 'en_US',
  'verified' => true,
  'updated_time' => '2011-03-28T21:05:32+0000',
)
*/

class FacebookIdentity extends UserIdentity {
	
	public function __construct(){
		//error_log("FacebookIdentity::construct");
		$this->authenticate();
			
	}
	
	// the following code is an attempt to handle the queer errors that are not properly handled by the facebook sdk
	//  it doesn't seem to work presently
	//  https://developers.facebook.com/blog/post/500/
	private function checkAccessToken(){
		
		//error_log("FacebookIdentity::checkAccessToken");

		$app_id = Yii::app()->facebook->appId;
		$app_secret = Yii::app()->facebook->secret; 
		//$my_url = "http://dev2.webroots.fas.harvard.edu:8240/index.php";
		$my_url = Yii::app()->facebook->redirect;

		// known valid access token stored in a database 
		$access_token = Yii::app()->facebook->getAccessToken();

		$code = @$_REQUEST["code"];

		// If we get a code, it means that we have re-authed the user 
		//and can get a valid access_token. 
		if (isset($code)) {
			$token_url="https://graph.facebook.com/oauth/access_token?client_id="
		      . $app_id . "&redirect_uri=" . urlencode($my_url) 
		      . "&client_secret=" . $app_secret 
		      . "&code=" . $code . "&display=popup";
		

			// Now all file stream functions can use this context.		
		    $response = $this->curl_get_file_contents($token_url);
		    $params = null;
		    parse_str($response, $params);
		    $access_token = @$params['access_token'];
		  }


		  // Attempt to query the graph:
		  $graph_url = "https://graph.facebook.com/me?"
		    . "access_token=" . $access_token;
		  $response = $this->curl_get_file_contents($graph_url);
		  $decoded_response = json_decode($response);

		  //Check for errors 
		  if (@$decoded_response->error) {
		  // check to see if this is an oAuth error:
		    if ($decoded_response->error->type== "OAuthException") {
		      // Retrieving a valid access token. 
		      $dialog_url= "https://www.facebook.com/dialog/oauth?"
		        . "client_id=" . $app_id 
		        . "&redirect_uri=" . urlencode($my_url);
		      //error_log("top.location.href='" . $dialog_url);
		    }
		    else {
		      //error_log("other error has happened");
		    }
		  } 
		  else {
		  // success
		    //error_log("success" . $decoded_response->name);
		    //error_log($access_token);
		  }
		
		
		return $access_token;
		
	}
	
	
	
	// note this wrapper function exists in order to circumvent PHP’s 
	  //strict obeying of HTTP error codes.  In this case, Facebook 
	  //returns error code 400 which PHP obeys and wipes out 
	  //the response.
	private function curl_get_file_contents($URL) {

		//error_log("FacebookIdentity::curl_get_file_contents");

	    $c = curl_init();
	    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($c, CURLOPT_URL, $URL);
	    //curl_setopt($c, CURLOPT_PROXY, "proxy.unix.fas.harvard.edu:8888");
	    $contents = curl_exec($c);
	    $err  = curl_getinfo($c,CURLINFO_HTTP_CODE);
	    curl_close($c);
	    if ($contents) return $contents;
	    else return FALSE;
	  }	
	
	public function authenticate(){

		//error_log("FacebookIdentity::authenticate");

		// getUser can sometimes be set when the user is in fact not logged in
		// therefore the only for sure way to detect if a user is logged in is to try an api call on /me
		try {
			
			// facebook's sdk for some reason doesn't handle their own access tokens well
			// so we have to check for an active access token before making one of these calls
			$access_token = $this->checkAccessToken();
			Yii::app()->facebook->setAccessToken($access_token);

			$facebookuser = Yii::app()->facebook->api('/me');
			//error_log(var_export($facebookuser, 1));
			$this->username = $facebookuser['username'];
			$this->name = $facebookuser['name'];
			$this->fname = $facebookuser['first_name'];
			$this->lname = $facebookuser['last_name'];
			//$this->password=$password;			
			
			$this->external_id = $facebookuser['id'];
			
			//error_log("going to setup (passed api(/me))");
			$this->setup();

		} catch (FacebookApiException $e){
			
			// facebook sdk team blowwwwwwws
			//error_log(var_export($e->__toString(), 1));
			//error_log(var_export($_SERVER, 1));
			
			$redirect_uri = (@$_SERVER['SCRIPT_URI']) ? $_SERVER['SCRIPT_URI'] : $_SERVER['HTTP_REFERER'];
			$redirect_uri = "http://quizmo.harvard.edu/site/login";
			
			// if redirect_uri is the logout url, we'll end up with an infinite loop...
			if(preg_match("/(.*)\/site\/logout/", $redirect_uri, $matches)){
				$redirect_uri = $matches[1];				
			}
			
			//Controller::redirect(Yii::app()->facebook->getLoginUrl());
			//error_log("redirecting to ".Yii::app()->facebook->getLoginUrl(array('redirect_uri'=>$redirect_uri, 'cancel_url'=>$redirect_uri)));
			Controller::redirect(Yii::app()->facebook->getLoginUrl(array('redirect_uri'=>$redirect_uri, 'cancel_url'=>$redirect_uri)));
			
		}
		
		
		
	}
	
	public function logout(){

		//error_log("FacebookIdentity::logout");

		try {
			Yii::app()->facebook->api("/me");
			@session_destroy();
			$logoutUrl = Yii::app()->facebook->getLogoutUrl();
			Yii::app()->facebook->destroySession();
			
			//error_log("redirecting to $logoutUrl");
			$this->redirect($logoutUrl);
			
		} catch (FacebookApiException $e){
			// this is how awesome facebook sdk is -- their exception doesn't even have the tostring implemented right
			//error_log(var_export($e->__toString(), 1));
		}
		
		
	}
	
	
	
	
}


?>