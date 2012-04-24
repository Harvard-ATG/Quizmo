<?php
try {
	print getenv('ORACLE_HOME')."\n";
	print var_export($_ENV,1 )."\n";
	
	
	$user = "isitestools";
	$pass = "iseegeeisitet00ls";
    //$dbh = new PDO('oci:dbname=icgdb.fas.harvard.edu:1521/isitestools;charset=UTF8', $user, $pass);
    $dbh = new PDO('oci:dbname=icgdbdev.fas.harvard.edu;charset=UTF8', $user, $pass);
    foreach($dbh->query('SELECT * from QUIZMO_QUIZ where rownum = 1') as $row) {
        print_r($row);
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>\n\n";
    die();
}
?>
