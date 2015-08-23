<?php
require_once ('../system/smarty.inc');
require_once ('../system/login.inc.php');
require_once ('../system/prego_m.php');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_promise.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_corporate.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/mdao/Class_mp_request.php');
require_once ('../system/mdao/Class_mp_request_add.php');

$request_dao = new Class_mp_request;
$account_dao = new Class_mp_account;
$corporate_dao = new Class_mp_corporate;
$request_add_dao = new Class_mp_request_add;
$promise_spec_dao = new Class_mp_promise_spec;

	session_start ();
if (isset ( $_GET ['csv'] ) && ($_GET ['csv'] == "download") || isset ( $_GET ['hist'] ) && ($_GET ['hist'] == "2")) {

	$forms = $_SESSION ['MSEARCH'] ['bill_search'];
} else {
	$forms = $_POST;
	$_SESSION ['MSEARCH'] ['bill_search'] = $forms;
}

if (isset ( $_GET ['request_flag'] ) && $_GET ['request_flag'] != '') {
	$request_id = $_GET ['request_id'];

	$content_temp_str = $_GET ['content_temp'];
	$money_temp_str   = $_GET ['money_temp'];

	$content = explode ( ',', $content_temp_str );
	$money   = explode ( ',', $money_temp_str );

	foreach ( $content as $k => $v ) {
		foreach ( $money as $kk => $vv ) {
			if ($k == $kk) {

				$con_val = array ();
				$con_val ['request_id'] = $request_id;
				$con_val ['content'] = $v;
				$con_val ['money'] = $vv;
				$request_add_dao->add0 ( $con_val );
			}
		}
	}
}

if (isset ( $_GET ['flag'] ) && $_GET ['flag'] != '') {
	$values = array ();
	$corporate_id = $_GET ['corporate_id'];
	
	$promise_id = $_GET ['promise_id'];
	// set where condition
	$where = "corporate_id = '$corporate_id'";
	if ($_GET ['flag'] == 'btn_chk') {
		// set update mp_payment values
		$values ['request_status'] = '1';
	} else if ($_GET ['flag'] == 'btn_fix') {
		// set update mp_payment values
		$values ['request_status'] = '2';
	}
	// update data
	$request_dao->editbywhere ( $where, $values );

	$promise_spec_where = "promise_id = '$promise_id' ";
	$promise_spec_dao->editbywhere ( $promise_spec_where, $values );
}

$where_request_arr = array();
$page = array ();

$dosearch = FALSE;

if (isset ( $forms ['search'] ) && (! empty ( $forms ['search'] ))) {
	$dosearch = TRUE;
}
if (isset ( $forms ['page'] ) && is_numeric ( $forms ['page'] )) {
	$dosearch = TRUE;
	$page ['current'] = $forms ['page'];
} else {
	$page ['current'] = 1;
}
$page ['item'] = PAGE_MAX;

if($auth == '2'){
	$dosearch = true;
}

// do search
if ($dosearch) {
	// corporate auth 
	if ($auth == '2') {
		$login_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_ID'];
		$sql = "select * from mp_account where login_id = '$login_id' ";
		$account_data = $account_dao->get_rows ( $sql );
		foreach ( $account_data as $k => $v ) {
			$corporate_id = $v ['other_id'];
		}
		/*
		$corporate_data = $corporate_dao->get ( $corporate_id );
			
		$corporate_name = $corporate_data ['corporate_name'];
		$corporate_id = $corporate_data ['corporate_id'];
		*/
		$where_request_arr [] = "corporate_id = '$corporate_id' ";
		// prego auth
	} else {
		$corporate_name = $forms ['corporate_name'];
	}
	
	// set query condition corporate_name
	if (! empty ( $corporate_name )) {
		$where_request_arr [] = " corporate_name = '$corporate_name' ";
	}

	// deal with year
	if ($auth == '1') {
		
		if ($forms ['year'] != '') {
			$year = $forms ['year'];
		}
		
		if ($forms['month'] != '') {
			$nowmonth = $forms['month'] + 1;
			if ($nowmonth > 9) {
				$month = $nowmonth;
			} else {
				
				$month = '0' . $nowmonth;
			}
		}
		
		if (! empty ( $year ) && ! empty ( $month )) {
			$date = $year . '-' . $month;
			$where_request_arr[] = "request_time like '$date%'";
		}elseif (! empty ( $year ) ){
			$date = $year . '-' ;
			$where_request_arr[]  = "request_time like '$date%'";
		}elseif (! empty ( $month ) ){
			$date = '-'. $month;
			$where_request_arr[]  = "request_time like '%$date%'";
		}
	}
		

	// get request data
	$request_data = $request_dao->search($where_request_arr, $page);
	
	$request_promise_id_arr = array();
	$request['mutirow'] = array();
	foreach ($request_data as $k => $v) {
		
// 		$request_promise_id_arr[] = $v['promise_id'];
		$request_promise_id = $v['promise_id'];
		
		$sql = "select * from mp_promise_spec where promise_id = '$request_promise_id'";
		$request_promise_spec_data = $promise_spec_dao->get_rows($sql);
		$num = 0;
		$number = 0;
		foreach ($request_promise_spec_data as $kk => $vv) {
			if($vv['status'] == '3'){
				$num = $num + 1;
			}
		}
		
		if($num > 0){
			$request['mutirow'][] = array(
					"promise_id" => $request_promise_id,
			);
		}else {
			$number = $number + 1;
		}
	}
	
	
	$page['cnt'] = $page['cnt']-$number;
	
}

if ($auth == '1') {
	//	$select = array (
	//			'' => "選択してください"
	//	);
	$m_year[""]  = "選択してください";
	foreach ($year_arr as $k => $v) {
		$m_year[$k] = $v;
	}
	
	$m_month[""]  = "選択してください";
	foreach ($month_arr as $k => $v) {
		$m_month[$k] = $v;
	}

	
	$smarty->assign ( 'year', $m_year );
	$smarty->assign ( 'month', $m_month );
}
if (isset ( $_GET ['flag'] ) && $_GET ['flag'] != ''){
	header ( "Location: ./bill_refer.php?id=".$_GET['request_id']."&&corporate_id=".$_GET['corporate_id']."&&request_time=".$_GET['request_time']."&&request_status=".$_GET['request_status'] );
	exit ();
}

if(isset($forms)) $smarty->assign('forms', $forms); 
if(isset($request_data)) $smarty->assign('request_data', $request_data);
if(isset($request['mutirow'])) $smarty->assign('mutirow', $request['mutirow']);

$smarty->assign ( 'auth', $auth );
$smarty->assign ( 'page', $page );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'bill_search.html' );
?>