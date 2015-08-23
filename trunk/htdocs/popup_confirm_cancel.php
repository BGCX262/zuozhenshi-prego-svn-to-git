<?php
require_once ('../system/smarty.inc');
require_once ('../system/prego_m.php');
require_once ('../system/login.inc.php');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_promise.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_promise_operation_history.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/mdao/Class_mp_corporate_tantou.php');
require_once ('../system/smtpsend.class.php');

$promise_dao = new Class_mp_promise ();
$promise_spec_dao = new Class_mp_promise_spec ();
$operation_history_dao = new Class_mp_promise_operation_history ( $promise_spec_dao->get_db () );
$spec_dao = new Class_mp_specialist ();
$corporate_tantou_dao = new Class_mp_corporate_tantou;
$smtp_dao = new smtpclass();

if (isset ( $_GET ['id'] ) && ! empty ( $_GET ['id'] )) {
	
	// set flag
	$executeflg = true;
	// set update values
	$values = array ();
	// get id
	$id = $_GET ['id'];
	// get current status
	$status = $_GET ['status'];
	// get relational promise_id
	$promise_id = $_GET ['promise_id'];
	
	$promise_spec_id = $_GET['promise_spec_id'];
	$spec_id = $_GET['spec_id'];
	$service_id = $_GET['service_id'];
	
	
	// set update values
	$values ['status'] = '5';
	
	try {
		// begin trans
		$promise_spec_dao->begin_trans ();
		// update data
		if ($promise_spec_dao->edit ( $id, $values )) {
			// set operate values
			$operate_time = date ( 'y-m-d H:i:s', time () );
			$operate_details = "実施しなかった";
			$user_name = $_SESSION ['PREGO_ADMIN'] ['STAFF_NAME'];
			// deal with operate_man
			foreach ( $prego_account_sorts as $k => $v ) {
				if ($auth == $k) {
					$operate_man = $user_name . "(" . $v . ")";
				}
			}
			// set operate values
			$operate_history_val ['operate_time'] = $operate_time;
			$operate_history_val ['operate_details'] = $operate_details;
			$operate_history_val ['operate_man'] = $operate_man;
			$operate_history_val ['promise_id'] = $promise_id;
			
			$operate_history_val ['promise_spec_id'] = $id;
			$operate_history_val ['spec_id'] = $spec_id;
			$operate_history_val ['service_id'] = $service_id;
			
			// update operation_history data
			if ($operation_history_dao->add0 ( $operate_history_val )) {
			} else {
				$executeflg = FALSE;
				break;
			}
		}else{
			$executeflg = FALSE;
		}
		if ($executeflg) {
			$promise_spec_dao->commit_trans ();
			echo '100';//成功
			// send Email to PREGO
			$smtp_dao->senduserMail ( PREGO_JP_MAIL, PREGO_MAIL_CONFIRM_CANCEL_SUBJECT,PREGO_MAIL_CONFIRM_CANCEL_CONTENT );
				
			// send Email to specialist
			$mail_promise_spec_data = $promise_spec_dao->get ( $id );
			$mail_spec_id = $mail_promise_spec_data ['spec_id'];
			$mail_spec_data = $spec_dao->get ( $mail_spec_id );
			if ($mail_spec_data ['mail_address1'] != '') {
				$smtp_dao->senduserMail ( $mail_spec_data ['mail_address1'], PREGO_MAIL_CONFIRM_CANCEL_SUBJECT,PREGO_MAIL_CONFIRM_CANCEL_CONTENT );
			}
			if ($mail_spec_data ['mail_address2'] != '') {
				$smtp_dao->senduserMail ( $mail_spec_data ['mail_address2'], PREGO_MAIL_CONFIRM_CANCEL_SUBJECT,PREGO_MAIL_CONFIRM_CANCEL_CONTENT );
			}
				
			// send Email to corporate
			$mail_promise_data = $promise_dao->get ( $promise_id );
			$mail_corporate_id = $mail_promise_data ['corporate_id'];
			$sql = "select * from mp_corporate_tantou where corporate_id = '$mail_corporate_id' ";
			$mail_corporate_tantou_data = $corporate_tantou_dao->get_rows ( $sql );
			foreach ( $mail_corporate_tantou_data as $k => $v ) {
				if ($v ['mail_address'] != '') {
					$smtp_dao->senduserMail ( $v ['mail_address'], PREGO_MAIL_CONFIRM_CANCEL_SUBJECT,PREGO_MAIL_CONFIRM_CANCEL_CONTENT );
				}
			}
		} else {
			$promise_spec_dao->rollback_trans ();
			echo '0';//失敗
		}
	} catch (Exception $e) {
		$promise_spec_dao->rollback_trans ();
		echo '0';//失敗
	}
}

//$smarty->display('popup_confirm_cancel.html');
?>