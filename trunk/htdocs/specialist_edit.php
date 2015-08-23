<?php
require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/mdao/Class_mp_spec_traffic_fee.php');
require_once ('../system/mdao/Class_mp_spec_fee.php');
require_once ('../system/mdao/Class_mp_spec_profile.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_payment.php');
require_once ('../system/mdao/Class_mp_pro.php');
require_once ('../system/prego_m.php');
require_once ('../system/Class_ERROR.php');
require_once ('../system/login.inc.php');
require_once ('../system/smtpsend.class.php');

$specialist_dao = new Class_mp_specialist ();
$smtp_dao = new smtpclass();
$pro_dao = new Class_mp_pro();
if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	$phase = 'input';
	
	// from specialist_unregistered.html
	if (isset ( $_GET ['account_id'] ) && ! empty ( $_GET ['account_id'] )) {
		$account_id = $_GET ['account_id'];
		$smarty->assign ( 'account_id', $account_id );
		// from specialist_refer.html
	} else {
		$traffic_fee_dao = new Class_mp_spec_traffic_fee ();
		$spec_fee_dao = new Class_mp_spec_fee ();
		$spec_profile_dao = new Class_mp_spec_profile;
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			
			// get spec_forms
			$spec_forms = $specialist_dao->get ( $_GET ['id'] );
			$prolist = $pro_dao->getProBySpecId($_GET ['id']);
			if (is_array($prolist)){
				foreach ($prolist as $pro){
					if ($pro['pro_id'] == 99)
						$spec_area_else = $pro['pro_name'];
					else 
						$spec_areas[] = $pro['pro_id']; 
				}
			}
			// get spec_traffic_fee_forms by spec_id
			$tra_sql = sprintf ( "select * from mp_spec_traffic_fee where spec_id = '%s'", mysql_real_escape_string ( $_GET ['id'] ) );
			$spec_traffic_fee_forms = $traffic_fee_dao->get_rows ( $tra_sql );
			if (is_array($spec_traffic_fee_forms)){
				foreach ($spec_traffic_fee_forms as $dtime){
					$d_time[] = date('Y-m-d',strtotime($dtime['d_time']));
				}
			}
			$smarty->assign ( 'd_time', $d_time );
			
			// get servers_forms by spec_id
			$spec_sql = sprintf ( "select * from mp_spec_fee where spec_id = '%s'", mysql_real_escape_string ( $_GET ['id'] ) );
			$servers_forms = $spec_fee_dao->get_rows ( $spec_sql );
			
			// get spec_profile_forms
			$spec_profile_sql = sprintf ( "select * from mp_spec_profile where spec_id = '%s' ", mysql_real_escape_string ( $_GET ['id'] ) );
			$spec_profile_forms = $spec_profile_dao->get_rows ( $spec_profile_sql );
			
			$forms ['id'] = $_GET ['id'];
			
		}else{
			$account_dao = new Class_mp_account;
			
			// get other_id
			$id = $_SESSION ['PREGO_ADMIN'] ['STAFF_SEQ'];
			$account_data = $account_dao->get($id);
			$other_id = $account_data['other_id'];
			
			if($other_id != '0'){
				
				// get spec_forms
				$spec_forms = $specialist_dao->get ( $other_id );
				
				
				// get spec_traffic_fee_forms by spec_id
				$tra_sql = sprintf ( "select * from mp_spec_traffic_fee where spec_id = '%s'", mysql_real_escape_string ( $other_id ) );
				$spec_traffic_fee_forms = $traffic_fee_dao->get_rows ( $tra_sql );
				
				// get servers_forms by spec_id
				$spec_sql = sprintf ( "select * from mp_spec_fee where spec_id = '%s'", mysql_real_escape_string ( $other_id ) );
				$servers_forms = $spec_fee_dao->get_rows ( $spec_sql );
				
				// get spec_profile_forms
				$spec_profile_sql = sprintf ( "select * from mp_spec_profile where spec_id = '%s' ", mysql_real_escape_string ( $other_id ) );
				$spec_profile_forms = $spec_profile_dao->get_rows ( $spec_profile_sql );
				
				$forms ['id'] = $other_id;
				
			}
			
		}
		
		// deal with zip code
		$post_code_arr = split('-',$spec_forms ['post_code']);
		$region = $post_code_arr[0];
		$branch = $post_code_arr[1];
		
		// deal with tel
		$tel_arr = split('-',$spec_forms ['tel']);
		$area_code = $tel_arr[0];
		$office_number = $tel_arr[1];
		$called_number = $tel_arr[2];
			
		// deal with phone
		$phone_arr = split('-',$spec_forms['phone']);
		$cell1 = $phone_arr[0];
		$cell2 = $phone_arr[1];
		$cell3 = $phone_arr[2];
			
		// deal with fax
		$fax_arr = split('-',$spec_forms['fax']);
		$fax1 = $fax_arr[0];
		$fax2 = $fax_arr[1];
		$fax3 = $fax_arr[2];
			
		// deal with birthday
		$birthday_arr = split('-', $spec_forms['birthday']);
		$birthday_year = $birthday_arr[0];
		$birthday_month = $birthday_arr[1];
		$birthday_day = $birthday_arr[2];
		
		// set values to page
		$smarty->assign('spec_areas',$spec_areas);
		$smarty->assign('spec_area_else',$spec_area_else);
		$smarty->assign ( 'region', $region );
		$smarty->assign ( 'branch', $branch );
		$smarty->assign ( 'area_code', $area_code );
		$smarty->assign ( 'office_number', $office_number );
		$smarty->assign ( 'called_number', $called_number );
		$smarty->assign ( 'cell1', $cell1 );
		$smarty->assign ( 'cell2', $cell2 );
		$smarty->assign ( 'cell3', $cell3 );
		$smarty->assign ( 'fax1', $fax1 );
		$smarty->assign ( 'fax2', $fax2 );
		$smarty->assign ( 'fax3', $fax3 );
		$smarty->assign ( 'birthday_year', $birthday_year );
		$smarty->assign ( 'birthday_month', $birthday_month );
		$smarty->assign ( 'birthday_day', $birthday_day );
		
		if (isset ( $spec_forms ))
			$smarty->assign ( 'spec_forms', $spec_forms );
		if (isset ( $spec_traffic_fee_forms ))
			$smarty->assign ( 'spec_traffic_fee_forms', $spec_traffic_fee_forms );
		if (isset ( $servers_forms ))
			$smarty->assign ( 'servers_forms', $servers_forms );
		if (isset ( $spec_profile_forms ))
			$smarty->assign ( 'spec_profile_forms', $spec_profile_forms );
	}
	// POST
} else {
	
	$forms = $_POST;
	$account_id = $forms ['account_id'];
	$account_dao = new Class_mp_account ( $specialist_dao->get_db () );
	
	// get traffic_fee_id arr
	if (isset ( $forms ['traffic_fee_id'] )) {
		foreach ( $forms ['traffic_fee_id'] as $k => $v ) {
			$forms ['mutirow'] [] = array (
					"id" => $v,
					"traffic_name" => $forms ['traffic_name'] [$k],
					"traffic_fee" => $forms ['traffic_fee'] [$k],
					"traffic_memo" => $forms ['traffic_memo'] [$k],
					"d_time" =>  $forms['d_time'][$k]
			);
		}
	}
	// set $forms['mutirow_fee'] array
	if (isset ( $forms ['spec_fee_id'] )) {
		foreach ( $forms ['spec_fee_id'] as $k => $v ) {
			$forms ['mutirow_fee'] [] = array (
					"id" => $v,
					"service_id" => $forms['service_id'][$k],
					"servers_menu" => $forms ['servers_menu'] [$k],
					"spec_fee" => $forms ['spec_fee'] [$k],
					"servers_fee" => $forms ['servers_fee'] [$k] 
			);
		}
	}
	
	if ($forms ['mode'] == 'input') {
		
		// check specialist items
		$values = array ();
		$err = new Class_ERROR ();
		$specialist_chk = $specialist_dao->get_checks ();
		$forms ["interlingua"] = str_replace('　',' ', $forms ["interlingua"]);
		
		foreach ( $specialist_chk as $kcol => $chkval ) {
			$err_mes [$kcol] = $err->check ( $forms [$kcol], $chkval );
		}
		//郵便番号判定
		$err_mes['post_code'] = $err->zipcode_check($forms['region']."-".$forms['branch']);
		//電話番号判定
		$err_mes['tel']   = $err->tel_check($forms['area_code']."-".$forms['office_number']."-".$forms['called_number']);
		//携帯電話番号判定
		$err_mes['phone'] = $err->tel_check($forms['cell1'].'-'.$forms['cell2'].'-'.$forms['cell3']);
		//FAX番号判定
		$err_mes['fax']   = $err->fax_check($forms['fax1'].'-'.$forms['fax2'].'-'.$forms['fax3']);
		//年月日判定
		if(!empty($forms['birthday_year']) && !empty($forms['birthday_month']) && !empty($forms['birthday_day'])){
			$err_mes['birthday'] = $err->ymd_check($forms['birthday_year'].'/'.$forms['birthday_month'].'/'.$forms['birthday_day']);
		}
		
		// check traffic_fee items
		$index = 0;
		$traffic_fee_dao = new Class_mp_spec_traffic_fee ( $specialist_dao->get_db () );
		$traffic_chk = $traffic_fee_dao->get_checks ();
		if ($forms ['mutirow'] ){
			foreach ( $forms ['mutirow'] as $k => $v ) {
				$err_mes ['traffic_name'] [$index] = $err->check ( $v ['traffic_name'], $traffic_chk ['traffic_name'] );
				$err_mes ['traffic_fee']  [$index] = $err->check ( $v ['traffic_fee'],  $traffic_chk ['traffic_fee'] );
				$err_mes ['traffic_memo'] [$index] = $err->check ( $v ['traffic_memo'], $traffic_chk ['traffic_memo'] );
				$index = $index + 1;
			}
		}
		// check spec_fee items
		$index_fee = 0;
		$spec_fee_dao = new Class_mp_spec_fee ( $specialist_dao->get_db () );
		$spec_fee_chk = $spec_fee_dao->get_checks ();
		if ($forms ['mutirow_fee'] ){
			foreach ( $forms ['mutirow_fee'] as $k => $v ) {
				$err_mes ['servers_menu'] [$index_fee] = $err->check ( $v ['servers_menu'], $spec_fee_chk ['servers_menu'] );
				$err_mes ['spec_fee'] [$index_fee] = $err->check ( $v ['spec_fee'], $spec_fee_chk ['spec_fee'] );
				$err_mes ['servers_fee'] [$index_fee] = $err->check ( $v ['servers_fee'], $spec_fee_chk ['servers_fee'] );
				$index_fee = $index_fee + 1;
			}
		}
		
		// reset values to page
		$smarty->assign ( 'account_id',$forms ['account_id'] );
		$smarty->assign ( 'region', $forms ['region'] );
		$smarty->assign ( 'branch', $forms ['branch'] );
		$smarty->assign ( 'area_code', $forms ['area_code'] );
		$smarty->assign ( 'office_number', $forms ['office_number'] );
		$smarty->assign ( 'called_number', $forms ['called_number'] );
		$smarty->assign ( 'cell1', $forms ['cell1'] );
		$smarty->assign ( 'cell2', $forms ['cell2'] );
		$smarty->assign ( 'cell3', $forms ['cell3'] );
		$smarty->assign ( 'fax1', $forms ['fax1'] );
		$smarty->assign ( 'fax2', $forms ['fax2'] );
		$smarty->assign ( 'fax3', $forms ['fax3'] );
		$smarty->assign ( 'birthday_year', $forms ['birthday_year'] );
		$smarty->assign ( 'birthday_month', $forms ['birthday_month'] );
		$smarty->assign ( 'birthday_day', $forms ['birthday_day'] );
		$smarty->assign ( 'spec_forms', $forms );
		$smarty->assign ( 'spec_traffic_fee_forms', $forms ['mutirow'] );
		$smarty->assign ( 'servers_forms', $forms ['mutirow_fee'] );
		
		// check ok
		if ($err->clear) {
			$cols = $specialist_dao->get_cols ();
			foreach ( $cols as $kcol => $val ) {
				$values [$kcol] = $forms [$kcol];
			}
			
			// deal with spec_area
			
			if(isset($forms['spec_area']) && $forms['spec_area'] != ''){
				$spec_area = $forms['spec_area'];
			}
			if(isset($forms['spec_area_d']) && $forms['spec_area_d'] != '' && isset($forms['spec_area_else']) && $forms['spec_area_else'] != ''){
				$m_prego_pro[99] = $forms['spec_area_else'];
				$spec_area[] = 99;
			}
			
			// set zip code values
			$region = $forms ['region'];
			$branch = $forms ['branch'];
			if (! empty ( $region ) && ! empty ( $branch )) {
				$values ['post_code'] = $region .'-'. $branch;
			}
			// set tel values
			$area_code = $forms ['area_code'];
			$office_number = $forms ['office_number'];
			$called_number = $forms ['called_number'];
			if (! empty ( $area_code ) && ! empty ( $office_number ) && ! empty ( $called_number )) {
				$values ['tel'] = $area_code .'-'. $office_number .'-'. $called_number;
			}
			
			// set phone values
			$cell1 = $forms ['cell1'];
			$cell2 = $forms ['cell2'];
			$cell3 = $forms ['cell3'];
			if (! empty ( $cell1 ) && ! empty ( $cell2 ) && ! empty ( $cell3 )) {
				$values ['phone'] = $cell1 .'-'. $cell2 .'-'. $cell3;
			}
			
			// set fax values
			$fax1 = $forms ['fax1'];
			$fax2 = $forms ['fax2'];
			$fax3 = $forms ['fax3'];
			if (! empty ( $fax1 ) && ! empty ( $fax2 ) && ! empty ( $fax3 )) {
				$values ['fax'] = $fax1 .'-'. $fax2 .'-'. $fax3;
			}
			
			// set birthday values
			$birthday_year = $forms ['birthday_year'];
			if(strlen($forms['birthday_month']) == 1){
				$forms['birthday_month'] = '0'.$forms['birthday_month'];
			}
			$birthday_month = $forms ['birthday_month'];
			if(strlen($forms['birthday_day']) == 1){
				$forms['birthday_day'] = '0'.$forms['birthday_day'];
			}
			$birthday_day = $forms ['birthday_day'];
			if (! empty ( $birthday_year ) && ! empty ( $birthday_month ) && ! empty ( $birthday_day )) {
				$values ['birthday'] = $birthday_year . "-" . $birthday_month . "-" . $birthday_day;
			}
			
			// 桁数チェック
			$maxlens = $specialist_dao->get_maxlens ();
			foreach ( $maxlens as $k => $v ) {
				$err_mes [$k] = $err->check_size ( $values [$k], $v );
			}
		}
		// check ok
		
		if ($err->clear) {
			$executeflg = TRUE;
			// 登録
			if ($forms ['id'] == '') {
				
				try {
					// begin transaction
					$values['spec_name']   = $values['spec_name1'].' '.$values['spec_name2'];
					$values['interlingua'] = $values['interlingua1'].' '.$values['interlingua2'];
					$values['address']     = $prego_local[$values['pro_cd']].$values['address1'];
					$specialist_dao->begin_trans ();
					if ($specialist_id = $specialist_dao->add($values)) {
						//$spec_area$spec_area_else$m_prego_pro
						if (is_array($spec_area) && $spec_area){
							if ($pro_dao->getProBySpecId($specialist_id)){
								if (!mysql_query('delete from mp_pro where spec_id='.$specialist_id)){
									mysql_query('rollback');
									$executeflg = FALSE;
								}
							}
							$sql = 'insert into mp_pro(spec_id,pro_id,pro_name) values';
							$insertvalues = '';
							if (is_array($spec_area)){
								foreach ($spec_area as $key=>$v){echo $v;
									$insertvalues .= "(".$specialist_id.",".$v.",'".$m_prego_pro[$v]."'),";
								}
							}
							$insertvalues = substr($insertvalues, 0,-1);
							$sql.=$insertvalues;
							if (!mysql_query($sql)){
								mysql_query('rollback');
								$executeflg = FALSE;
							}
						}
						$forms ['id'] = $specialist_id;
						$forms ['insertid'] = $specialist_id;
						// get each traffic_fee item
						foreach ( $forms ['mutirow'] as $kk => $vv ) {
							$traffic_fee_val ['spec_id'] = $specialist_id;
							$traffic_fee_val ['traffic_name'] = $vv ['traffic_name'];
							$traffic_fee_val ['traffic_fee'] = $vv ['traffic_fee'];
							$traffic_fee_val ['traffic_memo'] = $vv ['traffic_memo'];
							$traffic_fee_val ['d_time'] = $vv['d_time'];
							if ($traffic_fee_dao->add0 ( $traffic_fee_val )) {
							} else {
								$executeflg = FALSE;
								break;
							}
						}
						foreach ( $forms ['mutirow_fee'] as $kk => $vv ) {
							$spec_fee_val ['spec_id'] = $specialist_id;
							$spec_fee_val ['service_id'] = $vv['service_id'];
							$spec_fee_val ['servers_menu'] = $vv ['servers_menu'];
							$spec_fee_val ['spec_fee'] = $vv ['spec_fee'];
							$spec_fee_val ['servers_fee'] = $vv ['servers_fee'];
							if ($spec_fee_dao->add0 ( $spec_fee_val )) {
							} else {
								$executeflg = FALSE;
								break;
							}
						}
						
						// update account other_id
						$account_values = array ();
						$account_values ['other_id'] = $specialist_id;
						
						if ($auth == '3') {
							$account_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_SEQ'];
						}
						
						$smarty->assign('specialist_id', $specialist_id );
						if ($account_dao->edit ( $account_id, $account_values )) {
						} else {
							$executeflg = FALSE;
							break;
						}
					} else {
						$executeflg = FALSE;
					}
					
					if ($executeflg) {
						$specialist_dao->commit_trans ();

						// get specialist login_id and login_pwd
						$sql = "select * from mp_account where other_id = '$specialist_id' ";
						$mail_account_data = $account_dao->get_rows($sql);
						foreach ($mail_account_data as $k => $v) {
							$mail_id = $v['login_id'];
							$mail_pwd = $v['login_pwd'];
						}
						$prego_mail_specialist_insert_content = PREGO_MAIL_SPECIALIST_INSERT_CONTENT_A.$mail_id.PREGO_MAIL_SPECIALIST_INSERT_CONTENT_B.$mail_pwd.PREGO_MAIL_SPECIALIST_INSERT_CONTENT_C."\n".PREGO_LOGIN_URL;
						
						$AddCC = array(0=>$prego_mail);
						
						$spec_mail_data = $specialist_dao->get($specialist_id);
						if($spec_mail_data['mail_address1'] != ''){
							$smtp_dao->senduserMail($spec_mail_data['mail_address1'],PREGO_MAIL_SPECIALIST_INSERT_SUBJECT,$prego_mail_specialist_insert_content,$AddCC);
						}
						if($spec_mail_data['mail_address2'] != ''){
							$smtp_dao->senduserMail($spec_mail_data['mail_address2'],PREGO_MAIL_SPECIALIST_INSERT_SUBJECT,$prego_mail_specialist_insert_content);
						}
						$smarty->assign('message', '登録が完了しました。通知メール送信完了しました。');
					} else {
						$specialist_dao->rollback_trans ();
						$smarty->assign ( 'message', '登録が失敗しました。' );
					}
				} catch ( Exception $e ) {
					$specialist_dao->rollback_trans ();
					$smarty->assign ( 'message', 'ＤＢエラーで失敗しました。' );
				}
				// 更新
			} else {
				$values['spec_name']   = $values['spec_name1'].' '.$values['spec_name2'];
				$values['interlingua'] = $values['interlingua1'].' '.$values['interlingua2'];
				$values['address']     = $prego_local[$values['pro_cd']].$values['address1'];
				$promise_spec_dao = new Class_mp_promise_spec($specialist_dao->get_db());
				$payment_dao = new Class_mp_payment($specialist_dao->get_db());
				try {
					// begin transaction
					$specialist_dao->begin_trans ();
					if ($specialist_dao->edit ( $forms ['id'], $values )) {
						
						if (is_array($spec_area) && $spec_area){
							if ($pro_dao->getProBySpecId($forms ['id'])){
								if (!mysql_query('delete from mp_pro where spec_id='.$forms['id'])){
									mysql_query('rollback');
									$executeflg = FALSE;
								}
							}
							$sql = 'insert into mp_pro(spec_id,pro_id,pro_name) values';
							$insertvalues = '';
							if (is_array($spec_area)){
								foreach ($spec_area as $key=>$v){echo $v;
									$insertvalues .= "(".$forms['id'].",".$v.",'".$m_prego_pro[$v]."'),";
								}
							}
							$insertvalues = substr($insertvalues, 0,-1);
							$sql.=$insertvalues;
							if (!mysql_query($sql)){
								mysql_query('rollback');
								$executeflg = FALSE;
							}
						}
						
						$spec_data = $specialist_dao->get($forms ['id']);
						
						$spec_name = $spec_data['spec_name'];
						$promise_spec_id = $forms['id'];
						$promise_spec_values = array();
						$promise_spec_values['spec_name'] = $spec_name;
						
						$where = "spec_id = '$promise_spec_id' ";
						
						if($promise_spec_dao->editbywhere($where, $promise_spec_values)){
							
						}else{
							$executeflg = FALSE;
							break;
						}
						
						$pay_spec_id = $forms['id'];
						$pay_spec_name = $spec_data['spec_name'];
						$pay_values =array();
						$pay_values['spec_name'] = $pay_spec_name;
						$where = "spec_id = '$pay_spec_id' ";
						
						if($payment_dao->editbywhere($where, $pay_values)){
							
						}else{
							$executeflg = FALSE;
							break;
						}
						
						
					} else {
						$executeflg = FALSE;
						break;
					}
					
					if ($executeflg) {
						$sql = sprintf ( "select * from mp_spec_traffic_fee where spec_id = '%s'", $forms ['id'] );
						$dbarray = $traffic_fee_dao->get_rows ( $sql );
						
						foreach ( $dbarray as $k => $v ) {
							
							// set del flag
							$delflag = true;
							$traffic_name_val = "";
							$traffic_fee_val = "";
							$traffic_memo_val = "";
							foreach ( $forms ['mutirow'] as $kk => $vv ) {
								if ($v ['id'] == $vv ['id']) {
									$delflag = false;
									$traffic_name_val = $vv ['traffic_name'];
									$traffic_fee_val = $vv ['traffic_fee'];
									$traffic_memo_val = $vv ['traffic_memo'];
									$d_time_val = $vv ['d_time'];
								}
							}
							
							if ($delflag) {
								if ($traffic_fee_dao->remove ( $v ['id'] )) {
								} else {
									$executeflg = false;
								}
							} else {
								$values = array ();
								$values ['spec_id'] = $forms ['id'];
								$values ['traffic_name'] = $traffic_name_val;
								$values ['traffic_fee'] = $traffic_fee_val;
								$values ['traffic_memo'] = $traffic_memo_val;
								$values ['d_time'] = $d_time_val;
								if ($traffic_fee_dao->edit ( $v ['id'], $values )) {
								} else {
									$executeflg = false;
								}
							}
						}
					if ($forms ['mutirow'] ){
						foreach ( $forms ['mutirow'] as $k => $v ) {
							$taddflag = true;
							$spec_id = $forms ['id'];
							
							foreach ( $dbarray as $kk => $vv ) {
								if ($v ['id'] == $vv ['id']) {
									$taddflag = false;
									break;
								}
							}
							
							if ($taddflag) {
								$values = array ();
								$values ['spec_id'] = $spec_id;
								$values ['traffic_name'] = $v ['traffic_name'];
								$values ['traffic_fee'] = $v ['traffic_fee'];
								$values ['traffic_memo'] = $v ['traffic_memo'];
								$values ['d_time'] = $v ['d_time'];
								if ($traffic_fee_dao->add0 ( $values )) {
								} else {
									$executeflg = FALSE;
								}
							}
						}
					}	
						
						$spec_fee_sql = sprintf ( "select * from mp_spec_fee where spec_id = '%s'", $forms ['id'] );
						$spec_fee_dbarray = $spec_fee_dao->get_rows ( $spec_fee_sql );
						
						foreach ( $spec_fee_dbarray as $k => $v ) {
							
							// set del flag
							$delflag = true;
							$servers_menu_val = "";
							$service_id_val = "";
							$spec_fee_val = "";
							$servers_fee_val = "";
							foreach ( $forms ['mutirow_fee'] as $kk => $vv ) {
								if ($v ['id'] == $vv ['id']) {
									$delflag = false;
									$servers_menu_val = $vv ['servers_menu'];
									$service_id_val = $vv['service_id'];
									$spec_fee_val = $vv ['spec_fee'];
									$servers_fee_val = $vv ['servers_fee'];
								}
							}
							
							if ($delflag) {
								if ($spec_fee_dao->remove ( $v ['id'] )) {
								} else {
									$executeflg = false;
								}
							} else {
								$values = array ();
								$values ['spec_id'] = $forms ['id'];
								$values ['servers_menu'] = $servers_menu_val;
								$values ['service_id'] = $service_id_val;
								$values ['spec_fee'] = $spec_fee_val;
								$values ['servers_fee'] = $servers_fee_val;
								if ($spec_fee_dao->edit ( $v ['id'], $values )) {
								} else {
									$executeflg = false;
								}
							}
						}
					if ($forms ['mutirow_fee'] ){
						foreach ( $forms ['mutirow_fee'] as $k => $v ) {
							$taddflag = true;
							$spec_id = $forms ['id'];
							$smarty->assign('specialist_id', $spec_id);
							foreach ( $spec_fee_dbarray as $kk => $vv ) {
								if ($v ['id'] == $vv ['id']) {
									$taddflag = false;
									break;
								}
							}
							
							if ($taddflag) {
								$values = array ();
								$values ['spec_id'] = $spec_id;
								$values ['service_id'] = $v ['service_id'];
								$values ['servers_menu'] = $v ['servers_menu'];
								$values ['spec_fee'] = $v ['spec_fee'];
								$values ['servers_fee'] = $v ['servers_fee'];
								if ($spec_fee_dao->add0 ( $values )) {
								} else {
									$executeflg = FALSE;
								}
							}
						}
						}
					}
					if ($executeflg) {
						$specialist_dao->commit_trans ();
						$smarty->assign('specialist_id', $forms ['id']);
						
						$spec_mail_data = $specialist_dao->get($forms ['id']);
// 						if($spec_mail_data['mail_address1'] != ''){
// 							$smtp_dao->senduserMail($spec_mail_data['mail_address1'],PREGO_MAIL_SPECIALIST_UPDATE_SUBJECT,PREGO_MAIL_SPECIALIST_UPDATE_CONTENT."\n".PREGO_LOGIN_URL);
// 						}
// 						if($spec_mail_data['mail_address2'] != ''){
// 							$smtp_dao->senduserMail($spec_mail_data['mail_address2'],PREGO_MAIL_SPECIALIST_UPDATE_SUBJECT,PREGO_MAIL_SPECIALIST_UPDATE_CONTENT."\n".PREGO_LOGIN_URL);
// 						}
						
						$smarty->assign ( 'message', '更新が完了しました。通知メール送信完了しました。' );
					} else {
						$specialist_dao->rollback_trans ();
						$smarty->assign ( 'message', '更新が失敗しました。' );
					}
				} catch ( Exception $e ) {
					$specialist_dao->rollback_trans ();
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
if (isset($forms['spec_area']))
	$smarty->assign('spec_areas',$forms['spec_area']);
if (isset($forms['spec_area_else']))
	$smarty->assign('spec_area_else',$forms['spec_area_else']);
//print_r($m_prego_pro);
//print_r($forms['spec_area']);exit;
$smarty->assign ( 'm_prego_pro', $m_prego_pro );
$smarty->assign ( 'phase', $phase );

$smarty->assign('prego_local',$prego_local);
$smarty->assign ( 'introducer_fee', $prego_introducer_fee );
$smarty->assign ( 'introducer_fee_status', $prego_introducer_fee_status );
$smarty->assign ( 'login_fee', $prego_login_fee );
$smarty->assign ( 'update_fee', $prego_update_fee );
$smarty->assign ( 'spec_area', $prego_spec_area );
$smarty->assign ( 'account_kinds', $prego_account_kinds );
$smarty->assign ( 'person_choose', $prego_person_choose );
$smarty->assign ( 'hp_arr', $hp_arr);
$smarty->assign ( 'auth', $auth );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'specialist_edit.html' );
?>

