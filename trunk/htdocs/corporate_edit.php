<?php
require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');
require_once ('../system/Class_MAIL.php');
require_once ('../system/mdao/Class_mp_corporate.php');
require_once ('../system/mdao/Class_mp_corporate_tantou.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/mdao/Class_mp_promise.php');
require_once ('../system/mdao/Class_mp_request.php');
require_once ('../system/smtpsend.class.php');

require_once ('../system/prego_m.php');
require_once ('../system/Class_ERROR.php');
require_once ('../system/login.inc.php');
$corporate_dao = new Class_mp_corporate ();
$smtp_dao = new smtpclass();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	
	$phase = 'input';
	
	if (isset ( $_GET ['account_id'] ) && ! empty ( $_GET ['account_id'] )) {
		$account_id = $_GET ['account_id'];
		$smarty->assign ( 'account_id', $account_id );
	} else {
		$tantou_dao = new Class_mp_corporate_tantou ();
		
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			
			$corporate_forms = $corporate_dao->get ( $_GET ['id'] );
			
			$sql = sprintf ( "select * from mp_corporate_tantou where corporate_id = '%s'", mysql_real_escape_string ( $_GET ['id'] ) );
			$tantou_forms = $tantou_dao->get_rows ( $sql );
			$forms ["id"] = $_GET ['id'];
			
			// deal with post_code
			$post_code = split('-',$corporate_forms['post_code']);
			$region = $post_code[0];
			$branch = $post_code[1];
			
			// deal with tel
			$tel = split('-',$corporate_forms['tel']);
			$area_code = $tel[0];
			$office_number = $tel[1];
			$called_number = $tel[2];
			
			// deal with memo
			$order = array("<br/>");
			$replace = "\n";
			$corporate_forms['memo'] = str_replace($order,$replace,$corporate_forms['memo']);
			
		}else{
			// corporate_auth , get other_id
			$account_dao = new Class_mp_account;
			$id = $_SESSION ['PREGO_ADMIN'] ['STAFF_SEQ'];
			$account_data = $account_dao->get($id);
			$other_id = $account_data['other_id'];
			
			if($other_id != '0'){
				// get corporate data
				$corporate_forms = $corporate_dao->get ( $other_id );
				// get tantou data
				$sql = sprintf ( "select * from mp_corporate_tantou where corporate_id = '%s'", mysql_real_escape_string ( $other_id ) );
				$tantou_forms = $tantou_dao->get_rows ( $sql );
				$forms ["id"] = $other_id;
				
				// deal with post_code
				$post_code = split('-',$corporate_forms ['post_code']);
				$region = $post_code[0];
				$branch = $post_code[1];
				
				// deal with tel
				$tel = split('-',$corporate_forms['tel']);
				$area_code = $tel[0];
				$office_number = $tel[1];
				$called_number = $tel[2];
				
				// deal with memo
				$order = array("<br/>");
				$replace = "\n";
				$corporate_forms['memo'] = str_replace($order,$replace,$corporate_forms['memo']);
			}
		}
		$smarty->assign ( 'region', $region );
		$smarty->assign ( 'branch', $branch );
		$smarty->assign ( 'area_code', $area_code );
		$smarty->assign ( 'office_number', $office_number );
		$smarty->assign ( 'called_number', $called_number );
		if (isset ( $corporate_forms ))
			$smarty->assign ( 'corporate_forms', $corporate_forms );
		if (isset ( $tantou_forms ))
			$smarty->assign ( 'tantou_forms', $tantou_forms );
	}
} else {
	
	if ($_POST['insertforms']) {
		$forms = $_SESSION['insertforms'];
	}else {
		$forms = $_POST;
	}
	$account_id = $forms ['account_id'];
	$account_dao = new Class_mp_account ( $corporate_dao->get_db () );
	
	$forms ['mutirow'] = array ();
	// get tantou_id array
	if (! empty ( $forms ['tantou_id'] )) {
		
		foreach ( $forms ['tantou_id'] as $k => $v ) {
			
			if($forms ['tantou_name'] [$k] != '' && $forms ['mail_address'] [$k] != ''){
				$forms ['mutirow'] [] = array (
						"id" => $v,
						"tantou_name" => $forms ['tantou_name'] [$k],
						"mail_address" => $forms ['mail_address'] [$k]
				);
			}
		}
	}
	
	if ($forms ['mode'] == 'input') {
		
		// check corporate items
		$err = new Class_ERROR ();
		$corporate_chk = $corporate_dao->get_checks ();
		foreach ( $corporate_chk as $kcol => $chkval ) {
			$err_mes [$kcol] = $err->check ( $forms [$kcol], $chkval );
		}
		
		//郵便番号判定
		$err_mes ['post_code'] = $err->zipcode_check($forms['region'].'-'.$forms['branch']);
		//電話番号判定
		$err_mes ['tel'] = $err->tel_check($forms['area_code'].'-'.$forms['office_number'].'-'.$forms['called_number']);
		
		
		$index = 0;
		$tantou_dao = new Class_mp_corporate_tantou ( $corporate_dao->get_db () );
		// get tantou checked items
		$tantou_chk = $tantou_dao->get_checks ();
		// check each tantou item
		foreach ( $forms ['mutirow'] as $k => $v ) {

			if($v ['tantou_name'] != '' && $v ['mail_address'] !=''){
				$err_mes ['tantou_name'] [$index] = $err->check ( $v ['tantou_name'], $tantou_chk ['tantou_name'] );
				$err_mes ['mail_address'] [$index] = $err->check ( $v ['mail_address'], $tantou_chk ['mail_address'] );
				$index = $index + 1;
			}
		}
		
		// corporate_name virification check
		if ($err_mes ['corporate_name'] == '') {
			if ($forms ['id'] == '') {
				$where = sprintf ( "corporate_name = '%s'", $forms ['corporate_name'] );
			} else {
				if (! empty ( $forms ['mutirow'] )) {
					$err_mes ['mutirow'] = $err->check ( $forms ['mutirow'], array (
							"EXIST" 
					) );
				}
				$where = sprintf ( "corporate_name = '%s' AND id <> %s", $forms ['corporate_name'], $forms ['id'] );
			}
			if ($corporate_dao->exits ( $where )) {
				$err->clear = false;
				$err_mes ['corporate_name'] = "<p class='error'>この会社名は重複しています</p>";
			}
		}
		// if err, reset values to page
		$smarty->assign ( 'region', $forms ['region'] );
		$smarty->assign ( 'branch', $forms ['branch'] );
		$smarty->assign ( 'area_code', $forms ['area_code'] );
		$smarty->assign ( 'office_number', $forms ['office_number'] );
		$smarty->assign ( 'called_number', $forms ['called_number'] );
		$smarty->assign ( 'tantou_forms', $forms ['mutirow'] );
		$smarty->assign ( 'corporate_forms', $forms );
		$smarty->assign ( 'forms', $forms );
		$smarty->assign ( 'account_id', $account_id );
		
		// if err check ok
		if ($err->clear) {
			$executeflg = TRUE;
			// set 登録 更新 needed item values
			$values = array ();
			$values ['corporate_name'] = $forms ['corporate_name'];
			$values ['another_name'] = $forms ['another_name'];
			$values ['post_name'] = $forms ['post_name'];
			
			// deal with post_code
			$region = $forms ['region'];
			$branch = $forms ['branch'];
			$values ['post_code'] = $region .'-'. $branch;
			
			$values ['address'] = $forms ['address'];
			
			// deal with tel
			$area_code = $forms ['area_code'];
			$office_number = $forms ['office_number'];
			$called_number = $forms ['called_number'];
			$values ['tel'] = $area_code .'-'. $office_number .'-'. $called_number;
			
			$values ['present'] = $forms ['present'];
			$values ['url'] = $forms ['url'];
			
			
			// 登録
			if ($forms ['id'] == '') {
				$forms ['id'] = $id;
				if (isset($forms['insert_true'])) {
					unset($forms['insert_true']);
					$_SESSION['insertforms'] = $forms;
					header ( "Location: ./corporate_insert.php");
					exit ();
				}
				unset($_SESSION['insertforms']);
				try {
					// begin transaction
					$corporate_dao->begin_trans ();
					
// 					$order = array("\r\n","\n","\r");
// 					$replace = "<br/>";
// 					$forms['memo'] = str_replace($order,$replace,$forms['memo']);
					$forms['memo'] = str_replace(" ","",$forms['memo']);
					$forms['memo'] = str_replace("　","",$forms['memo']);
					$values ['memo'] = $forms ['memo'];
					if ($id = $corporate_dao->add ( $values )) {
						
						// then get each tantou item
						foreach ( $forms ['mutirow'] as $kk => $vv ) {
							$tantou_val ['corporate_id'] = $id;
							$tantou_val ['tantou_name'] = $vv ['tantou_name'];
							$tantou_val ['mail_address'] = $vv ['mail_address'];
							// add tantou data
							if ($tantou_dao->add0 ( $tantou_val )) {
							} else {
								$executeflg = FALSE;
								break;
							}
						}
						
						// if auth = 2, then get account_id from session
						if ($auth == '2') {
							$account_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_SEQ'];
						}
						
						// update account other_id
						$account_values = array ();
						$account_values ['other_id'] = $id;
						
						$smarty->assign('corporate_id', $id);
						if ($account_dao->edit ( $account_id, $account_values )) {
						} else {
							$executeflg = FALSE;
							break;
						}
					} else {
						$executeflg = FALSE;
					}
					
					if ($executeflg) {
						$corporate_dao->commit_trans ();

						// get login_id and login_pwd
						$account_sql = "select * from mp_account where other_id = '$id' ";
						$mail_account_data = $account_dao->get_rows($account_sql);
						foreach ($mail_account_data as $k => $v) {
							$mail_id = $v['login_id'];
							$mail_pwd = $v['login_pwd'];
						}
						$prego_mail_corporate_insert_content = PREGO_MAIL_CORPORATE_INSERT_CONTENT_A.$mail_id.PREGO_MAIL_CORPORATE_INSERT_CONTENT_B.$mail_pwd.PREGO_MAIL_CORPORATE_INSERT_CONTENT_C."\n".PREGO_LOGIN_URL;
						// get corporate tantou mailAddress
						$sql = "select * from mp_corporate_tantou where corporate_id = '$id' ";
						$tantou_mail_data = $tantou_dao->get_rows($sql);
						foreach ($tantou_mail_data as $k => $v) {
							if($v['mail_address'] != ''){
								$smtp_dao->senduserMail($v['mail_address'],PREGO_MAIL_CORPORATE_INSERT_SUBJECT,$prego_mail_corporate_insert_content);
							}
						}
						$smarty->assign('message', '登録が完了しました。通知メール送信完了しました。');
						
					} else {
						$corporate_dao->rollback_trans ();
						$smarty->assign ( 'message', '登録が失敗しました。' );
					}
					
				} catch ( Exception $e ) {
					$corporate_dao->rollback_trans ();
					$smarty->assign ( 'message', 'ＤＢエラーで失敗しました。' );
				}
				// 更新
			} else {
				
				$promise_dao = new Class_mp_promise($corporate_dao->get_db());
				$request_dao = new Class_mp_request($corporate_dao->get_db());
				
				try {
					
					// begin transaction
					$corporate_dao->begin_trans ();
					
					if($auth == '1'){
// 						$order = array("\r\n","\n","\r");
// 						$replace = "<br/>";
// 						$forms['memo'] = str_replace($order,$replace,$forms['memo']);
						$forms['memo'] = str_replace(" ","",$forms['memo']);
						$forms['memo'] = str_replace("　","",$forms['memo']);
						$values ['memo'] = $forms ['memo'];
					}
					
					// update corporate info
					if ($corporate_dao->edit ( $forms ['id'], $values )) {
						
						$promise_corporate_data = $corporate_dao->get($forms['id']);
						
						$promise_values = array();
						$promise_corporate_id = $forms['id'];
						$promise_values['corporate_name'] = $promise_corporate_data['corporate_name'];
						$where = "corporate_id = '$promise_corporate_id' ";
						if($promise_dao->editbywhere($where, $promise_values)){
							
						}else{
							$executeflg = FALSE;
							break;
						}
						
						$request_values = array();
						$request_corporate_id = $forms['id'];
						$request_values['corporate_name'] = $promise_corporate_data['corporate_name'];
						$where = "corporate_id = '$request_corporate_id' ";
						if($request_dao->editbywhere($where, $request_values)){
							
						}else{
							$executeflg = FALSE;
							break;
						}
						
					} else {
						$executeflg = FALSE;
						break;
					}
					
					// if update corporate info success
					if ($executeflg) {
						
						// get corporate_tantou by corporate_id
						$sql = sprintf ( "select * from mp_corporate_tantou where corporate_id = '%s'", $forms ['id'] );
						$dbarray = $tantou_dao->get_rows ( $sql );
						
						// foreach $dbarray
						foreach ( $dbarray as $k => $v ) {
							
							// set del flag
							$delflag = true;
							
							$val_tantou_name = "";
							$val_mail_address = "";
							foreach ( $forms ['mutirow'] as $kk => $vv ) {
								if ($v ['id'] == $vv ['id']) {
									$delflag = false;
									$val_tantou_name = $vv ['tantou_name'];
									$val_mail_address = $vv ['mail_address'];
								}
							}
							if ($delflag) {
								// remove data
								if ($tantou_dao->remove ( $v ['id'] )) {
								} else {
									$executeflg = false;
								}
							} else {
								$values = array ();
								$values ['corporate_id'] = $forms ['id'];
								$values ['tantou_name'] = $val_tantou_name;
								$values ['mail_address'] = $val_mail_address;
								// update data
								if ($tantou_dao->edit ( $v ['id'], $values )) {
								} else {
									$executeflg = false;
								}
							}
						}
						
						// foreach $forms['mutirow'] array, then add tantou data
						// depands on condition
						foreach ( $forms ['mutirow'] as $k => $v ) {
							$taddflag = true;
							$corporate_id = $forms ['id'];
							foreach ( $dbarray as $kk => $vv ) {
								if ($v ['id'] == $vv ['id']) {
									$taddflag = false;
									break;
								}
							}
							if ($taddflag) {
								$values = array ();
								$values ['corporate_id'] = $corporate_id;
								$values ['tantou_name'] = $v ['tantou_name'];
								$values ['mail_address'] = $v ['mail_address'];
								// add data
								if ($tantou_dao->add0 ( $values )) {
								} else {
									$executeflg = FALSE;
								}
							}
						}
					}
					
					if ($executeflg) {
						$corporate_dao->commit_trans ();
						$smarty->assign('corporate_id', $forms['id']);
						$temp_id = $forms['id'];
						// get corporate tantou mailAddress
						$sql = "select * from mp_corporate_tantou where corporate_id = '$temp_id' ";
						$tantou_mail_data = $tantou_dao->get_rows($sql);
						foreach ($tantou_mail_data as $k => $v) {
							if($v['mail_address'] != ''){
								$smtp_dao->senduserMail($v['mail_address'],PREGO_MAIL_CORPORATE_UPDATE_SUBJECT,PREGO_MAIL_CORPORATE_UPDATE_CONTENT."\n".PREGO_LOGIN_URL);
							}
						}
						$smarty->assign ( 'message', '更新が完了しました。通知メール送信完了しました。' );
					} else {
						$corporate_dao->rollback_trans ();
						$smarty->assign ( 'message', '更新が失敗しました。' );
					}
				} catch ( Exception $e ) {
					$corporate_dao->rollback_trans ();
					$executeflg = false;
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
if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $err_mes ))
	$smarty->assign ( 'err', $err_mes );

$smarty->assign ( 'auth', $auth );
$smarty->assign ( 'phase', $phase );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'corporate_edit.html' );

?>

