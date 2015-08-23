<?php
require_once ('../system/smarty.inc');
require_once ('../system/prego_m.php');
require_once ('../system/login.inc.php');

$forms = $_GET;
if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
	
$tmphtml = $forms["nm"];



if ( $tmphtml == "popup_communication_memo" ) {
	require_once ('../system/mdao/Class_mp_spec_traffic_fee.php');
	require_once ('../system/mdao/Class_mp_promise_spec.php');
	$spec_traffic_dao = new Class_mp_spec_traffic_fee ();
	$promise_spec_dao = new Class_mp_promise_spec ();
	
	
	if (isset ( $_GET ['spec_id'] ) && $_GET ['spec_id'] != '') {
		$tra_spec_id = $_GET ['spec_id'];
		
		$sql = "select * from mp_spec_traffic_fee where spec_id = '$tra_spec_id'";
		$spec_traffic_data = $spec_traffic_dao->get_rows ( $sql );
		
		$traffic_name = array ();
		$traffic_fee = array ();
		$traffic_memo = array ();
		
		foreach ( $spec_traffic_data as $k => $v ) {
			$traffic_name_arr [] = $v ['traffic_name'];
			$traffic_fee [] = $v ['traffic_fee'];
			$traffic_memo [] = $v ['traffic_memo'];
		}
		$select = array (
				'' => "選択してください" 
		);
		$traffic_name = array_merge ( $select, $traffic_name_arr );
	}
	$id = $_GET ['id'];
	$promise_spec_data = $promise_spec_dao->get($id);
	$order = array("<br/>");
	$replace = "\n";
	$corporate_forms['memo'] = str_replace($order,$replace,$corporate_forms['memo']);
	$promise_spec_data['traffic_fee_detail'] = str_replace($order,$replace,$promise_spec_data['traffic_fee_detail']);
	$promise_spec_data['live_fee_detail'] = str_replace($order,$replace,$promise_spec_data['live_fee_detail']);
	$promise_spec_data['other_fee_detail'] = str_replace($order,$replace,$promise_spec_data['other_fee_detail']);
	
	
	//画面データお願いします
	//fdata
	
	if(isset($promise_spec_data)) $smarty->assign('promise_spec_data', $promise_spec_data); 
	$smarty->assign ( 'overtime_have', $promise_spec_overtime_have );
	$smarty->assign ( 'traffic_fee_have', $promise_spec_traffic_fee_have );
	$smarty->assign ( 'traffic_name', $traffic_name );
	$smarty->assign ( 'traffic_fee', $traffic_fee );
	$smarty->assign ( 'traffic_memo', $traffic_memo );
	$smarty->assign ( 'pro_spec_id', $id );
	$smarty->assign ( 'live_fee_have', $promise_spec_live_fee_have );
	$smarty->assign ( 'other_fee_have', $promise_spec_other_fee_have );
}


$smarty->display ( $tmphtml.".html" );

?>