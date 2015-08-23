<?php
require_once ('../system/smarty.inc');
require_once ('../system/mdao/Class_mp_corporate.php');
require_once ('../system/mdao/Class_mp_corporate_tantou.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/Class_DB.php');
require_once ('../system/login.inc.php');

$account_dao = new Class_mp_account ();
$corporate_dao = new Class_mp_corporate ();
$corporate_tantou_dao = new Class_mp_corporate_tantou ();

if ( isset( $_GET['csv'] ) &&  (  $_GET['csv'] == "download" ) ||
	 isset( $_GET['hist'] ) &&  (  $_GET['hist'] == "2" ) ) {

	$forms = $_SESSION ['MSEARCH'] ['corporate'];
} else {
	$forms = $_POST;

	$_SESSION ['MSEARCH'] ['corporate'] = $forms;
}

// define array
$wherearr = array ();
$where_search_arr = array ();
$where_corporate_tantou_arr = array ();
$$corporate_id_arr = array();
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

if ($auth == '2') {
	$dosearch = TRUE;
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$dosearch = TRUE;
}

if ($dosearch) {
	
	// if auth = 2
	if ($auth == '2') {
		
		// get corporate_id depands on login_id
		$login_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_ID'];
		$sql = "select * from mp_account where login_id = '$login_id' ";
		$account_data = $account_dao->get_rows ( $sql );
		foreach ( $account_data as $k => $v ) {
			$corporate_id = $v ['other_id'];
		}
		// set where condition
		$wherearr [] = "id = '$corporate_id' ";
		// if auth != 2
	} else {
		
		if(isset($_GET['id']) && $_GET['id'] != ''){
			
			$id = $_GET['id'];
			
			$wherearr [] = "id = '$id' ";
			
		}else {
			// get search condition from page
			$condition = $forms ['condition'];
			if (! empty ( $condition )) {
				// get corporate_id
				$where_corporate_tantou_arr [] = "tantou_name like '%$condition%'";
				$tantou_data = $corporate_tantou_dao->search ( $where_corporate_tantou_arr,$page );
				foreach ($tantou_data as $k => $v) {
					$corporate_id_arr[] = $v['corporate_id'];
				}
				foreach ($corporate_id_arr as $k => $v) {
					$where_search_arr [] = "a.id = '$v'";
				}
				
				// set where search condition
				if (! empty ( $corporate_id_arr )) {
					//$where_search_arr [] = "a.id = '$corporate_id'";
				}
				
				$where_search_arr [] = "a.corporate_name like '%$condition%'";
				$where_search_arr [] = "a.another_name like '%$condition%'";
				$where_search_arr [] = "a.address like '%$condition%'";
				$where_search_arr [] = "a.tel like '%$condition%'";
				$where_search_arr [] = "REPLACE(a.tel , '-', '') like '%$condition%'  ";
				$where_search_arr [] = "a.present like '%$condition%'";
				$where_search_arr [] = "b.user_name like '%$condition%'";
				
			}
			$where_corporate = implode ( ' OR ', $where_search_arr );
			if (! empty ( $where_corporate )) {
				$wherearr [] = "( $where_corporate )";
			}
		}
	}
	// $page内容は関数内部更新されます。
	$tantou_names = array();
	$data = $corporate_dao->search ( $wherearr, $page );
	if (is_array($data)){
		foreach ($data as $key=>$v){
			$sql = sprintf ( "select * from mp_corporate_tantou where corporate_id = '%s'", mysql_real_escape_string ( $v['id'] ) );
			$corporate_tantou_forms = $corporate_tantou_dao->get_rows ( $sql );
			$tantou_name = array();
			if ($corporate_tantou_forms) {
				foreach ($corporate_tantou_forms as $key=>$tv){
					$tantou_name[] = $tv['tantou_name'];
				}
			}
			$tantou_names[] = implode('/', $tantou_name);
		}
	}
	/**
	 * $sql = sprintf ( "select * from mp_corporate_tantou where corporate_id = '%s'", mysql_real_escape_string ( $id ) );
		$corporate_tantou_forms = $corporate_tantou_dao->get_rows ( $sql );
	 */
;
	
}

if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $data ))
	$smarty->assign ( 'data', $data );
if (isset ( $page ))
	$smarty->assign ( 'page', $page );
if (isset($tantou_names)) 
	$smarty->assign ( 'tantou_name', $tantou_names );


$smarty->assign ( 'auth', $auth );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->assign ( 'pageing', $smarty->fetch ( 'page.html' ) );
$smarty->display ( 'corporate_search.html' );
?>