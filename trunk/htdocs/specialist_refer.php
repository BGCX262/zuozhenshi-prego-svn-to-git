<?php
require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');
require_once ('../system/prego_m.php');
require_once ('../system/login.inc.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/mdao/Class_mp_spec_traffic_fee.php');
require_once ('../system/mdao/Class_mp_spec_profile.php');
require_once ('../system/mdao/Class_mp_spec_fee.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/mdao/Class_mp_pro.php');

$specialist_dao = new Class_mp_specialist ();
$traffic_fee_dao = new Class_mp_spec_traffic_fee ();
$spec_profile_dao = new Class_mp_spec_profile ();
$spec_fee_dao = new Class_mp_spec_fee ();
$account_dao = new Class_mp_account ();
$pro_dao = new Class_mp_pro();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	$phase = 'input';
	
	if ($auth == '3') {
		
		$account_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_SEQ'];
		$account_data = $account_dao->get ( $account_id );
		$id = $account_data ['other_id'];
	} elseif ($auth == '1') {
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			
			$id = $_GET ['id'];
			$account_data = $account_dao->getByOtherid ( $id , 3);
		}
	}
	$smarty->assign ( 'account_name', $account_data['user_name'] );
	
	// get spec_forms by id
	$spec_forms = $specialist_dao->get ( $id );
	$prolist = $pro_dao->getProBySpecId($id);
	if (is_array($prolist)){
		foreach ($prolist as $pro){
			$pro_name [] = $pro['pro_name'];
		}
		$proname = implode(',', $pro_name);
	}
	
	// deal with $post_code
	$region = substr ( $spec_forms ['post_code'], 0, 3 );
	$branch = substr ( $spec_forms ['post_code'], 3, 4 );
	if(!empty($region) && !empty($branch)){
		$post_code = $region . "-" . $branch;
	}
	
	// deal with $area_code
	$area_code = substr ( $spec_forms ['tel'], 0, 2 );
	$office_number = substr ( $spec_forms ['tel'], 2, 4 );
	$called_number = substr ( $spec_forms ['tel'], 6, 4 );
	if(!empty($area_code) && !empty($office_number) && !empty($called_number)){
		$tel = $area_code . "-" . $office_number . "-" . $called_number;
	}
	
	// deal with $phone
	$cell1 = substr ( $spec_forms ['phone'], 0, 2 );
	$cell2 = substr ( $spec_forms ['phone'], 2, 4 );
	$cell3 = substr ( $spec_forms ['phone'], 6, 4 );
	if(!empty($cell1) && !empty($cell2) && !empty($cell3)){
		$phone = $cell1 . "-" . $cell2 . "-" . $cell3;
	}
	
	// deal with fax
	$fax1 = substr ( $spec_forms ['fax'], 0, 2 );
	$fax2 = substr ( $spec_forms ['fax'], 2, 4 );
	$fax3 = substr ( $spec_forms ['fax'], 6, 4 );
	if(!empty($fax1) && !empty($fax2) && !empty($fax3)){
		$fax = $fax1 . "-" . $fax2 . "-" . $fax3;
	}
	
	// get spec_traffic_fee_forms
	$traffic_fee_sql = sprintf ( "select * from mp_spec_traffic_fee where spec_id = '%s'", mysql_real_escape_string ( $id ) );
	$spec_traffic_fee_forms = $traffic_fee_dao->get_rows ( $traffic_fee_sql );
	if (is_array($spec_traffic_fee_forms)){
			foreach ($spec_traffic_fee_forms as $dtime){
				$d_time[] = date('Y-m-d',strtotime($dtime['d_time']));
			}
		}
	$smarty->assign ( 'd_time', $d_time );
	
	// get spec_profile_forms
	$spec_profile_sql = sprintf ( "select * from mp_spec_profile where spec_id = '%s' ", mysql_real_escape_string ( $id ) );
	$spec_profile_forms = $spec_profile_dao->get_rows ( $spec_profile_sql );
	//print_r($spec_profile_forms);exit;
	// get spec_fee_forms
	$spec_fee_sql = sprintf ( "select * from mp_spec_fee where spec_id = '%s'", mysql_real_escape_string ( $id ) );
	$spec_fee_forms = $spec_fee_dao->get_rows ( $spec_fee_sql );
	
	// set id
	$forms ['id'] = $id;
	
	
}
if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $spec_forms ))
	$smarty->assign ( 'spec_forms', $spec_forms );
if (isset ( $spec_traffic_fee_forms ))
	$smarty->assign ( 'spec_traffic_fee_forms', $spec_traffic_fee_forms );
if (isset ( $spec_profile_forms )){
	foreach ($spec_profile_forms as $key=>$v){
		$data = $spec_profile_dao->get ( $v['id'] );
		$spec_profile_forms [$key]['have_profile_url'] = $data['have_profile_url'];
	}
	$smarty->assign ( 'spec_profile_forms', $spec_profile_forms );
}
if (isset ( $spec_fee_forms ))
	$smarty->assign ( 'spec_fee_forms', $spec_fee_forms );
if (isset($proname)){
	$smarty->assign ( 'proname', $proname );
}



$have_profile_url = $_SERVER["HTTP_REFERER"];
$have_no_profile_url=$_SERVER["HTTP_REFERER"];
$strArr=explode('specialist',$have_profile_url);

$smarty->assign ( 'have_profile_url', $strArr[0]."popup/specialist_profile1.php?ID=");
$smarty->assign ( 'have_no_profile_url', $strArr[0]."popup/specialist_profile2.php?ID=");

//print_r($prolist);exit;
$smarty->assign ( 'post_code', $post_code );
$smarty->assign ( 'tel', $tel );
$smarty->assign ( 'phone', $phone );
$smarty->assign ( 'fax', $fax );

$smarty->assign ( 'introducer_fee', $prego_introducer_fee );
$smarty->assign ( 'introducer_fee_status', $prego_introducer_fee_status );
$smarty->assign ( 'login_fee', $prego_login_fee );
$smarty->assign ( 'hp_arr', $hp_arr );
$smarty->assign ( 'update_fee', $prego_update_fee );
$smarty->assign ( 'spec_area', $prego_spec_area );
$smarty->assign ( 'account_kinds', $prego_account_kinds );
$smarty->assign ( 'person_choose', $prego_person_choose );

$smarty->assign ( 'auth', $auth );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'specialist_refer.html' );

?>