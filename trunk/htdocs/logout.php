<?php
require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');
require_once ('../system/Class_ERROR.php');
require_once ('../system/login.inc.php');

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	
	$_SESSION = array ();
	session_destroy ();
	// delete cookie
	setcookie("login_id", "", time()-300);
	setcookie("login_pass", "", time()-300);
	
	header ( "Location: ./index.php" );
	exit ();
}
?>