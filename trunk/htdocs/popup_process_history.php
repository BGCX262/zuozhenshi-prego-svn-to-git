<?php
require_once ('../system/smarty.inc');
require_once ('../system/mdao/Class_mp_promise_operation_history.php');

$operation_history_dao = new Class_mp_promise_operation_history ();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	
	$promise_id = $_GET ['promise_id'];
	$promise_spec_id = $_GET['promise_spec_id'];
	
	$sql = "select * from mp_promise_operation_history where promise_id = '$promise_id' and promise_spec_id = '$promise_spec_id' ";
	
	$operation_history_data = $operation_history_dao->get_rows ( $sql );
}

if (isset ( $operation_history_data ))
	$smarty->assign ( 'operation_history_data', $operation_history_data );

$smarty->display ( 'popup_process_history.html' );
?>