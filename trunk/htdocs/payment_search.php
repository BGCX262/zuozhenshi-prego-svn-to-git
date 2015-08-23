<?php
require_once ('../system/smarty.inc');
require_once ('../system/login.inc.php');
require_once ('../system/prego_m.php');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/mdao/Class_mp_payment.php');
require_once ('../system/mdao/Class_mp_payment_add.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');

$account_dao = new Class_mp_account ();
$spec_dao = new Class_mp_specialist ();
$payment_dao = new Class_mp_payment ();
$promise_spec_dao = new Class_mp_promise_spec ();
$payment_add_dao = new Class_mp_payment_add ();

if (isset ( $_GET ['csv'] ) && ($_GET ['csv'] == "download") || isset ( $_GET ['hist'] ) && ($_GET ['hist'] == "2")) {

	$forms = $_SESSION ['MSEARCH'] ['payment_search'];
} else {
	$forms = $_POST;

	$_SESSION ['MSEARCH'] ['payment_search'] = $forms;
}

if (isset ( $_GET ['pay_flag'] ) && $_GET ['pay_flag'] != '') {
	
	$payment_id = $_GET ['payment_id'];
	
	$content_temp_str = $_GET ['content_temp'];
	$money_temp_str = $_GET ['money_temp'];
	
	$content = explode ( ',', $content_temp_str );
	$money = explode ( ',', $money_temp_str );
	
	foreach ( $content as $k => $v ) {
		foreach ( $money as $kk => $vv ) {
			if ($k == $kk) {
				
				$con_val = array ();
				$con_val ['payment_id'] = $payment_id;
				$con_val ['content'] = $v;
				$con_val ['money'] = $vv;
				//$con_val ['rate'] = PREGO_ZAIKIN_RATE;
				$payment_add_dao->add0 ( $con_val );
			}
		}
	}
}

// from pament_refer.html click OK button
if (isset ( $_GET ['flag'] ) && $_GET ['flag'] != '') {
	
	$values = array ();
	$spec_id = $_GET ['spec_id'];
	$promise_spec_id = $_GET ['promise_spec_id'];
	// set where condition
	$where = "spec_id = '$spec_id'";
	if ($_GET ['flag'] == 'btn_chk') {
		// set update mp_payment values
		$values ['pay_status'] = '1';
	} else if ($_GET ['flag'] == 'btn_fix') {
		// set update mp_payment values
		$values ['pay_status'] = '2';
	}
	// update data
	$payment_dao->editbywhere ( $where, $values );
	
	$promise_spec_where = "id = '$promise_spec_id' ";
	$promise_spec_dao->editbywhere ( $promise_spec_where, $values );
}


$wherearr = array ();
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

if ($auth == '3') {
	$dosearch = TRUE;
}

if (isset ( $_GET ['pay_flag'] ) && $_GET ['pay_flag'] != '') {
	$dosearch = TRUE;
}

if ($dosearch) {
	
	// specialist auth
	if ($auth == '3') {
		$login_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_ID'];
		$sql = "select * from mp_account where login_id = '$login_id' ";
		$account_data = $account_dao->get_rows ( $sql );
		foreach ( $account_data as $k => $v ) {
			$spec_id = $v ['other_id'];
		}
		//$spec_data = $spec_dao->get ( $spec_id );
		 $wherearr [] = "spec_id = '$spec_id'";;
		// prego auth
	} else {
		$spec_name = $forms ['spec_name'];
	}
	
	if (! empty ( $spec_name )) {
		$wherearr [] = "spec_name = '$spec_name'";
	}
	
	// deal with year
	if ($auth == '1') {
		/*
		if ($forms ['year'] != '') {
			foreach ( $year_arr as $kk => $vv ) {
				if ($forms ['year'] == $kk) {
					$year = substr ( $vv, 0, 4 );
				}
			}
		}
		
		foreach ( $month_arr as $kk => $vv ) {
			if ($kk == $forms ['month'] && $forms ['month'] != '') {
				if ($forms ['month'] > 8) {
					$kk = $kk + 1;
					$month = $kk;
				} else {
					$kk = $kk + 1;
					$month = '0' . $kk;
				}
			}
		}
		
		if (! empty ( $year ) && ! empty ( $month )) {
			$date = $year . '-' . $month;
			$wherearr [] = "pay_time like '$date%'";
		}
		*/
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
			$wherearr[] = "pay_time like '$date%'";
		}elseif (! empty ( $year ) ){
			$date = $year . '-' ;
			$wherearr[]  = "pay_time like '$date%'";
		}elseif (! empty ( $month ) ){
			$date = '-'. $month;
			$wherearr[]  = "pay_time like '%$date%'";
		}
	}
	
	// get request data
	$payment_data = $payment_dao->search ( $wherearr, $page );
}

if ($auth == '1') {
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

if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $payment_data ))
	$smarty->assign ( 'payment_data', $payment_data );


if (isset ( $_GET ['flag'] ) && $_GET ['flag'] != ''){
	header ( "Location: ./payment_refer.php?id=".$_GET['promise_spec_id']."&&spec_id=".$_GET['spec_ids']."&&pay_time=".$_GET['pay_time']."&&pay_status=".$_GET['pay_status'] );
	exit ();
}
$smarty->assign ( 'page', $page );
$smarty->assign ( 'auth', $auth );
$smarty->assign ( 'pay_status_arr', $pay_status_arr );

$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'payment_search.html' );
?>