<?php

/**
 * Change the following URL based on your server configuration
 * Make sure the URL ends with a slash so that we can use relative URLs in test cases
 */
define('TEST_BASE_URL','http://localhost/testdrive/index-test.php/');

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class WebTestCase extends CWebTestCase
{
	/**
	 * Sets up before each test method runs.
	 * This mainly sets the base URL for the test application.
	 */
	protected function setUp()
	{
		parent::setUp();
		$this->setBrowserUrl(TEST_BASE_URL);
	}
	
	protected function login()
    {
		// if it's isites
		if(Yii::app()->params['authMethod'] == 'isites'){

	        $this->open('http://isites.harvard.edu');
	
			if(Yii::app()->params['isites']['type'] == 'xid'){
				$this->check('identifier=authenLoginType3');
			}
			$this->type("id=authenId", Yii::app()->params['isites']['username']);
			$this->type("id=authenPassword", Yii::app()->params['isites']['password']);
 
			$this->click("css=form input.login-button[type=submit]"); 
			//$this->click("link=Help");
			//$this->keyPress("id=authenPassword", 13);

			$this->waitForPageToLoad(30000); 
			// we then hit a redirect page
			// on the redirect page, we have to execute ANY selenium command 
			// to reset the "newPageLoaded" flag 
			// so waitForPageToLoad works again
			$this->click("css=p.site-name");
			$this->waitForPageToLoad(30000);
			
			
			echo("\n***********************\n");
			echo($this->getTitle()."\n");
			if($this->isElementPresent('css=div.narrow-text-area')){
				$error = $this->getText('css=div.narrow-text-area');
				echo("$error\n");
			} else {
				echo("not the redirect page...\n");
			}
			if($this->isElementPresent('css=div.dynamic-text-area')){
				$error = $this->getText('css=div.dynamic-text-area');
				echo("$error\n");
			} else {
				echo("no error...\n");
			}

			echo("***********************\n");
			
		} elseif(Yii::app()->params['authMethod'] == 'facebook'){
			
	   		$this->open('http://quizmo.harvard.edu');

			$this->click("css=#login-btn");

			$this->waitForPageToLoad(20000); 

			$this->type("id=email", "facebook@jazahn.com");
			$this->type("id=pass", "rutgerss");
			$this->click("css=#loginbutton input");
			$this->waitForPageToLoad(20000); 

			//echo("\n***********************\n");
			//echo($this->getTitle()."\n");
			//echo("\n***********************\n");

		
		}


    }
	
	
}
