<?php
require_once ('../system/smarty.inc');
require_once ('../system/mdao/Class_mp_service_category.php');

$dao = new Class_mp_service_category ();

$sql = "select * from mp_service_category";

$data = $dao->get_rows ( $sql );

if (isset ( $data ))
	$smarty->assign ( 'data', $data );

$smarty->display ( 'popup_category_select.html' );
?>