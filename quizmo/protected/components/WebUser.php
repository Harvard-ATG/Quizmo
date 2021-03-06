<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */
	
class WebUser extends CWebUser {

	public $fname;
	public $lname;
	public $perm;
	public $perm_id;
	
	/**
	 * just took the CWebUser::login and added some vars
	 */
	public function login($identity,$duration=0)
	{

		$id=$identity->getId();
		$states=$identity->getPersistentStates();
		if($this->beforeLogin($id,$states,false))
		{
			$this->changeIdentity($id,$identity->getName(),$states);

			if($duration>0)
			{
				if($this->allowAutoLogin)
					$this->saveToCookie($duration);
				else
					throw new CException(Yii::t('yii','{class}.allowAutoLogin must be set true in order to use cookie-based authentication.',
						array('{class}'=>get_class($this))));
			}

			$this->afterLogin(false);
		}
		$this->fname = $identity->fname;
		$this->lname = $identity->lname;
		$this->perm = $identity->perm;
		$this->perm_id = $identity->perm_id;
		
		
		return !$this->getIsGuest();
	}
	
	/**
	 * this overloads CWebUser::checkAccess to circumvent the use of authManager,
	 * this is much simpler, 
	 * this is used in every controllers accessControl method accessRules when checking against roles
	 * @param integer $operation this is the id of the permission we're checking against
	 * @return boolean
	 */
	public function checkAccess($operation, $params=array()){

		if (empty($this->id)) {
			// Not identified => no rights
			//return false;
		}

		$role = Yii::app()->user->perm_id;
		if ($role == UserIdentity::SUPER) {
			return true; // super role has access to everything
		}
		// allow access if the operation request is the current user's role
		return ($operation === Yii::app()->user->perm);

	}
	
	/**
	 * overriding this method so we don't regenerate an id every time we log in
	 * because currently we have to auto log in every time we come here
	 * @todo: should remove this and add a conditional in the RequireLogin behavior... and make sure all user data is in the session
	 */
	protected function changeIdentity($id,$name,$states)
	{
		//error_log("changeIdentity");
		//Yii::app()->getSession()->regenerateID(true);
		$this->setId($id);
		$this->setName($name);
		$this->loadIdentityStates($states);
	}
	
	
	
	
}
	
?>