<?php

class Url extends CWidget {

	public $href;
	
	public function init(){
	
	}

	public function run(){
		
		echo "Url: ";
		if(Yii::app()->params['authMethod'] == "isites"){
			
			print("{$this->href}");
		
		} else {
			print("{$this->href}");
		
		}
		

	}

}

?>