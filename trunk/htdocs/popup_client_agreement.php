<?php
require_once ('../system/smarty.inc');
require_once ('../system/prego_m.php');
require_once ('../system/login.inc.php');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_promise_operation_history.php');
require_once ('../system/mdao/Class_mp_promise.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/mdao/Class_mp_corporate.php');
require_once ('../system/mdao/Class_mp_corporate_tantou.php');
require_once ('../system/mdao/Class_mp_request.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/smtpsend.class.php');

$promise_dao = new Class_mp_promise ();
$promise_spec_dao = new Class_mp_promise_spec ();
$operation_history_dao = new Class_mp_promise_operation_history ( $promise_spec_dao->get_db () );
$account_dao = new Class_mp_account ( $promise_spec_dao->get_db () );
$corporate_dao = new Class_mp_corporate ( $promise_spec_dao->get_db () );
$corporate_tantou_dao = new Class_mp_corporate_tantou;
$request_dao = new Class_mp_request ( $promise_spec_dao->get_db () );
$specialist_dao = new Class_mp_specialist ();
$smtp_dao = new smtpclass();

if (isset ( $_GET ['id'] ) && ! empty ( $_GET ['id'] )) {
	
	$executeflg = true;
	// promise_spec values array
	$values = array ();
	$id = $_GET ['id'];
	// promise_spec_status
	$status = $_GET ['status'];
	// promise_id
	$promise_id = $_GET ['promise_id'];
	
	$promise_spec_id = $_GET['promise_spec_id'];
	$spec_id = $_GET['spec_id'];
	$service_id = $_GET['service_id'];
	
	// update status
	if ($_GET ['status'] == '0') {
		$values ['status'] = '1';
	}
	
	try {
		$pro_spec_data = $promise_spec_dao->get( $id);
		if ( ($pro_spec_data['doing_time']) && ($pro_spec_data['doing_time'] > "2000-01-01") ) {
			$shortime =  strtotime($pro_spec_data['doing_time']);
		}else {
			$shortime =  time();
			$values ['doing_time'] =  date ( 'y-m-d H:i:s', time () );
		}
		// begin trans
		$promise_spec_dao->begin_trans ();
		// update promise_spec success
		if ($promise_spec_dao->edit ( $id, $values )) {
			
			// set operate values
			$operate_time = date ( 'y-m-d H:i:s', time () ); 
			
			$operate_details = "発注確定（約定送信済み）";
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
			$operate_history_val ['spec_id'] = $spec_id;
			$operate_history_val ['service_id'] = $service_id;
			
			// add data to operation_history
			if ($operation_history_dao->add0 ( $operate_history_val )) {
			} else {
				$executeflg = FALSE;
			}
			
			if($auth == '2'){
				// add request data
				// get other_id from mp_account by current login_id
				$login_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_ID'];
				$sql = "select * from mp_account where login_id = '$login_id' ";
				$account_data = $account_dao->get_rows ( $sql );
				foreach ( $account_data as $k => $v ) {
					$other_id = $v ['other_id'];
				}
				// get corporate_id and corporate_name from mp_corporate by other_id
				$sql = "select * from mp_corporate where id = '$other_id' ";
				$corporate_data = $corporate_dao->get_rows ( $sql );
				foreach ( $corporate_data as $k => $v ) {
					$corporate_name = $v ['corporate_name'];
					$corporate_id = $v ['id'];
				}
			}elseif($auth == '1'){
				
				$promise_data = $promise_dao->get($promise_id);
				$corporate_id = $promise_data['corporate_id'];
				$corporate_name = $promise_data['corporate_name'];
			}
			
			
			// set request values
			$request_values ['promise_id'] = $promise_id;
			$request_values ['corporate_id'] = $corporate_id;
			$request_values ['corporate_name'] = $corporate_name;
			
			
			//$request_values ['request_time'] = date ( 'Y-m', time()+3600*24*30  );
			$pay_time = date ( 'Y-m', strtotime("1 month", $shortime) );
			$request_values ['request_time'] = $pay_time;
			$request_values ['request_status'] = '0';
			
			$request_values ['rate']  = PREGO_ZAIKIN_RATE;
			$request_time = $request_values ['request_time'];
			$where = "corporate_id = '$corporate_id' and request_time = '$request_time'";			
			
			if($request_dao->exits($where)){
				$payment_dao-> editbywhere($where, $pay_values);
			}else{
				// add data to request
				if ($request_dao->add0 ( $request_values )) {
				} else {
					$executeflg = FALSE;
				}
			}
			
		} else {
			$executeflg = FALSE;
			break;
		}
		
		if ($executeflg) {
			$promise_spec_dao->commit_trans ();
			echo '100';//成功
			// send Email to PREGO
			//$smtp_dao->senduserMail(PREGO_MAIL_ADDRESS,PREGO_MAIL_CORPORATE_AGREEMENT_SUBJECT,PREGO_MAIL_CORPORATE_AGREEMENT_CONTENT);
			
			// send Email to Specialist
			$promise_spec_mail_data = $promise_spec_dao->get($id);
			$mail_spec_id = $promise_spec_mail_data['spec_id'];
			$mail_spec_data = $specialist_dao->get($mail_spec_id);
			$mail_address1 = $mail_spec_data['mail_address1'];
			$mail_address2 = $mail_spec_data['mail_address2'];
			if(!empty($mail_address1)){
				$smtp_dao->senduserMail($mail_address1,PREGO_MAIL_CORPORATE_AGREEMENT_SUBJECT,PREGO_MAIL_CORPORATE_AGREEMENT_SPECIALIST_CONTENT."\n".PREGO_LOGIN_URL);
			}
			if(!empty($mail_address2)){
				$smtp_dao->senduserMail($mail_address2,PREGO_MAIL_CORPORATE_AGREEMENT_SUBJECT,PREGO_MAIL_CORPORATE_AGREEMENT_SPECIALIST_CONTENT."\n".PREGO_LOGIN_URL);
			}
			
			// send Email to corporate tantou
			$mail_promise_data = $promise_dao->get($promise_id);
			$mail_corporate_id = $mail_promise_data['corporate_id'];
			$sql ="select * from mp_corporate_tantou where corporate_id = '$mail_corporate_id' ";
			$mail_corporate_tantou_data = $corporate_tantou_dao->get_rows($sql);
			foreach ($mail_corporate_tantou_data as $k => $v) {
				if($v['mail_address'] != ''){
					$smtp_dao->senduserMail($v['mail_address'],PREGO_MAIL_CORPORATE_AGREEMENT_SUBJECT,PREGO_MAIL_CORPORATE_AGREEMENT_CORPORATE_CONTENT_A."\n".$v['tantou_name'].PREGO_MAIL_CORPORATE_AGREEMENT_CORPORATE_CONTENT_B."\n".PREGO_LOGIN_URL);
				}
			}
		} else {
			$promise_spec_dao->rollback_trans ();
			echo '0';//
		}
	} catch ( Exception $e ) {
		$promise_spec_dao->rollback_trans ();
		echo '0';
	}
}

//$smarty->display ( 'popup_client_agreement.html' );
?>