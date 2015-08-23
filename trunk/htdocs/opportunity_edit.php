<?php

require_once ('../system/smarty.inc');
require_once ('../system/Class_ERROR.php');
require_once ('../system/login.inc.php');
require_once ('../system/prego_m.php');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_promise.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_spec_profile.php');
require_once ('../system/mdao/Class_mp_spec_fee.php');
require_once ('../system/mdao/Class_mp_payment.php');
require_once ('../system/mdao/Class_mp_promise_operation_history.php');
require_once ('../system/mdao/Class_mp_corporate_tantou.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/smtpsend.class.php');

session_name ( 'PREGO_ADMIN' );
//session_cache_limiter(private_no_expire);
session_start();

$promise_dao = new Class_mp_promise ();
$smtp_dao = new smtpclass();
$corporate_tantou_dao = new Class_mp_corporate_tantou();
$spec_dao = new Class_mp_specialist;

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	
	$phase = 'input';
	
	if (isset ( $_GET ['id'] ) && ! empty ( $_GET ['id'] )) {
		
		$promise_spec_dao = new Class_mp_promise_spec ();
		$profile_dao = new Class_mp_spec_profile ();
		
		$promise_forms = $promise_dao->get ( $_GET ['id'] );
		$promise_id = $_GET ['id'];
		$sql = "select * from mp_promise_spec where promise_id = '$promise_id'";
		$promise_spec_forms = $promise_spec_dao->get_rows ( $sql );
		//print_r();
		
		// get profile_name arr
		$profile_name_arr = array ();
		foreach ( $promise_spec_forms as $k => $v ) {
			$profile_id = $v ['profile_id'];
			$profile_data = $profile_dao->get ( $profile_id );
			$promise_spec_forms[$k]['profile_name'] = $profile_data ['profile_name'];
			
			if ( empty( $v['doing_time'] ) ) {
				$promise_spec_forms[$k]['day'] = "";
				$promise_spec_forms[$k]['hour'] = "";
				$promise_spec_forms[$k]['minute'] = "";
			} else {
				$nowdatetime = $v["doing_time"];
				$promise_spec_forms[$k]['day'] = substr($nowdatetime,0,10);
				$promise_spec_forms[$k]['hour'] =  substr($nowdatetime,11,2);
				$promise_spec_forms[$k]['minute'] =  substr($nowdatetime,14,2);
			}
			
			//$profile_name_arr [] = $profile_data ['profile_name'];
		}
		//print_r($promise_spec_forms);
		$forms ['id'] = $_GET ['id'];
	}
	
	
} else {
	
	$forms = $_POST;
	if (isset ( $forms ['spec_id'] )) {
		foreach ( $forms ['spec_id'] as $k => $v ) {
			
			$forms ['mutirow'] [] = array (
					"id" => $forms ['pro_id'] [$k],
					"promise_id" => $forms ['promise_id'],
					"spec_name" => $forms ['spec_name'] [$k],
					"spec_id" => $forms ['spec_id'] [$k],
					"profile_name" => $forms ['profile_name'] [$k],
					"profile_id" => $forms ['profile_id'] [$k],
					"service_name" => $forms ['service_name'] [$k],
					"service_id" => $forms ['service_id'] [$k],
					"day" => $forms ['day'] [$k],
					"hour" => $forms ['hour'] [$k],
					"minute" => $forms ['minute'] [$k],
					"before_mail" => $forms ['before_mail'.$k],
					"overtime_have" => $forms ['overtime_have'.$k],
					"overtime_fee" => $forms ['overtime_fee'] [$k],
					"traffic_fee_have" => $forms ['traffic_fee_have'.$k],
					"traffic_fee" => $forms ['traffic_fee'] [$k],
					"traffic_fee_detail" => $forms ['traffic_fee_detail'] [$k],
					"live_fee_have" => $forms ['live_fee_have'.$k],
					"live_fee" => $forms ['live_fee'] [$k],
					"live_fee_detail" => $forms ['live_fee_detail'] [$k],
					"other_fee_have" => $forms ['other_fee_have'.$k],
					"other_fee" => $forms ['other_fee'] [$k],
					"other_fee_name" => $forms ['other_fee_name'] [$k],
					"other_fee_detail" => $forms ['other_fee_detail'] [$k] 
			);
		}
	}
	
	if ($forms ['mode'] == 'input') {
		$err = new Class_ERROR ();
		$promise_chk = $promise_dao->get_checks ();
		/*
		foreach ( $promise_chk as $kcol => $chkval ) {
			$err_mes [$kcol] = $err->check ( $forms [$kcol], $chkval );
		}
		*/
		$operation_history_dao = new Class_mp_promise_operation_history ( $promise_dao->get_db () );
		
		$index = 0;
		$promise_spec_dao = new Class_mp_promise_spec ( $promise_dao->get_db () );
		$promise_spec_chk = $promise_spec_dao->get_checks ();
		$dublipe_flag = false;
		$specidarr = array();
		if (count($forms ['mutirow']) > 0){
		foreach ( $forms ['mutirow'] as $k => $v ) {
			$err_mes ['spec_name'] [$index] = $err->check ( $v ['spec_name'], $promise_spec_chk ['spec_name'] );
			$err_mes ['profile_name'] [$index] = $err->check ( $v ['profile_id'], $promise_spec_chk ['profile_id'] );
			$err_mes ['service_name'] [$index] = $err->check ( $v ['service_name'], $promise_spec_chk ['service_name'] );
			
			if ( in_array($v ['spec_id'],$specidarr)){
				$dublipe_flag = true;
			}
			$specidarr[] =  $v['spec_id'];
			$v['hour'] = str_replace(' ','',$v['hour']);
			$v['minute'] = str_replace(' ','',$v['minute']);
			
			$err_mes ['hour'] [$index] = $err->check ( $v ['hour'], $promise_spec_chk ['hour'] );
			$err_mes ['minute'] [$index] = $err->check ( $v ['minute'], $promise_spec_chk ['minute'] );
			$err_mes ['day'] [$index] = $err->check ( $v ['day'], $promise_spec_chk ['day'] );
			if  ( (!empty( $err_mes ['day'] [$index] ) ) ||(!empty( $err_mes ['minute'] [$index] ) ) ||(!empty( $err_mes ['hour'] [$index] ) ) ) {
				$err_mes ['doing_time'] [$index] = $err->set_time_msg();
			}else {
				
			 if ( !($err->time_check( $v['hour'], $v['minute'], 0)  )) {
			 	$err_mes ['doing_time'] [$index] = $err->set_time_msg();
			 }
			}
			
			$err_mes ['before_mail'] [$index] = $err->check ( $v ['before_mail'], $promise_spec_chk ['before_mail'] );
			$err_mes ['overtime_have'] [$index] = $err->check ( $v ['overtime_have'], $promise_spec_chk ['overtime_have'] );
			$err_mes ['overtime_fee'] [$index] = $err->check ( $v ['overtime_fee'], $promise_spec_chk ['overtime_fee'] );
			$err_mes ['traffic_fee_have'] [$index] = $err->check ( $v ['traffic_fee_have'], $promise_spec_chk ['traffic_fee_have'] );
			$err_mes ['traffic_fee'] [$index] = $err->check ( $v ['traffic_fee'], $promise_spec_chk ['traffic_fee'] );
			$err_mes ['traffic_fee_detail'] [$index] = $err->check ( $v ['traffic_fee_detail'], $promise_spec_chk ['traffic_fee_detail'] );
			$err_mes ['live_fee_have'] [$index] = $err->check ( $v ['live_fee_have'], $promise_spec_chk ['live_fee_have'] );
			$err_mes ['live_fee'] [$index] = $err->check ( $v ['live_fee'], $promise_spec_chk ['live_fee'] );
			$err_mes ['live_fee_detail'] [$index] = $err->check ( $v ['live_fee_detail'], $promise_spec_chk ['live_fee_detail'] );
			$err_mes ['other_fee_have'] [$index] = $err->check ( $v ['other_fee_have'], $promise_spec_chk ['other_fee_have'] );
			$err_mes ['other_fee'] [$index] = $err->check ( $v ['other_fee'], $promise_spec_chk ['other_fee'] );
			$err_mes ['other_fee_name'] [$index] = $err->check ( $v ['other_fee_name'], $promise_spec_chk ['other_fee_name'] );
			$err_mes ['other_fee_detail'] [$index] = $err->check ( $v ['other_fee_detail'], $promise_spec_chk ['other_fee_detail'] );
			$index = $index + 1;
		}
		}else{
			$err_mes ['spec_group'] = $err->format_msg("スペシャリストを追加してください");
		}
		if ($dublipe_flag){
			$err_mes ['spec_group'] = $err->format_msg("スペシャリストは重複しています");
		}
		if ($err->clear) {
			$values = array ();
			$cols = $promise_dao->get_cols ();
			foreach ( $cols as $kcol => $val ) {
				$values [$kcol] = $forms [$kcol];
			}
				
			//桁数チェック
			$maxlens = $promise_dao->get_maxlens();
			foreach ( $maxlens as $k => $v ) {
				$err_mes[$k] =$err->check_size($values[$k], $v);
			}
				
				
			$values_pro_spec = array ();
			$cols = $promise_spec_dao->get_cols ();
			foreach ( $cols as $kcol => $val ) {
				$values_pro_spec [$kcol] = $forms [$kcol];
			}
			//桁数チェック
			$maxlens_pro_spec = $promise_spec_dao->get_maxlens();
			foreach ( $maxlens_pro_spec as $k => $v ) {
				$err_mes[$k] =$err->check_size($values_pro_spec[$k], $v);
			}
		}
		
		 $smarty->assign('promise_forms', $forms);
		 $smarty->assign('promise_spec_forms',$forms['mutirow']);
		 $smarty->assign ( 'phase', $phase );
		 $smarty->assign ( 'before_mail', $promise_spec_before_mail );
		 $smarty->assign ( 'overtime_have', $promise_spec_overtime_have );
		 $smarty->assign ( 'traffic_fee_have', $promise_spec_traffic_fee_have );
		 $smarty->assign ( 'live_fee_have', $promise_spec_live_fee_have );
		 $smarty->assign ( 'other_fee_have', $promise_spec_other_fee_have );
		 
		if ($err->clear) {
			
			$executeflg = TRUE;
			
			// 登録
			if ($forms ['id'] == '') {
				
				$forms ['id'] = $id;
				try {
					$promise_dao->begin_trans ();
					
					if ($promise_id = $promise_dao->add ( $values )) {
						
						$smarty->assign ( 'promise_id', $promise_id );
						
						foreach ( $forms ['mutirow'] as $kk => $vv ) {
							
							$promise_spec_val = array();
							$promise_spec_val ['promise_id'] = $promise_id;
							$promise_spec_val ['spec_name'] = $vv ['spec_name'];
							$promise_spec_val ['spec_id'] = $vv ['spec_id'];
							$promise_spec_val ['profile_id'] = $vv ['profile_id'];
							$promise_spec_val ['service_name'] = $vv ['service_name'];
							$promise_spec_val ['service_id'] = $vv ['service_id'];
							
							if(isset($vv['hour']) && !empty($vv['hour'])){
								$vv['hour'] = str_replace(' ','',$vv['hour']);
								$hour_val = $vv['hour'];
								if(strlen($hour_val) == 1){
									$hour_val = '0'.$hour_val;
								}
							}else{
								$hour_val = '00';
							}
							
							if(isset($vv['minute']) && !empty($vv['minute']) ){
								$vv['minute'] = str_replace(' ','',$vv['minute']);
								$minute_val = $vv['minute'];
								if(strlen($minute_val) == 1){
									$minute_val = '0'.$minute_val;
								}
							}else{
								$minute_val = '00';
							}
							
							
							if(isset($vv['day']) && !empty($vv['day']) ){
								$day_val = $vv['day'];
							}else{
								$day_val = '';
							}
							
							if($day_val == ''){
							}else{
									$promise_spec_val ['doing_time'] = $day_val . ' ' . $hour_val . ':' . $minute_val;
							}
							
							
							if (! empty ( $vv ['before_mail'] )) {
								$promise_spec_val ['before_mail'] = '1';
							} else {
								$promise_spec_val ['before_mail'] = '0';
							}
							
							if (! empty ( $vv ['overtime_have'] )) {
								$promise_spec_val ['overtime_have'] = '1';
							} else {
								$promise_spec_val ['overtime_have'] = '0';
							}
							
							if (isset ( $vv ['overtime_fee'] ) && is_numeric ( $vv ['overtime_fee'] )) {
								$promise_spec_val ['overtime_fee'] = $vv ['overtime_fee'];
							}else{
								$promise_spec_val ['overtime_fee'] = 0;
							}
							
							if (! empty ( $vv ['traffic_fee_have'] )) {
								$promise_spec_val ['traffic_fee_have'] = '1';
							} else {
								$promise_spec_val ['traffic_fee_have'] = '0';
							}
							
							if (isset ( $vv ['traffic_fee'] ) && is_numeric ( $vv ['traffic_fee'] )) {
								$promise_spec_val ['traffic_fee'] = $vv ['traffic_fee'];
							}else{
								$promise_spec_val ['traffic_fee'] = 0;
							}
							
							$promise_spec_val ['traffic_fee_detail'] = $vv ['traffic_fee_detail'];
							
							if (! empty ( $vv ['live_fee_have'] )) {
								$promise_spec_val ['live_fee_have'] = '1';
							} else {
								$promise_spec_val ['live_fee_have'] = '0';
							}
							
							if (isset ( $vv ['live_fee'] ) && is_numeric ( $vv ['live_fee'] )) {
								$promise_spec_val ['live_fee'] = $vv ['live_fee'];
							}else{
								$promise_spec_val ['live_fee'] = 0;
							}
							
							$promise_spec_val ['live_fee_detail'] = $vv ['live_fee_detail'];
							
							if (! empty ( $vv ['other_fee_have'] )) {
								$promise_spec_val ['other_fee_have'] = '1';
							} else {
								$promise_spec_val ['other_fee_have'] = '0';
							}
							
							if (isset ( $vv ['other_fee'] ) && is_numeric ( $vv ['other_fee'] )) {
								$promise_spec_val ['other_fee'] = $vv ['other_fee'];
							}else{
								$promise_spec_val ['other_fee'] = 0;
							}
							
							$promise_spec_val ['other_fee_name'] = $vv ['other_fee_name'];
							$promise_spec_val ['other_fee_detail'] = $vv ['other_fee_detail'];
							$promise_spec_val ['status'] = '0';
							$promise_spec_val ['satisfy_status'] = '00';
							$promise_spec_val ['request_status'] = '0';
							$promise_spec_val ['pay_status'] = '0';
							
							if ($temp_promise_spec_id = $promise_spec_dao->add ( $promise_spec_val )) {
							} else {
								$executeflg = FALSE;
								break;
							}
							
							// operate_history
						$operate_time = date ( 'y-m-d H:i:s', time () );
						$operate_details = "案件登録（クライアント送信済み）";
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
						$operate_history_val ['promise_spec_id'] = $temp_promise_spec_id;
						$operate_history_val ['spec_id'] = $vv['spec_id'];
						$operate_history_val ['service_id'] = $vv['service_id'];
					
						if ($operation_history_dao->add0 ( $operate_history_val )) {
						} else {
							$executeflg = FALSE;
							break;
						}

						}
						
						
					} else {
						$executeflg = FALSE;
					}
					
					if ($executeflg) {
						$promise_dao->commit_trans ();
						// send email to corporate tantou
						
						$mail_promise_data = $promise_dao->get($promise_id);
						$mail_promise_corporate_id = $mail_promise_data['corporate_id'];
						$sql = "select * from mp_corporate_tantou where corporate_id = '$mail_promise_corporate_id' ";
						$mail_corporate_tantou_data = $corporate_tantou_dao->get_rows($sql);
						
						foreach ($mail_corporate_tantou_data as $k => $v) {
							if($v['mail_address'] != ''){
								$smtp_dao->senduserMail($v['mail_address'],PREGO_MAIL_PROMISE_INSERT_SUBJECT,PREGO_MAIL_PROMISE_INSERT_CONTENT.PREGO_LOGIN_URL);
							}
						}
						
						// send email to specialist
						$sql = "select * from mp_promise_spec where promise_id = '$promise_id' ";
						$mail_promise_spec_data = $promise_spec_dao->get_rows($sql);
						foreach ($mail_promise_spec_data as $k => $v) {
							$mail_spec_data = array();
							$mail_sepc_id = $v['spec_id'];
							$mail_spec_data = $spec_dao->get($mail_sepc_id);
							// send email to specialist
							if($mail_spec_data['mail_address1'] != ''){
								$smtp_dao->senduserMail($mail_spec_data['mail_address1'],PREGO_MAIL_PROMISE_INSERT_SUBJECT,PREGO_MAIL_PROMISE_INSERT_CONTENT.PREGO_LOGIN_URL);
							}
							if($mail_spec_data['mail_address2'] != ''){
								$smtp_dao->senduserMail($mail_spec_data['mail_address2'],PREGO_MAIL_PROMISE_INSERT_SUBJECT,PREGO_MAIL_PROMISE_INSERT_CONTENT.PREGO_LOGIN_URL);
							}
						}
						
						
						$smarty->assign('message', '登録が完了しました。通知メール送信完了しました。');
					} else {
						$promise_dao->rollback_trans ();
						$smarty->assign ( 'message', '登録が失敗しました。' );
					}
				} catch ( Exception $e ) {
					$promise_dao->rollback_trans ();
					$smarty->assign ( 'message', 'ＤＢエラーで失敗しました。' );
				}
				
				// 更新
			} else {
				
				$promise_id = $forms ['id'];
				$smarty->assign ( 'promise_id', $promise_id );
				try {
					
					$promise_dao->begin_trans ();
					
					if ($promise_dao->edit ( $forms ['id'], $values )) {
					} else {
						$executeflg = FALSE;
						break;
					}
					
					if ($executeflg) {
						
						$sql = "select * from mp_promise_spec where promise_id = '$promise_id' ";
						
						$dbarray = $promise_spec_dao->get_rows ( $sql );
						
						foreach ( $dbarray as $k => $v ) {
							
							$delflag = true;
							
							$val_spec_name = "";
							$val_spec_id = "";
							$val_profile_id = "";
							$val_service_name = "";
							$val_service_id = "";
							$val_doing_time = "";
							$val_before_mail = "";
							$val_overtime_have = "";
							$val_overtime_fee = "";
							$val_traffic_fee_have = "";
							$val_traffic_fee = "";
							$val_traffic_fee_detail = "";
							$val_live_fee_have = "";
							$val_live_fee = "";
							$val_live_fee_detail = "";
							$val_other_fee_have = "";
							$val_other_fee = "";
							$val_other_fee_name = "";
							$val_other_fee_detail = "";
							
							foreach ( $forms ['mutirow'] as $kk => $vv ) {
								if ($v ['id'] == $vv ['id']) {
									$delflag = false;
									$val_spec_name = $vv ['spec_name'];
									$val_spec_id = $vv ['spec_id'];
									$val_profile_id = $vv ['profile_id'];
									$val_service_name = $vv ['service_name'];
									$val_service_id = $vv ['service_id'];
									
									// TODO
									

									if(isset($vv['hour']) && !empty($vv['hour'])){
										$vv['hour'] = str_replace(' ','',$vv['hour']);
										$hour_val = $vv['hour'];
										if(strlen($hour_val) == 1){
											$hour_val = '0'.$hour_val;
										}
									}else{
										$hour_val = '00';
									}
										
									if(isset($vv['minute']) && !empty($vv['minute'])){
										$vv['minute'] = str_replace(' ','',$vv['minute']);
										$minute_val = $vv['minute'];
										if(strlen($minute_val) == 1){
											$minute_val = '0'.$minute_val;
										}
									}else{
										$minute_val = '00';
									}
									
									if(isset($vv['day']) && !empty($vv['day']) ){
										$day_val = $vv['day'];
									}else{
										$day_val = '';
									}
										
									if($day_val == ''){
									}else{
											$val_doing_time = $day_val . ' ' . $hour_val . ':' . $minute_val;
									}
									
									
									if (! empty ( $vv ['before_mail'] )) {
										$val_before_mail = '1';
									} else {
										$val_before_mail = '0';
									}
// 									$val_before_mail = empty ( $vv ['before_mail' . $kk] ) ? "0" : "1";
// 									$val_overtime_have = empty ( $vv ['overtime_have' . $kk] ) ? "0" : "1";
									if (! empty ( $vv ['overtime_have'] )) {
										$val_overtime_have = '1';
									} else {
										$val_overtime_have = '0';
									}
									if (isset ( $vv ['overtime_fee'] ) && is_numeric ( $vv ['overtime_fee'] )) {
										$val_overtime_fee = $vv ['overtime_fee'];
									}else{
										$val_overtime_fee = 0;
									}
									
// 									$val_traffic_fee_have = empty ( $vv ['traffic_fee_have' . $kk] ) ? "0" : "1";
									if (! empty ( $vv ['traffic_fee_have'] )) {
										$val_traffic_fee_have = '1';
									} else {
										$val_traffic_fee_have = '0';
									}
									
									if (isset ( $vv ['traffic_fee'] ) && is_numeric ( $vv ['traffic_fee'] )) {
										$val_traffic_fee = $vv ['traffic_fee'];
									}else{
										$val_traffic_fee = 0;
									}
									
									$val_traffic_fee_detail = $vv ['traffic_fee_detail'];
// 									$val_live_fee_have = empty ( $vv ['live_fee_have' . $kk] ) ? "0" : "1";
									if (! empty ( $vv ['live_fee_have'] )) {
										$val_live_fee_have = '1';
									} else {
										$val_live_fee_have = '0';
									}
									
									if (isset ( $vv ['live_fee'] ) && is_numeric ( $vv ['live_fee'] )) {
										$val_live_fee = $vv ['live_fee'];
									}else{
										$val_live_fee = 0;
									}
									
									$val_live_fee_detail = $vv ['live_fee_detail'];
// 									$val_other_fee_have = empty ( $vv ['other_fee_have' . $kk] ) ? "0" : "1";
									if (! empty ( $vv ['other_fee_have'] )) {
										$val_other_fee_have = '1';
									} else {
										$val_other_fee_have = '0';
									}
									if (isset ( $vv ['other_fee'] ) && is_numeric ( $vv ['other_fee'] )) {
										$val_other_fee = $vv ['other_fee'];
									}else{
										$val_other_fee = 0;
									}
									$val_other_fee_name = $vv ['other_fee_name'];
									$val_other_fee_detail = $vv ['other_fee_detail'];
								}
							}
							if ($delflag) {
								if ($promise_spec_dao->remove ( $v ['id'] )) {
								} else {
									$executeflg = false;
								}
							} else {
								$values = array ();
								$values ['spec_name'] = $val_spec_name;
								$values ['spec_id'] = $val_spec_id;
								$values ['profile_id'] = $val_profile_id;
								$values ['service_name'] = $val_service_name;
								$values ['service_id'] = $val_service_id;
								$values ['doing_time'] = $val_doing_time;
								$values ['before_mail'] = $val_before_mail;
								$values ['overtime_have'] = $val_overtime_have;
								$values ['overtime_fee'] = $val_overtime_fee;
								$values ['traffic_fee_have'] = $val_traffic_fee_have;
								$values ['traffic_fee'] = $val_traffic_fee;
								$values ['traffic_fee_detail'] = $val_traffic_fee_detail;
								$values ['live_fee_have'] = $val_live_fee_have;
								$values ['live_fee'] = $val_live_fee;
								$values ['live_fee_detail'] = $val_live_fee_detail;
								$values ['other_fee_have'] = $val_other_fee_have;
								$values ['other_fee'] = $val_other_fee;
								$values ['other_fee_name'] = $val_other_fee_name;
								$values ['other_fee_detail'] = $val_other_fee_detail;
								
								if ($promise_spec_dao->edit ( $v ['id'], $values )) {
									// update payment
									$payment_dao = new Class_mp_payment ( $promise_dao->get_db () );
									$promise_spec_id = $v ['id'];
									$sql = "select * from mp_promise where promise_spec_id = $promise_spec_id";
									$payment_data = $payment_dao->get_rows ( $sql );
									foreach ( $payment_data as $kkk => $vvv ) {
										$payment_id = $vvv ['id'];
									}
									$payment_val = array ();
									$payment_val ['promise_spec_id'] = $promise_spec_id;
									$payment_val ['spec_id'] = $val_spec_id;
									$payment_val ['spec_name'] = $val_spec_name;
									$payment_val ['pay_time'] = date ( 'y-m-d H:i:s', time () );
									if ($payment_dao->edit ( $payment_id, $payment_val )) {
									} else {
										$executeflg = false;
									}
								} else {
									$executeflg = false;
								}
							}
						}
						
						foreach ( $forms ['mutirow'] as $k => $v ) {
							$taddflag = true;
							$promise_id = $forms ['id'];
							foreach ( $dbarray as $kk => $vv ) {
								if ($v ['id'] == $vv ['id']) {
									$taddflag = false;
									break;
								}
							}
							if ($taddflag) {
								$values = array ();
								$values ['promise_id'] = $promise_id;
								$values ['spec_name'] = $v ['spec_name'];
								$values ['spec_id'] = $v ['spec_id'];
								$values ['profile_id'] = $v ['profile_id'];
								$values ['service_name'] = $v ['service_name'];
								$values ['service_id'] = $v ['service_id'];
								
								if(isset($v['hour']) && !empty($v['hour'])){
									$v['hour'] = str_replace(' ','',$v['hour']);
									$hour_val = $v['hour'];
									if(strlen($hour_val) == 1){
										$hour_val = '0'.$hour_val;
									}
								}else{
									$hour_val = '00';
								}
									
								if(isset($v['minute']) && !empty($v['minute'])){
									$v['minute'] = str_replace(' ','',$v['minute']);
									$minute_val = $v['minute'];
									if(strlen($minute_val) == 1){
										$minute_val = '0'.$minute_val;
									}
								}else{
									$minute_val = '00';
								}
								
								if(isset($v['day']) && !empty($v['day']) ){
									$day_val = $v['day'];
								}else{
									$day_val = '';
								}
								
								if($day_val == ''){
								}else{
										$values ['doing_time'] = $day_val . ' ' . $hour_val . ':' . $minute_val;
								}
								
								if (! empty ( $v ['before_mail'] )) {
									$values ['before_mail'] = '1';
								} else {
									$values ['before_mail']= '0';
								}
								$values ['overtime_have'] = empty ( $v ['overtime_have' . $kk] ) ? "0" : "1";
								if (isset ( $v ['overtime_fee'] ) && is_numeric ( $v ['overtime_fee'] )) {
									$values ['overtime_fee'] = $v ['overtime_fee'];
								}else{
									$values ['overtime_fee'] = 0;
								}
								$values ['traffic_fee_have'] = empty ( $v ['traffic_fee_have' . $kk] ) ? "0" : "1";
								if (isset ( $v ['traffic_fee'] ) && is_numeric ( $v ['traffic_fee'] )) {
									$values ['traffic_fee'] = $v ['traffic_fee'];
								}else{
									$values ['traffic_fee'] = 0;
								}
								$values ['traffic_fee_detail'] = $v ['traffic_fee_detail'];
								$values ['live_fee_have'] = empty ( $v ['live_fee_have' . $kk] ) ? "0" : "1";
								if (isset ( $v ['live_fee'] ) && is_numeric ( $v ['live_fee'] )) {
									$values ['live_fee'] = $v ['live_fee'];
								}else{
									$values ['live_fee'] = 0;
								}
								$values ['live_fee_detail'] = $v ['live_fee_detail'];
								$values ['other_fee_have'] = empty ( $v ['other_fee_have' . $kk] ) ? "0" : "1";
								if (isset ( $v ['other_fee'] ) && is_numeric ( $v ['other_fee'] )) {
									$values ['other_fee'] = $v ['other_fee'];
								}else{
									$values ['other_fee'] = 0;
								}
								$values ['other_fee_name'] = $v ['other_fee_name'];
								$values ['other_fee_detail'] = $v ['other_fee_detail'];
								$values ['status'] = '0';
								$values ['satisfy_status'] = '00';
								$values ['request_status'] = '0';
								$values ['pay_status'] = '0';
								
								if ($temp_promise_spec_id = $promise_spec_dao->add ( $values )) {
								} else {
									$executeflg = FALSE;
								}
								
			
							// operate_history
							$operate_time = date ( 'y-m-d H:i:s', time () );
							$operate_details = "案件登録（クライアント送信済み）";
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
							$operate_history_val ['promise_spec_id'] = $temp_promise_spec_id;
							$operate_history_val ['spec_id'] = $values['spec_id'];
							$operate_history_val ['service_id'] = $values['service_id'];
				
						if ($operation_history_dao->add0 ( $operate_history_val )) {
						} else {
							$executeflg = FALSE;
							break;
						}

							}
						}
					}
					
					if ($executeflg) {
						$promise_dao->commit_trans ();
						$smarty->assign ( 'message', '更新が完了しました。' );
					} else {
						$promise_dao->rollback_trans ();
						$smarty->assign ( 'message', '更新が失敗しました。' );
					}
				} catch ( Exception $e ) {
					$promise_dao->rollback_trans ();
					$smarty->assign ( 'message', 'ＤＢエラーで失敗しました。' );
				}
				$id = $forms ['id'];
			}
			$phase = 'complete';
		} else {
			$phase = 'input';
		}
	}
}

