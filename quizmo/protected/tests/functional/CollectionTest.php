<?php
 
class CollectionTest extends QSeleniumTestCase
{
	
    protected function setUp()
    {
        $this->setBrowserUrl('http://isites.harvard.edu/icb/icb.do?keyword=k28781&pageid=icb.page495107');
    }
 
    public function testIndex()
    {

		$this->login();

        $this->open('http://isites.harvard.edu/icb/icb.do?keyword=k28781&pageid=icb.page495107');
		
		$this->assertTitle('JaZhan');

		$this->assertElementPresent('css=#collections-container');
		//$this->assertElementContainsText('css=#collections-container', 'icb.topic');
    }
}
?>
