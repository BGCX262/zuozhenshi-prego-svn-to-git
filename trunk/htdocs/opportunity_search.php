<?php

require_once ('../system/smarty.inc');
require_once ('../system/login.inc.php');
require_once ('../system/mdao/Class_mp_promise.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/mdao/Class_mp_corporate.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_specialist.php');

$promise_dao = new Class_mp_promise ();
$account_dao = new Class_mp_account ();
$corporate_dao = new Class_mp_corporate ();
$promise_spec_dao = new Class_mp_promise_spec ();
$spec_dao = new Class_mp_specialist ();

if (isset ( $_GET ['csv'] ) && ($_GET ['csv'] == "download") || isset ( $_GET ['hist'] ) && ($_GET ['hist'] == "2")) {

	$forms = $_SESSION ['MSEARCH'] ['opportunity'];
} else {
	$forms = $_POST;

	$_SESSION ['MSEARCH'] ['opportunity'] = $forms;
}

$wherearr = array ();
$where_search_arr = array ();
$promise_id_arr = array ();
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

if ($auth != '1') {
	$dosearch = TRUE;
}


if(isset($_GET['id']) && $_GET['id'] != ''){
	$dosearch = TRUE;
}


if ($dosearch) {
	
	if(isset($_GET['id']) && $_GET['id'] != ''){
		
		$id = $_GET['id'];
		
		$wherearr [] = "id = '$id' ";
		
		$data = $promise_dao->search ( $wherearr, $page ,null,null, "id desc");
	}else{
		if ($auth == '2') {
			
			$login_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_ID'];
			$sql = "select * from mp_account where login_id = '$login_id' ";
			$account_data = $account_dao->get_rows ( $sql );
			foreach ( $account_data as $k => $v ) {
				$corporate_id = $v ['other_id'];
			}
	
				//$corporate_data = $corporate_dao->get ( $corporate_id );
				//$corporate_name = $corporate_data ['corporate_name'];
				//if (! empty ( $corporate_name )) {
					$wherearr [] = "corporate_id = '$corporate_id' ";
				//}

		
			$data = $promise_dao->search ( $wherearr, $page ,null,null, "id desc");
		} else if ($auth == '3') {
			
			// get spec_name
			$user_name = $_SESSION ['PREGO_ADMIN'] ['STAFF_NAME'];
			/*
			if (! empty ( $user_name )) {
				$sql = "select * from mp_account where user_name = '$user_name'";
				$account_temp_data = $account_dao->get_rows ( $sql );
				foreach ( $account_temp_data as $k => $v ) {
					$spec_id = $v ['other_id'];
				}
				$spec_temp_data = $spec_dao->get ( $spec_id );
				$spec_name = $spec_temp_data ['spec_name'];
			}
			*/
			$login_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_ID'];
			$sql = "select * from mp_account where login_id = '$login_id' ";
			$account_data = $account_dao->get_rows ( $sql );
			//print_r($account_data);
			foreach ( $account_data as $k => $v ) {
				$spec_id = $v ['other_id'];
			}
				
			if (!empty($spec_id)){
				$sql = "select * from mp_promise_spec where spec_id = '$spec_id' group by promise_id ";
			}
			
			$promise_spec_data = $promise_spec_dao->get_rows($sql);
			foreach ($promise_spec_data as $k => $v) {
				$id = $v['promise_id'];
				$promise_id_arr[] = "id = '$id'";
			}
			$where_promise_id = implode ( ' OR ', $promise_id_arr );
			$wherearr [] = "( $where_promise_id )";
			
			$data = $promise_dao->search ( $wherearr, $page ,null,null, "id desc");
			
		} else if( $auth == '1' ){
			
			// doing_time condition
			$doing_time = $forms['doing_time'];
			
			if(!empty($doing_time)){
				$smarty->assign('doing_time', $doing_time);
				$sql = "select * from mp_promise_spec where doing_time like '$doing_time%' group by promise_id ";
				$promise_spec_data = $promise_spec_dao->get_rows($sql);
				foreach ($promise_spec_data as $k => $v) {
					$id = $v['promise_id'];
					$promise_id_arr[] = "id = '$id'";
				}
				
				$where_promise_id = implode ( ' OR ', $promise_id_arr );
				$wherearr [] = "( $where_promise_id )";
			}
			
			// free word condition
			$free_word = $forms ['free_word'];
			if (! empty ( $free_word )) {
				$where_search_arr [] = "corporate_name like '%$free_word%' ";
				$where_search_arr [] = "promise_name like '%$free_word%'";
			}
			$where_promise = implode ( ' OR ', $where_search_arr );
			if (! empty ( $where_promise )) {
				$wherearr [] = "( $where_promise )";
			}
		
			$data = $promise_dao->search ( $wherearr, $page ,null,null, "id desc" );
		}
	}
	
}

if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $data ))
	$smarty->assign ( 'data', $data );
if (isset ( $page ))
	$smarty->assign ( 'page', $page );

$smarty->assign ( 'auth', $auth );

$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->assign ( 'pageing', $smarty->fetch ( 'page.html' ) );
$smarty->display ( 'opportunity_search.html' );
?>