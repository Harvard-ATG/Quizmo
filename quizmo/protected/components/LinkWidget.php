<?php

class LinkWidget extends CWidget {

	public $href;
	public $text;

	public function init(){
	
	}

	public function run(){
		
		echo "LinkWidget: ";
		if(Yii::app()->params['authMethod'] == "isites"){
			print("<a href='{$this->href}'>{$this->text}</a>");
			
		
		} else {
			print("<a href='{$this->href}'>{$this->text}</a>");
		
		}
		

	}

}

?>