$select = array (
		"選択してください" 
);
$overtime = array_merge ( $select, $overtime_arr );



$temp = array ();
$smarty->assign ( 'temp', $temp );

if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $forms ['mutirow'] ))
	$smarty->assign ( 'promise_spec_forms', $forms ['mutirow'] );
if (isset ( $err_mes ))
	$smarty->assign ( 'err', $err_mes );

if (isset ( $promise_forms ))
	$smarty->assign ( 'promise_forms', $promise_forms );
if (isset ( $promise_spec_forms ))
	$smarty->assign ( 'promise_spec_forms', $promise_spec_forms );
$smarty->assign ( 'prego_minute', $prego_minute );
$smarty->assign ( 'prego_hour', $prego_hour );
$smarty->assign ( 'overtime', $overtime );
$smarty->assign ( 'phase', $phase );
$smarty->assign ( 'before_mail', $promise_spec_before_mail );
$smarty->assign ( 'overtime_have', $promise_spec_overtime_have );
$smarty->assign ( 'traffic_fee_have', $promise_spec_traffic_fee_have );
$smarty->assign ( 'live_fee_have', $promise_spec_live_fee_have );
$smarty->assign ( 'other_fee_have', $promise_spec_other_fee_have );
$smarty->assign ( 'auth', $auth );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'opportunity_edit.html' );
?>