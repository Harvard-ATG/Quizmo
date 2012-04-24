<?php

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