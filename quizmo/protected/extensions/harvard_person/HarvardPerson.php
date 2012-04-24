<?php
/***********************



Here is a dump of one iteration of the data object:

harvardedulastdateofattendance =>
sn => Clevenger
cn => Jazahn Clevenger
edupersonaffiliation => employee
harvardedumailprivacy => 5
harvardeduphoneprivacy => 5
harvardeduemployeeprivacy => 5
harvardeduimageprivacy => 4
harvardedulastjobterminatedon =>
harvardeduferpapaststudentindicator => FALSE
harvardeduferpastatus => FALSE
title => World Wide Web Instructional Software Developer
harvardedujobdn => cn=CLEVENGER9d8880c638432c3bd99c0c938203e9e9 JOB 0, ou=jobs, o=Harvard University Core, dc=huid, dc=harvard, dc=edu
harvardeduprimejobdn => cn=CLEVENGER9d8880c638432c3bd99c0c938203e9e9 JOB 0, ou=jobs, o=Harvard University Core, dc=huid, dc=harvard, dc=edu
telephonenumber => +1 617 496 8502
mail => jcleveng@fas.harvard.edu
harvardedudisplaysortname =>
generationqualifier =>
harvardedusuffixqualifier =>
personaltitle =>
harvardedumiddlename =>
givenname => Jazahn
displayname =>
harvardeduresidencehouse =>
harvardedustudentstatus =>
harvardeduidnumber => 80719647
count =>



Usage:  after a search >>
$person = new HarvardPerson();
$person->getByUid("80719647");
 
foreach($person->data[0] as $key => $value){ 
	echo "$key => ".$value[0]."<br />";
}
// so data[0] has the first result, and presumably each key can have multiple values...  which I don't really care about.



************************/
// extending CApplicationComponent for getting the config/main.php variables
class HarvardPerson extends CApplicationComponent {

	private $ds;
	private $r;
	
	// These 3 vars need to be public for the CApplicationComponent to be able to import the values from the config/main.php
	//private $ldap_app = "icg";
	//private $ldap_pass = "5b3w9yDm";
	//private $ldap_server = 'ldaps://hu-ldap-test.harvard.edu';
	
	public $ldap_app;
	public $ldap_pass;
	public $ldap_server;
	
	
	public $fname;
	public $lname;
	public $full_name;
	public $email;	
	public $affiliation;	
	public $huid;

	private $bindstring = "uid=icg,ou=applications,o=Harvard University Core,dc=huid,dc=harvard,dc=edu";
	//is this one necessary?
	private $searchstring = "ou=people,o=Harvard University Core, dc=huid, dc=harvard, dc=edu";


	public $data;

	// because this is extending CApplicationComponent I had to change this from a constructor
	//function __construct($huid=''){
	function setup($huid=''){
        
		if(isset($_SESSION['HarvardPerson']) && $_SESSION['HarvardPerson']['huid'] == $huid && $huid != ''){
			//let's not do a thousand connects if we already have the data
			//we have the data in the session, so pull it all from there
			$this->fname = $_SESSION['HarvardPerson']['fname'];
			$this->lname = $_SESSION['HarvardPerson']['lname'];
			$this->full_name = ($_SESSION['HarvardPerson']['displayname'] != '') ? $_SESSION['HarvardPerson']['displayname'] : $_SESSION['HarvardPerson']['full_name'];
			$this->email = $_SESSION['HarvardPerson']['email'];
			$this->affiliation = $_SESSION['HarvardPerson']['affiliation'];
			$this->huid = $_SESSION['HarvardPerson']['huid'];
			
		} else {
			//else this is a new connection or change
			
			$this->connect();
			$this->bind();

			if($huid != ''){
				$this->getByUid($huid);
			}
			
		}
	}

	function connect(){
		$this->ds = ldap_connect($this->ldap_server);
		if($this->ds === FALSE) {
			$this->_error("connecting");
		}
	}
	
	function close(){
		if($this->ds) {
			$result = ldap_close($this->ds);
			if($result === FALSE) {
				$this->_error("closing connection");
			}
		}
	}
		
	function bind(){
		$this->r = ldap_bind($this->ds, "uid=".$this->ldap_app.",ou=applications,o=Harvard University Core,dc=huid,dc=harvard,dc=edu", $this->ldap_pass); 
		if($this->r === FALSE) {
			$this->_error("binding");
		}
	}

	function search($uid = null){
		if($uid === null) {
            $this->_error("search missing user ID parameter");
			return false;
		}

		$sr = ldap_search($this->ds, "ou=people,o=Harvard University Core, dc=huid, dc=harvard, dc=edu", "harvardeduidnumber=$uid");
		if($sr === FALSE) {
			$this->_error("searching");
		}

		return $sr;
	}

	function get_entries($result) {
		$entries = ldap_get_entries($this->ds, $result);
		if($entries === FALSE) {
			$this->_error("getting entries");
		}

		return $entries;
	}

	function getByUid($uid){
		$sr = $this->search($uid);
		$this->data = $this->get_entries($sr);
		
		$this->fname = $this->data[0]['givenname'][0];
		$this->lname = $this->data[0]['sn'][0];
		$this->full_name = $this->data[0]['cn'][0];
		$this->email = $this->data[0]['mail'][0];
		$this->affiliation = $this->data[0]['edupersonaffiliation'][0];
		$this->huid = $uid;
		
		$_SESSION['HarvardPerson']['fname'] = $this->fname;
		$_SESSION['HarvardPerson']['lname'] = $this->lname;
		$_SESSION['HarvardPerson']['full_name'] = $this->full_name;
		$_SESSION['HarvardPerson']['email'] = $this->email;
		$_SESSION['HarvardPerson']['affiliation'] = $this->affiliation;
		$_SESSION['HarvardPerson']['huid'] = $this->huid;
	}

    function getAllByUid($uids = array()) {
        $uids = array_unique($uids);
        $filter = '';
        foreach($uids as $uid) {
            $filter .= "(harvardeduidnumber=$uid)";
        }
        if(count($uids) > 1) {
            $filter = "(|$filter)";
        }

        $sr = ldap_search($this->ds, "ou=people,o=Harvard University Core, dc=huid, dc=harvard, dc=edu", $filter);
        if($sr === FALSE) {
            $this->_error("searching");
            return false;
        }

        $entries = ldap_get_entries($this->ds, $sr);
        if($entries === FALSE) {
            $this->_error("getting entries");
            return false;
        }

        //error_log('entries => '.var_export($entries,1));

        $person = array();
        for($i = 0, $count = $entries['count']; $i < $count; $i++) {
            $entry = $entries[$i];
            $huid = $entry['harvardeduidnumber'][0];
            $person[$huid] = array(
                'huid'          => $huid,
                'fname'         => $entry['givenname'][0],
                'lname'         => $entry['sn'][0],
                'full_name'     => $entry['cn'][0],
                'email'         => $entry['mail'][0],
                'affiliation'   => $entry['edupersonaffiliation'][0]
            );
        }

        //error_log('person => '.var_export($person,1));

        return $person;
    }

	function _error($str = '') {
		$error = "LDAP ERROR: $str";
		if($this->ds !== FALSE) {
			$error .= ': ' . ldap_error($this->ds);
		}
		error_log($error);
	}

	function __destruct(){
		$this->close();
	}
}

?>
