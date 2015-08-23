<?php
require_once ('../system/prego_m.php');
require_once ('../system/smarty.inc');
require_once ('../system/login.inc.php');

require_once ('../system/mdao/Class_mp_account.php');

// Class_PWD::valid_auth(AOKI_AUTH_ACCOUNT,$login['staff_auth']);
// $login_auth = $login['staff_auth'];
$dao = new Class_mp_account ();

	session_start ();
if ( isset( $_GET['csv'] ) &&  (  $_GET['csv'] == "download" ) ||
	 isset( $_GET['hist'] ) &&  (  $_GET['hist'] == "2" ) ) {

	$forms = $_SESSION ['MSEARCH'] ['account'];
} else {
	$forms = $_POST;
	
	$_SESSION ['MSEARCH'] ['account'] = $forms;
}

$wherearr = array ();
$where_sorts_arr = array ();
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

if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
	
	$dosearch = TRUE;
}

if ($dosearch) {
	
	if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
		
		$id = $_GET ['id'];
		
		$wherearr [] = "id = '$id'";
	} else {
		$user_name = $forms ['user_name'];
		if (! empty ( $user_name )) {
			$wherearr [] = " user_name like '%$user_name%' ";
		}
		$sorts = $forms ['sorts'];
		if (! empty ( $sorts )) {
			foreach ( $sorts as $kk => $vv ) {
				$where_sorts_arr [] = "sorts = '$vv'";
			}
		}
		
		$where_sorts = implode ( ' OR ', $where_sorts_arr );
		if (! empty ( $where_sorts )) {
			$wherearr [] = "( $where_sorts )";
		}
		
		$login_flgs = $forms ['login_flgs'];
		if (! empty ( $login_flgs )) {
			$wherearr [] = " login_flgs = '$login_flgs' ";
		}
	}
	
	// $page内容は関数内部更新されます。
	$data = $dao->search ( $wherearr, $page );
	

}
if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $data ))
	$smarty->assign ( 'data', $data );
if (isset ( $page ))
	$smarty->assign ( 'page', $page );
	

$smarty->assign ( 'sorts', $prego_account_sorts );
$smarty->assign ( 'login_flgs', $prego_login_flgs );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->assign ( 'pageing', $smarty->fetch ( 'page.html' ) );
$smarty->display ( 'account_list.html' );

?>