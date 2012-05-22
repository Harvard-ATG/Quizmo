<?php
 
class CollectionTest extends FacebookSeleniumTestCase
{
	
    protected function setUp()
    {
        $this->setBrowserUrl('http://quizmo.harvard.edu');
    }
 
    public function testIndex()
    {

		$this->login();

        $this->open('http://quizmo.harvard.edu');
		
		$this->assertTitle('Quizmo');

		//$this->assertElementPresent('css=#collections-container');
		//$this->assertElementContainsText('css=#collections-container', 'icb.topic');
    }
}
?>
