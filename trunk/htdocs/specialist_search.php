<?php

require_once ('../system/smarty.inc');
require_once ('../system/login.inc.php');
require_once ('../system/prego_m.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/mdao/Class_mp_pro.php');
require_once ('../system/prego_m.php');

$dao = new Class_mp_specialist;
$account_dao = new Class_mp_account;
//$pro_dao = new Class_mp_pro();
session_start ();
if (isset ( $_GET ['csv'] ) && ($_GET ['csv'] == "download") || isset ( $_GET ['hist'] ) && ($_GET ['hist'] == "2")) {
	
	$forms = $_SESSION ['MSEARCH'] ['specialist'];
} else {
	$forms = $_POST;
	
	$_SESSION ['MSEARCH'] ['specialist'] = $forms;
}

// define array
$wherearr = array ();
$where_condition_arr = array ();
$where_introducer_fee_arr = array ();
$where_introducer_fee_status_arr = array ();
$where_login_fee_arr = array ();
$where_hp_arr = array();
$where_spec_arr = array();
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

if(isset($_GET['spec_id']) && $_GET['spec_id'] != ''){
	$dosearch = TRUE;
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$dosearch = TRUE;
}

if ($dosearch) {
	
	if($auth == '1'){
		
		if(isset($_GET['spec_id']) && $_GET['spec_id'] != ''){
		
			$id = $_GET['spec_id'];
		
			$wherearr [] = "id = '$id'";
		
		}else if(isset($_GET['id']) && $_GET['id'] != ''){
			
			$id = $_GET['id'];
			
			$wherearr[] = "id = '$id'";
		}else{
			// フリーワード search condition
			$condition = $forms ['condition'];
			if (! empty ( $condition )) {
				$where_condition_arr [] = "a.spec_area_a like '%$condition%'";
				$where_condition_arr [] = "a.spec_area_b like '%$condition%'";
				$where_condition_arr [] = "a.spec_area_c like '%$condition%'";
				$where_condition_arr [] = "a.spec_area_else like '%$condition%'";
				$where_condition_arr [] = "a.spec_name like '%$condition%'";
				$where_condition_arr [] = "a.address like '%$condition%%'";
				$where_condition_arr [] = "a.tel like '%$condition%'  ";
				$where_condition_arr [] = "REPLACE(a.tel , '-', '') like '%$condition%'  ";
				$where_condition_arr [] = "a.phone like '%$condition%'";
				$where_condition_arr [] = "REPLACE(a.phone , '-', '') like '%$condition%'  ";
				$where_condition_arr [] = "b.user_name like '%$condition%'";
			}
			$where_free_word = implode ( ' OR ', $where_condition_arr );
			if (! empty ( $where_free_word )) {
				$wherearr [] = "( $where_free_word )";
			}
			
			// introducer_fee search condition
			$introducer_fee = $forms ['introducer_fee'];
			if (! empty ( $introducer_fee )) {
				foreach ( $introducer_fee as $kk => $vv ) {
					$where_introducer_fee_arr [] = "introducer_fee = '$vv'";
				}
			}
			$where_introducer_fee = implode ( ' OR ', $where_introducer_fee_arr );
			if (! empty ( $where_introducer_fee )) {
				$wherearr [] = "( $where_introducer_fee )";
			}
			
			// introducer_fee_status search condition
			$introducer_fee_status = $forms ['introducer_fee_status'];
			if (! empty ( $introducer_fee_status )) {
				foreach ( $introducer_fee_status as $kk => $vv ) {
					$where_introducer_fee_status_arr [] = "introducer_fee_status = '$vv'";
				}
			}
			$where_introducer_fee_status = implode ( ' OR ', $where_introducer_fee_status_arr );
			if (! empty ( $where_introducer_fee_status )) {
				$wherearr [] = "( $where_introducer_fee_status )";
			}
			
			// agreement_day search condition
			
			$fromtoWhere = $dao->getFromToWhere($forms ['agreement_day_from'],$forms ['agreement_day_to'], "agreement_day");
			if (!empty ( $fromtoWhere ) ){
				$wherearr [] = $fromtoWhere;
			}
		
			/*
			if (! empty ( $agreement_day_from ) && ! empty ( $agreement_day_to )) {
				$wherearr [] = "agreement_day >= '$agreement_day_from' and agreement_day <= '$agreement_day_to'";
			} */
				
			
			
			// login_fee search condition
			$login_fee = $forms ['login_fee'];
			if (! empty ( $login_fee )) {
				foreach ( $login_fee as $kk => $vv ) {
					$where_login_fee_arr [] = "login_fee = '$vv'";
				}
			}
			$where_login_fee = implode ( ' OR ', $where_login_fee_arr );
			if (! empty ( $where_login_fee )) {
				$wherearr [] = "( $where_login_fee )";
			}
			/*
			// update_fee_start_time search condition
			$update_fee_start_time_from = $forms ['update_fee_start_time_from'];
			$update_fee_start_time_to = $forms ['update_fee_start_time_to'];
			if (! empty ( $update_fee_start_time_from ) && ! empty ( $update_fee_start_time_to )) {
				$wherearr [] = "update_fee_start_time >= '$update_fee_start_time_from' and update_fee_start_time <= '$update_fee_start_time_to'";
			}
			*/
			$fromtoWhere = $dao->getFromToWhere($forms['update_fee_start_time_from'],$forms ['update_fee_start_time_to'], "update_fee_start_time");
			if (!empty ( $fromtoWhere ) ){
				$wherearr [] = $fromtoWhere;
			}
			/*
			// agreement_end_day search condition
			$agreement_end_day_from = $forms ['agreement_end_day_from'];
			$agreement_end_day_to = $forms ['agreement_end_day_to'];
			if (! empty ( $agreement_end_day_from ) && ! empty ( $agreement_end_day_to )) {
				$wherearr [] = "agreement_end_day >= '$agreement_end_day_from' and agreement_end_day <= '$agreement_end_day_to'";
			}
			*/
			$fromtoWhere = $dao->getFromToWhere($forms['agreement_end_day_from'],$forms ['agreement_end_day_to'], "agreement_end_day");
			if (!empty ( $fromtoWhere ) ){
				$wherearr [] = $fromtoWhere;
			}
			// HP condition
			$hp = $forms['hp'];
			if(!empty($hp)){
				foreach ($hp as $kk => $vv) {
					$where_hp_arr [] = "hp = '$vv'";
				}
			}
			$where_hp = implode( ' OR ', $where_hp_arr);
			if(!empty($where_hp)){
				$wherearr [] = "( $where_hp )";
			}
			
			
			if (is_array($forms['spec_area'])){
				$strpro_id = '('.implode(',', $forms['spec_area']).')';
			}
//			// spec_area condition
//			$spec_area_a = $forms['spec_area_a'];
//			if(!empty($spec_area_a)){
//				$where_spec_arr [] = "spec_area_a = '$spec_area_a'";
//			}
//			
//			// spec_area condition
//			$spec_area_b = $forms['spec_area_b'];
//			if(!empty($spec_area_b)){
//				$where_spec_arr [] = "spec_area_b = '$spec_area_b'";
//			}
//			
//			// spec_area condition
//			$spec_area_c = $forms['spec_area_c'];
//			if(!empty($spec_area_c)){
//				$where_spec_arr [] = "spec_area_c = '$spec_area_c'";
//			}
//			
//			// spec_area condition
//			$spec_area_d = $forms['spec_area_d'];
//			if(!empty($spec_area_d)){
//				$where_spec_arr [] = "spec_area_d = '$spec_area_d' ";
//			}
			
			$where_spec = implode( ' OR ', $where_spec_arr );
			if(!empty($where_spec)){
				$wherearr [] = "( $where_spec )";
			}
		}
		
	}else if ($auth == '3'){
		
		// get other_id
		$id = $_SESSION ['PREGO_ADMIN'] ['STAFF_SEQ'];
		
		$account_data = $account_dao->get($id);
		$other_id = $account_data['other_id'];
		$wherearr[] = "a.id = '$other_id' ";
	}
	
	
	$data = $dao->search ( $wherearr, $page ,$strpro_id);
//	if (is_array($data)){
//		foreach ($data as $key => $val){
//			$pro = $pro_dao->getProBySpecId($val['id']);
//			foreach ($pro as $pk => $pval){
//				$pro_name[] = $pval['pro_name'];
//			} 
//			$data[$key]['pro_name'] =  implode(' ', $pro_name);
//		}
//	}
	$area_code = array();
	$office_number = array();
	$called_number = array();
	
	foreach ($data as $k => $v) {
		$tel = $v['tel'];
		$area_code[] = substr($tel,0,2);
		$office_number[] = substr($tel,2,4);
		$called_number[] = substr($tel,6,4);
	}

	$cell1 = array();
	$cell2 = array();
	$cell3 = array();
	foreach ($data as $k => $v) {
		$phone = $v['phone'];
		$cell1[] = substr($phone,0,2);
		$cell2[] = substr($phone,2,4);
		$cell3[] = substr($phone,6,4);
	}
	
}

if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $data ))
	$smarty->assign ( 'data', $data );
if (isset ( $page ))
	$smarty->assign ( 'page', $page );

//print_r(in_array(99,$forms['spec_area']));exit;
//print_r($forms['spec_area']);exit;
$smarty->assign('spec_areas',$forms['spec_area']);
$smarty->assign ( 'm_prego_pro', $m_prego_pro );
$smarty->assign ( 'introducer_fee', $prego_introducer_fee );
$smarty->assign ( 'introducer_fee_status', $prego_introducer_fee_status );
$smarty->assign ( 'login_fee', $prego_login_fee );
$smarty->assign ( 'hp_arr', $hp_arr );

$smarty->assign('area_code',$area_code);
$smarty->assign('office_number',$office_number);
$smarty->assign('called_number',$called_number);
$smarty->assign('cell1',$cell1);
$smarty->assign('cell2',$cell2);
$smarty->assign('cell3',$cell3);

$smarty->assign('spec_area',$prego_spec_area);

$smarty->assign ( 'auth', $auth );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->assign ( 'pageing', $smarty->fetch ( 'page.html' ) );
$smarty->display ( 'specialist_search.html' );
?>