<?php

require_once "rc4crypt.php";
class Isitestool extends CApplicationComponent {
	
	public $encryptionKey;
	
	const SUPER = 21;
	const OWNER = 17;
	const ADMIN = 14;
	const ENROLLEE = 9;
	const GUEST = 7;
		
		
	public function getDecryptedUserId($userid) {
        
		$plaintext = rc4crypt::decrypt($this->encryptionKey, pack('H*', $userid));
        //error_log("encrypted=$userid decrypted=$plaintext");


        $decrypted_id = $timestamp = ''; 
        if($plaintext != '') {
            list($decrypted_id, $timestamp) = explode('|', $plaintext, 2); 
        }   

        return $decrypted_id;
    }

	/**
	* Returns the list of permissions as an array
	*/
	private function getPermissions(){
		$perm_list = array();
		$perm_str = isset($_REQUEST['permissions']) ? $_REQUEST['permissions'] : '';
		if(isset($perm_str) && $perm_str !== ''){
			$perm_list = preg_split('/,/', $perm_str);
		}
		return $perm_list;
	}
	
	
	public function isSuper() {
		return in_array(self::SUPER, $this->getPermissions());
	}
	public function isOwner() {
		return in_array(self::OWNER, $this->getPermissions());
	}
	public function isAdmin() {
		return in_array(self::ADMIN, $this->getPermissions());
	}
	public function isEnrollee() {
		return in_array(self::ENROLLEE, $this->getPermissions());
	}
	public function isGuest() {
		return in_array(self::GUEST, $this->getPermissions());
	}
	
	public function url($viewPath = null, $viewQuery = array(), $viewFragment = null) {
		
		$host = Yii::app()->getRequest()->getParam('urlRoot');
		$keyword = Yii::app()->getRequest()->getParam('keyword');
		$page_id = Yii::app()->getRequest()->getParam('pageid');
		$page_content_id = Yii::app()->getRequest()->getParam('pageContentId');
		$topic_id = Yii::app()->getRequest()->getParam('topicId');
		$state = Yii::app()->getRequest()->getParam('state');
        
		$parts = array(
			'scheme' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 'https' : 'http',
		    'host' => isset($host) ? $host : 'isites.harvard.edu',
		    'path' => 'icb/icb.do',
		    'query' => '',
		    'fragment' => $viewFragment,
		);
    
		$mergeQuery = array(
			'state' => $state,
			'keyword' => $keyword
		);

		if($state === 'popup') {
			$viewParams = $this->_queryAsViewParams($viewQuery);
			$mergeQuery = array_merge($mergeQuery, array(
				'topicid' => $topic_id, // Note the spelling: topicid, NOT topicId
				'view' => $viewPath)
			);
			$mergeQuery = array_merge($mergeQuery, $viewParams);
		} else {
			// pass view params back to our app via the "panel" query
			$panelView = $viewPath;
			$panelParams = array();
			if(!empty($viewQuery)) {
		    	foreach($viewQuery as $queryKey => $queryVal) {
					$panelParams[] = "$queryKey=$queryVal";
				}
				$panelView .= '?' . implode('&', $panelParams);
			}
            
			$mergeQuery = array_merge($mergeQuery, array(
				'topicId' => $topic_id,
				'pageContentId' => $page_content_id,
				'pageid' => $page_id,
				'panel' => $page_content_id.':r'.$panelView
			));
		}

		$parts['query'] = $mergeQuery;
        
		$full_url = $parts['scheme'] . '://' . $parts['host'] . '/' . $parts['path'] . '?' . http_build_query($mergeQuery);
		if(isset($parts['fragment'])) {
			$full_url .= '#' . $parts['fragment'];
		}
		
		return htmlspecialchars($full_url, ENT_QUOTES, 'UTF-8');
		
	
	}
	
	
}	
?>