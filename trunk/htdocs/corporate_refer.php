<?php
require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');
require_once ('../system/prego_m.php');
require_once ('../system/login.inc.php');
require_once ('../system/mdao/Class_mp_corporate.php');
require_once ('../system/mdao/Class_mp_corporate_tantou.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/mdao/Class_mp_pro.php');

$corporate_dao = new Class_mp_corporate ();
$corporate_tantou_dao = new Class_mp_corporate_tantou ();
$account_dao = new Class_mp_account ();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	
	if($auth == '2'){
		
		$account_id = $_SESSION ['PREGO_ADMIN'] ['STAFF_SEQ'];
		$account_data = $account_dao->get ( $account_id );
		$id = $account_data ['other_id'];
		
	}elseif($auth == '1'){
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
			$id = $_GET['id'];
			$account_data = $account_dao->getByOtherid ( $id , 2);
		}
	}
	$smarty->assign ( 'account_name', $account_data['user_name'] );

	// get corporate_forms by id
	$corporate_forms = $corporate_dao->get ( $id );
	
	$post_code = split('-',$corporate_forms['post_code']);
	$region = $post_code[0];
	$branch = $post_code[1];
	
	$tel = split('-',$corporate_forms['tel']);
	$area_code = $tel[0];
	$office_number = $tel[1];
	$called_number = $tel[2];
	
	$order = array("\r\n","\n","\r");
	$replace = "<br/>";
	$corporate_forms['memo'] = str_replace($order,$replace,$corporate_forms['memo']);
	
	// get tantou_forms
	$sql = sprintf ( "select * from mp_corporate_tantou where corporate_id = '%s'", mysql_real_escape_string ( $id ) );
	$corporate_tantou_forms = $corporate_tantou_dao->get_rows ( $sql );
	
	$forms ['id'] = $id;
	
}

if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $corporate_forms ))
	$smarty->assign ( 'corporate_forms', $corporate_forms );
if (isset ( $corporate_tantou_forms ))
	$smarty->assign ( 'corporate_tantou_forms', $corporate_tantou_forms );

$smarty->assign('region', $region);
$smarty->assign('branch', $branch);
$smarty->assign('area_code', $area_code);
$smarty->assign('office_number', $office_number);
$smarty->assign('called_number', $called_number);


$smarty->assign ( 'auth', $auth );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'corporate_refer.html' );

?>

