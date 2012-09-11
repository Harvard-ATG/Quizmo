<?php

class IsitesIdentity extends UserIdentity {
	
	protected $userid;
	private $keyword;
	private $topicId;
	private $permissions;
	
	public function __construct(){
		$this->sessionSetup();
		$this->authenticate();
		
	}
	
	/**
	 * note: this is linked to the layout
	 * the layout needs the following code in it:
	 * <session>
	 *  <attribute>
	 *   <name>QUIZMO_SESSION</name>
	 *   <value><?php echo session_id(); ?></value>
	 *  </attribute>
	 * </session>
	 * and that has to be in the body tag
	*/
	public function sessionSetup(){
		error_log("sessionSetup");
		// start a session with a given session_id...
		if(isset($_REQUEST['QUIZMO_SESSION']))
			@session_id($_REQUEST['QUIZMO_SESSION']);
		@session_start();
		
	}
	
	public function authenticate(){

		//error_log(var_export($_REQUEST, 1));

		$this->userid = Yii::app()->getRequest()->getParam('userid');
		$this->keyword = Yii::app()->getRequest()->getParam('keyword');
		$this->topicId = Yii::app()->getRequest()->getParam('topicId');
		$this->permissions = Yii::app()->getRequest()->getParam('permissions');
				
		$decrypted_userid = Yii::app()->isitestool->getDecryptedUserId($this->userid);

		//$this->username = "$decrypted_userid";
		Yii::app()->HarvardPerson->setup($decrypted_userid);
		//$this->id = Yii::app()->HarvardPerson->huid;
		$this->external_id = Yii::app()->HarvardPerson->huid;
		$this->username = Yii::app()->HarvardPerson->huid;
		$this->name = Yii::app()->HarvardPerson->full_name;
		$this->fname = Yii::app()->HarvardPerson->fname;
		$this->lname = Yii::app()->HarvardPerson->lname;
		
		// determine the level of permission...
		$perm = '';
		if(Yii::app()->isitestool->isGuest()){
			$perm = 'guest';
			$this->perm_id = UserIdentity::GUEST;
		}
		if(Yii::app()->isitestool->isEnrollee()){
			$perm = 'enrollee';
			$this->perm_id = UserIdentity::ENROLLEE;
		}
		if(Yii::app()->isitestool->isAdmin()){
			$perm = 'admin';
			$this->perm_id = UserIdentity::ADMIN;
		}
		if(Yii::app()->isitestool->isSuper()){
			$perm = 'super';
			$this->perm_id = UserIdentity::SUPER;
		}
		// set the collection we are logging in to with the highest level permission
		// TODO: use isites search service to get the collection name
		$this->collections[$this->topicId] = $perm;
		$this->perm = $perm;

		
		$this->setup();
		
	}
	

	
	/*
	* logout will be handled by isites...
	*/
	public function logout(){
		@session_destroy();
		$logoutUrl = 'http://isites.harvard.edu/icb/logout.do';
		
		$this->redirect($logoutUrl);
		
	}
	
	
}


?>