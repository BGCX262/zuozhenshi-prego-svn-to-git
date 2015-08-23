<?php
require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');

require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_promise.php');
require_once ('../system/mdao/Class_mp_corporate_tantou.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/prego_m.php');
require_once ('../system/smtpsend.class.php');

$promise_spec_dao = new Class_mp_promise_spec;
$promise_dao = new Class_mp_promise;
$corporate_tantou_dao = new Class_mp_corporate_tantou;
$specialist_dao = new Class_mp_specialist;
$smtpsend_dao = new smtpclass;


// get system date
// change to seconds
$now_date = strtotime(date ( 'Y-m-d H:i:s', time () ));

//********************発注確定の警告メール　２日後、３日後*********************

$sql = "select * from mp_promise_spec where status = '0' ";
$promise_spec_data = $promise_spec_dao->get_rows($sql);
foreach ($promise_spec_data as $k => $v) {
	// create date
	// change to seconds
	$create_date = strtotime($v['c_time']);
	// get Difference between system date and create date
	$difference = $now_date - $create_date ;
	
	// get corporate_id
	$promise_data = $promise_dao->get($v['promise_id']);
	$corporate_id = $promise_data['corporate_id'];
	// get corporate_tantou Email
	$sql = "select * from mp_corporate_tantou where corporate_id = '$corporate_id' ";
	$corporate_tantou_data = $corporate_tantou_dao->get_rows($sql);
	
	// 2 ~ 3 日
	if($difference >= 172800 && $difference <= 259200){
		// send 2日 Email
		foreach ($corporate_tantou_data as $kk => $vv) {
			if(!empty($vv['mail_address'])){
				$smtpsend_dao->senduserMail($vv['mail_address'],TWO_OR_THREE_DAYS_WARNING_EMAIL_SUBJECT,TWO_OR_THREE_DAYS_WARNING_EMAIL_CONTENT."\n".PREGO_LOGIN_URL);
			}
		}
	}elseif ($difference > 259200 && $difference < 346000 ){
		// send 3日 Email
		foreach ($corporate_tantou_data as $kk => $vv) {
			if(!empty($vv['mail_address'])){
				$smtpsend_dao->senduserMail($vv['mail_address'],TWO_OR_THREE_DAYS_WARNING_EMAIL_SUBJECT,TWO_OR_THREE_DAYS_WARNING_EMAIL_CONTENT."\n".PREGO_LOGIN_URL);
			}
		}
	}
}

//*********************受注確定の警告メール、１２時間後、２３時間後********************

$sql = "select * from mp_promise_spec where status = '1' ";
$promise_spec_data = $promise_spec_dao->get_rows($sql);
foreach ($promise_spec_data as $k => $v) {
	
	$u_date = strtotime($v['u_time']);
	
	$difference = $now_date - $u_date ;
	
	$spec_id = $v['spec_id'];
	
	$spec_data = $specialist_dao->get($spec_id);
	
	if($difference >= 43200 && $difference <= 82800){
		// １２時間後 EMAIL
		if(!empty($spec_data['mail_address1'])){
			$smtpsend_dao->senduserMail($spec_data['mail_address1'],ORDER_CONFIRM_EMAIL_SUBJECT,ORDER_CONFIRM_EMAIL_CONTENT."\n".PREGO_LOGIN_URL);
		}
		if(!empty($spec_data['mail_address2'])){
			$smtpsend_dao->senduserMail($spec_data['mail_address2'],ORDER_CONFIRM_EMAIL_SUBJECT,ORDER_CONFIRM_EMAIL_CONTENT."\n".PREGO_LOGIN_URL);
		}
	}elseif ($difference > 82800 &&  $difference < 172800 ){
		// ２３時間後 EMAIL
		if(!empty($spec_data['mail_address1'])){
			$smtpsend_dao->senduserMail($spec_data['mail_address1'],ORDER_CONFIRM_EMAIL_SUBJECT,ORDER_CONFIRM_EMAIL_CONTENT."\n".PREGO_LOGIN_URL);
		}
		if(!empty($spec_data['mail_address2'])){
			$smtpsend_dao->senduserMail($spec_data['mail_address2'],ORDER_CONFIRM_EMAIL_SUBJECT,ORDER_CONFIRM_EMAIL_CONTENT."\n".PREGO_LOGIN_URL);
		}
	}
	
}

?>