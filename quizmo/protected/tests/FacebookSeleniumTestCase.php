<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
 
class FacebookSeleniumTestCase extends PHPUnit_Extensions_SeleniumTestCase
{
	
 
   	protected function login()
    {

			
			//echo("\nenter something: ");
			//$line = trim(fgets(STDIN)); // reads one line from STDIN
			//fscanf(STDIN, "%d\n", $number);
			//echo($number."\n");
			
			exit();
			
	        $this->open('http://quizmo.harvard.edu');
	
			$this->click("css=#login-btn");
			
			$this->waitForPageToLoad(30000); 
			
			$this->type("id=email", "facebook@jazahn.com");
			$this->type("id=pass", "");
			$this->waitForPageToLoad(30000); 
			$this->click("css=#ubefxt_2");
			$this->waitForPageToLoad(30000); 

			echo("\n***********************\n");
			echo($this->getTitle()."\n");
			echo("\n***********************\n");

	
	
	/*
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
			
		}
		*/

    }
}
?>
