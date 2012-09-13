<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

class RequireLogin extends CBehavior{
	
	
	public function attach($owner){
		$owner->attachEventHandler('onBeginRequest', array($this, 'handleBeginRequest'));
		
		
	}
	
	public function handleBeginRequest($event)
	{
		$identity = IdentityFactory::getIdentity();
		Yii::app()->user->login($identity);

	}

	
	
	
	
}





?>