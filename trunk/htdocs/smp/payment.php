<?php
$smp_floder_flag = true;
require_once ('../../system/smarty.inc');
require_once ('../../system/prego_m.php');

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {

		$id = $_GET ['id'];
	}
}

//$m_year[""]  = "選択してください";
	foreach ($year_arr as $k => $v) {
		$m_year[$k] = $v;
	}

	//$m_month[""]  = "選択してください";
	foreach ($month_arr as $k => $v) {
		$m_month[$k] = $v."&nbsp;&nbsp;";
	}
$nowYEAR = date('Y');
$nowMonth =  date('m') * 1 -1;

$smarty->assign ( 'year', $m_year );
$smarty->assign ( 'month', $m_month );
$smarty->assign ( 'id', $id );
$smarty->assign ( 'nowYEAR', $nowYEAR );
$smarty->assign ( 'nowMonth', $nowMonth );
$smarty->display ( 'smp/payment.html' );
?>