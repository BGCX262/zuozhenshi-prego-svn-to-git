<?php

require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');
require_once ('../system/login.inc.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/prego_m.php');

session_name ( 'PREGO_ADMIN' );
session_start ();
$dao = new Class_mp_account ();

if (isset ( $_POST ['csv'] ) && ($_POST ['csv'] == "download") || isset ( $_POST ['hist'] ) && ($_POST ['hist'] == "2")) {
	$forms = $_SESSION ['MSEARCH'] ['corporate'];
} else {
	$forms = $_POST;
	$_SESSION ['MSEARCH'] ['corporate'] = $forms;
}

$wherearr = array ();
$page = array ();

if (isset ( $forms ['page'] ) && is_numeric ( $forms ['page'] )) {
	$page ['current'] = $forms ['page'];
} else {
	$page ['current'] = 1;
}
$page ['item'] = PAGE_MAX;

// set where condition
$wherearr [] = "other_id = '0'";
$wherearr [] = "sorts = '3'";

// if auth = 3, set where condition login_id
if ($auth == '3') {
	$login_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_ID'];
	$wherearr [] = " login_id = '$login_id' ";
}

$data = $dao->search ( $wherearr, $page );

if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $data ))
	$smarty->assign ( 'data', $data );
if (isset ( $page ))
	$smarty->assign ( 'page', $page );

$smarty->assign ( 'auth', $auth );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->assign ( 'pageing', $smarty->fetch ( 'page.html' ) );
$smarty->display ( 'specialist_unregistered.html' );
?>