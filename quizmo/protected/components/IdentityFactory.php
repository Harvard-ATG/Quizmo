<?php

class IdentityFactory {
	
	public function getIdentity($authmethod = ''){
		if($authmethod == ''){
			$authmethod = Yii::app()->params->authMethod;
		}
		
		switch($authmethod){
			case 'facebook':
				$identity = new FacebookIdentity();
				break;
			case 'isites':
				$identity = new IsitesIdentity();
				break;
			default:
				$identity = new UserIdentity();
				break;

		}
			
			
		return $identity;
		
	}
	
	public function logout(){
		
		switch(Yii::app()->params->authMethod){
			case 'facebook':
				FacebookIdentity::logout();
				break;
			case 'isites':
				IsitesIdentity::logout();
				break;
			default:
				
				break;

		}
		
		
		
	}
	
	
	
	
	
	
}




?>