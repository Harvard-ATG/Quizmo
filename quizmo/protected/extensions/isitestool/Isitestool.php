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
	
	
}	
?>