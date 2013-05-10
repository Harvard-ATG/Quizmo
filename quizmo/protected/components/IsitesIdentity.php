<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */
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
		//error_log("sessionSetup");
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
		$this->email = Yii::app()->HarvardPerson->email;
		
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
	
	/**
	 * gets all users for a given class
	 */
	public function getAllUsers(){
 		$this->keyword = Yii::app()->getRequest()->getParam('keyword');
	 	
		// let's try to use the group service
		$course_groups = $this->courseGroups();
		//error_log(var_export($course_groups, 1));
		$users = array();
		if($course_groups != null){
			foreach($course_groups->groups as $group_object){
				$group_id = $group_object->idType;
				$these_users = $this->courseMembers($group_id);
				//error_log(var_export($these_users, 1));
				$this_user = array();
			
				// run through all the members
				foreach($these_users->members as $member){
				
					// turn the object into an array we can add to
					foreach($member as $key => $value){
						$this_user[$key] = $value;
					}
				
					// set the appropriate permission level for them
					switch($group_id){
						case 'ScaleCourseSiteStaff':
							$this_user['group'] = UserIdentity::ADMIN;
							$this_user['group_string'] = UserIdentity::ADMIN_STRING;
						break;
						case 'ScaleCourseSiteEnroll':
							$this_user['group'] = UserIdentity::ENROLLEE;
							$this_user['group_string'] = UserIdentity::ENROLLEE_STRING;
						break;
						case 'ScaleCourseSiteGuest':
							$this_user['group'] = UserIdentity::GUEST;
							$this_user['group_string'] = UserIdentity::GUEST_STRING;
						break;
					}
					array_push($users, $this_user);
				
				}
				//$users = array_merge($users, $these_users->members);
			}
		}
		
		error_log(var_export($users, 1));
		
		return $users;
		
	}
	 
	/**
	 * iSites course groups service
	 * Getting course groups associated with at site:
	 *
	 * https://isites.harvard.edu/services/groups/course_groups/{keyword}/{userid}.[html|json|xml]
	 *
	 * The userid is for the PIN-authenticated user on whose behalf you are making this request.  
	 *
	 * This call returns a list of the course groups that are associated with this site.  This includes any "section" style groups that may exist, and will always include the staff, enrollee and guest groups.
	 *
	 */
	public function courseGroups(){
		
		$userpwd = Yii::app()->params->groupserviceKey.":".Yii::app()->params->groupservicePass;
		
		$url = "https://isites.harvard.edu/services/groups/course_groups/k28781/80719647.json";

		return IsitesIdentity::curl($userpwd, $url);
		
	}
	 
	/**
	 * iSites course members service
	 * Getting members of course groups:
	 *
	 * https://isites.harvard.edu/services/groups/course_group_members/{keyword}/{group type}:{groupid}/{userid}.[html|json|xml]
	 *
	 * The userid is for the PIN-authenticated user on whose behalf you are making this request.  
	 *
	 * This call returns the members of the specified group: userid, first name, last name, email address.  
	 *
	 * For the three standard staff/enrollee/guest groups, the URLs will look like:
	 *
	 * https://isites.harvard.edu/services/groups/course_group_members/{keyword}/ScaleCourseSiteStaff:{keyword}/{userid}.[html|json|xml]
	 * https://isites.harvard.edu/services/groups/course_group_members/{keyword}/ScaleCourseSiteEnroll:{keyword}/{userid}.[html|json|xml]
	 * https://isites.harvard.edu/services/groups/course_group_members/{keyword}/ScaleCourseSiteGuest:{keyword}/{userid}.[html|json|xml]
	 *
	 */
	public function courseMembers($idType){
		
		$userpwd = Yii::app()->params->groupserviceKey.":".Yii::app()->params->groupservicePass;

		$url = "https://isites.harvard.edu/services/groups/course_group_members/k28781/$idType:k28781/80719647.json";

		return IsitesIdentity::curl($userpwd, $url);
		
	}
	
	public function curl($userpwd, $url){
		$proxy = Yii::app()->params->proxy;

		$ch = curl_init();
		if(!$ch) {
			return false;
		}

		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_PROXY, $proxy);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 25);

		$data = curl_exec($ch);
		$info = curl_getinfo($ch);
		$error = curl_error($ch);
		//$result = array('data' => $data, 'info' => $info, 'error' => $error);

		curl_close($ch);
		if($error != '')
			error_log($error);
		
		return json_decode($data);
		
	}
	
	/**
	 * gets the photourl from the isites photo service
	 * 	
	 * @return string url
	 */
	public function getPhotoUrl($user_id, $size=128){
		$huid = User::getExternalId($user_id);
		return Yii::app()->isitestool->getPhotoUrl($huid, $size);

	}
	
	/**
	 * gets the group from the isites web service
	 * @return string group
	 */
	public function getGroup($user_id, $collection_id){
		$huid = User::getExternalId($user_id);
		
		return Yii::app()->isitestool->getGroup($huid);
	}
	
}


?>