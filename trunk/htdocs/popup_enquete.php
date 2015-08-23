<?php
require_once ('../system/smarty.inc');
require_once ('../system/login.inc.php');
require_once ('../system/prego_m.php');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');

$promise_spec_dao = new Class_mp_promise_spec;

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	
	if(isset($_GET['id']) && $_GET['id'] != '' ){
		
		$promise_spec_id = $_GET['id'];
	}
	
}

if(isset($promise_spec_id) && $promise_spec_id != '') $smarty->assign('count_id', $promise_spec_id); 
//$smarty->assign('count_id', $promise_spec_id);

$smarty->display('popup_enquete.html');
?>