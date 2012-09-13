<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

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