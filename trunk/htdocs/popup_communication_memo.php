<?php
require_once ('../system/smarty.inc');
require_once ('../system/prego_m.php');
require_once ('../system/login.inc.php');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_promise_operation_history.php');
require_once ('../system/mdao/Class_mp_promise.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/mdao/Class_mp_payment.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/mdao/Class_mp_corporate_tantou.php');
require_once ('../system/mdao/Class_mp_spec_traffic_fee.php');
require_once ('../system/smtpsend.class.php');

$promise_dao = new Class_mp_promise ();
$promise_spec_dao = new Class_mp_promise_spec ();
$operation_history_dao = new Class_mp_promise_operation_history ( $promise_spec_dao->get_db () );
$spec_dao = new Class_mp_specialist ();
$payment_dao = new Class_mp_payment ();
$account_dao = new Class_mp_account ();
$corporate_tantou_dao = new Class_mp_corporate_tantou;
$spec_traffic_dao = new Class_mp_spec_traffic_fee ();
$smtp_dao = new smtpclass();

if (isset ( $_GET ['id'] ) && ! empty ( $_GET ['id'] )) {
	
	if (isset ( $_GET ['spec_id'] ) && $_GET ['spec_id'] != '') {
		// get spec_id
		$tra_spec_id = $_GET ['spec_id'];
		// get spec_traffic data
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
	
	$executeflg = true;
	$values = array ();

	
	
	$status = $_GET ['status'];
	$promise_id = $_GET ['promise_id'];
	$id =  $_GET['id'];
	$promise_spec_id = $_GET['promise_spec_id'];
	$operation_spec_id = $_GET['spec_id'];
	$operation_service_id = $_GET['service_id'];
	
	if ($_GET ['status'] == '2') {
		$values ['status'] = '3';
	}
	
	try {
		

		$pro_spec_data = $promise_spec_dao->get( $id);
		if ( ($pro_spec_data['doing_time']) && ($pro_spec_data['doing_time'] > "2000-01-01") ) {
			$shortime =  strtotime($pro_spec_data['doing_time']);
		}else {
			$shortime =  time();
			$values ['doing_time'] =  date ( 'y-m-d H:i:s', time () );
		}
		$promise_spec_dao->begin_trans ();
		
		if ($promise_spec_dao->edit ( $id, $values )) {
			
			$operate_time = date ( 'y-m-d H:i:s', time () );
			$operate_details = "業務完了";
			$user_name = $_SESSION ['PREGO_ADMIN'] ['STAFF_NAME'];
			foreach ( $prego_account_sorts as $k => $v ) {
				if ($auth == $k) {
					$operate_man = $user_name . "(" . $v . ")";
				}
			}
			

			
			$operate_history_val ['operate_time'] = $operate_time;
			$operate_history_val ['operate_details'] = $operate_details;
			$operate_history_val ['operate_man'] = $operate_man;
			$operate_history_val ['promise_id'] = $promise_id;
			
			$operate_history_val ['promise_spec_id'] = $id;
			$operate_history_val ['spec_id'] = $operation_spec_id;
			$operate_history_val ['service_id'] = $operation_service_id;

			if ($operation_history_dao->add0 ( $operate_history_val )) {
			} else {
				//$executeflg = FALSE;
				//break;
			}

			if($auth == '3'){
				// add payment data
				$login_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_ID'];
				$sql = "select * from mp_account where login_id = '$login_id' ";
				$account_data = $account_dao->get_rows ( $sql );
				foreach ( $account_data as $k => $v ) {
					$other_id = $v ['other_id'];
				}
				// get spec_id and spec_name from mp_specialist by other_id
				$spec_data = $spec_dao->get ( $other_id );
				// set pay values
				$spec_id = $spec_data ['id'];
				$spec_name = $spec_data ['spec_name'];
			}elseif ($auth == '1'){
				
				$spec_id = $_GET['spec_id'];
				$spec_data = $spec_dao->get($spec_id);
				$spec_name = $spec_data['spec_name'];
				
			}
			//$pay_time = date ( 'Y-m', time () + 3600 * 24 * 30 );

			$pay_time = date ( 'Y-m', strtotime("1 month", $shortime) );
			$pay_values ['promise_spec_id'] = $id;
			$pay_values ['spec_id'] = $spec_id;
			$pay_values ['spec_name'] = $spec_name;
			$pay_values ['pay_time'] = $pay_time ;
			$pay_values ['pay_status'] = '0';
			$pay_values ['post_code'] = $spec_data["post_code"];
			$pay_values ['address']   = $spec_data["address"];
			$pay_values ['tel']       = $spec_data["tel"];
			$pay_values ['person_choose'] = $spec_data["person_choose"];
			if ($spec_data["person_choose"] =="1"){
				$pay_values ['rate'] = PREGO_ZAITYOSYO_RATE ;
			}else {
				$pay_values ['rate'] = PREGO_ZAIKIN_RATE ;
			}
			
			$where = "spec_id = '$spec_id' and pay_time = '$pay_time'";
			if ($payment_dao->exits ( $where )) {
				$payment_dao-> editbywhere($where, $pay_values);
				
			} else {
				// add data to payment
				if ($payment_dao->add0 ( $pay_values )) {
				} else {
					$executeflg = FALSE;
				}
			}
		} else {
			$executeflg = FALSE;
		}
		
		if ($executeflg) {
			$promise_spec_dao->commit_trans ();
			echo '100';//成功;
			//$smtp_dao->senduserMail(PREGO_MAIL_ADDRESS,PREGO_MAIL_COMMUNICATION_MEMO_SUBJECT,PREGO_MAIL_COMMUNICATION_MEMO_CONTENT);
			
			// send Email to specialist
			$mail_promise_spec_data = $promise_spec_dao->get($id);
			$mail_spec_id = $mail_promise_spec_data['spec_id'];
			$mail_spec_data = $spec_dao->get($mail_spec_id);
			if($mail_spec_data['mail_address1'] != ''){
				$smtp_dao->senduserMail($mail_spec_data['mail_address1'],PREGO_MAIL_COMMUNICATION_MEMO_SUBJECT,PREGO_MAIL_COMMUNICATION_MEMO_SPECIALIST_CONTENT);
			}
			if($mail_spec_data['mail_address2'] != ''){
				$smtp_dao->senduserMail($mail_spec_data['mail_address2'],PREGO_MAIL_COMMUNICATION_MEMO_SUBJECT,PREGO_MAIL_COMMUNICATION_MEMO_SPECIALIST_CONTENT);
			}
			
			// send Email to corporate
			$mail_promise_data = $promise_dao->get($promise_id);
			$mail_corporate_id = $mail_promise_data['corporate_id'];
			$sql ="select * from mp_corporate_tantou where corporate_id = '$mail_corporate_id' ";
			$mail_corporate_tantou_data = $corporate_tantou_dao->get_rows($sql);
			foreach ($mail_corporate_tantou_data as $k => $v) {
				if($v['mail_address'] != ''){
					$smtp_dao->senduserMail($v['mail_address'],PREGO_MAIL_COMMUNICATION_MEMO_SUBJECT,PREGO_MAIL_COMMUNICATION_MEMO_CORPORATE_CONTENT."\n".PREGO_LOGIN_URL);
				}
			}
			
		} else {
			$promise_spec_dao->rollback_trans ();
			echo '0';
		}
	} catch ( Exception $e ) {
		$promise_spec_dao->rollback_trans ();
		echo '0';
	}
}
/*
if(isset($promise_spec_data)) $smarty->assign('promise_spec_data', $promise_spec_data); 
$smarty->assign ( 'overtime_have', $promise_spec_overtime_have );
$smarty->assign ( 'traffic_fee_have', $promise_spec_traffic_fee_have );
$smarty->assign ( 'traffic_name', $traffic_name );
$smarty->assign ( 'traffic_fee', $traffic_fee );
$smarty->assign ( 'traffic_memo', $traffic_memo );

$smarty->assign ( 'live_fee_have', $promise_spec_live_fee_have );
$smarty->assign ( 'other_fee_have', $promise_spec_other_fee_have );

$smarty->display ( 'popup_communication_memo.html' );
*/
?>