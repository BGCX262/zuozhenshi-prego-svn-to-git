<?php
require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');
require_once ('../system/prego_m.php');
require_once ('../system/Class_ERROR.php');
require_once ('../system/login.inc.php');
require_once ('../system/mdao/Class_mp_spec_profile.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/mdao/Class_mp_spec_fee.php');

$spec_profile_dao = new Class_mp_spec_profile ();
$speclist_dao = new Class_mp_specialist ();
$spec_fee_dao = new Class_mp_spec_fee;

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
		$spec_profile_forms = $spec_profile_dao->get ( $_GET ['id'] );
		
		$spec_id = $spec_profile_forms ['spec_id'];
		
		$speclist_forms = $speclist_dao->get ( $spec_id );
		
		$image1 = $spec_profile_forms['image1'];
		$image2 = $spec_profile_forms['image2'];
		$image3 = $spec_profile_forms['image3'];
		$sql = "select * from mp_spec_fee where spec_id = '$spec_id' ";
		$spec_fee_data = $spec_fee_dao->get_rows($sql);
		
	}
}

$order = array("\n");
$replace = "<br/>";
$spec_profile_forms['summary'] = str_replace($order,$replace,$spec_profile_forms['summary']);
$spec_profile_forms['experience'] = str_replace($order,$replace,$spec_profile_forms['experience']);
$spec_profile_forms['qualifications'] = str_replace($order,$replace,$spec_profile_forms['qualifications']);
$spec_profile_forms['actual_result'] = str_replace($order,$replace,$spec_profile_forms['actual_result']);
$spec_profile_forms['famous'] = str_replace($order,$replace,$spec_profile_forms['famous']);

if (isset ( $spec_profile_forms ))
	$smarty->assign ( 'spec_profile_forms', $spec_profile_forms );
if (isset ( $speclist_forms ))
	$smarty->assign ( 'speclist_forms', $speclist_forms );
if (isset ( $spec_fee_data ))
	$smarty->assign ( 'spec_fee_data', $spec_fee_data );
if (isset ( $image1 ))
	$smarty->assign ( 'image1', $image1 );
if (isset ( $image2 ))
	$smarty->assign ( 'image2', $image2 );
if (isset ( $image3 ))
	$smarty->assign ( 'image3', $image3 );


$smarty->assign ( 'auth', $auth );
$smarty->display ( 'popup_specialist_profile1.html' );
?>