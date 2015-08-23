<?php
require_once ('../system/smarty.inc');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_payment_add.php');
require_once ('../system/mdao/Class_mp_payment.php');


$payment_dao = new Class_mp_payment;

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	
	if(isset($_GET['id']) && $_GET['id'] != ''){
		
		$id = $_GET['id'];
		
	}
	
	if(isset($_GET['model']) && $_GET['model'] != ''){
		$smarty->assign('request_id', $id);
		$smarty->assign('model_flag', $_GET['model']);
	}else{
		$smarty->assign('payment_id', $id);
	}
}



$smarty->display('popup_payment_edit.html');
?>