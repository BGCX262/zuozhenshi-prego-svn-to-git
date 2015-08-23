<?php

require_once ('../system/smarty.inc');
require_once ('../system/mdao/Class_mp_service_category.php');
require_once ('../system/mdao/Class_mp_service.php');
require_once ('../system/mdao/Class_mp_spec_fee.php');

$category_dao = new Class_mp_service_category ();
$service_dao = new Class_mp_service ();
$spec_fee_dao = new Class_mp_spec_fee ();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	if (isset ( $_GET ['model'] ) && $_GET ['model'] != '') {
		
		$model = $_GET ['model'];
		$smarty->assign ( 'model', $model );
	}
	// else{
	// $spec_id = $_GET['spec_id'];
	// echo "spec_id".$spec_id;
	// $spec_fee_sql = "select * from mp_spec_fee where id = '$spec_id'";
	// $spec_data = $spec_fee_dao->get_rows($spec_fee_sql);
	
	// $wherearr = array();
	// $service_menu_arr = array();
	
	// foreach ($spec_data as $k => $v) {
	
	// $service_each_menu = $v['servers_menu'];
	
	// $service_menu_arr[] = "servers_menu = '$service_each_menu' ";
	// }
	
	// $where_service_menu = implode( ' OR ', $service_menu_arr);
	// $service_data = $service_dao->search($where_service_menu);
	// }
if(isset($_GET['sid']) && $_GET['sid'] != ''){
	
	$spec_id = $_GET['sid'];
	
	$sql = "select * from mp_spec_fee where spec_id = '$spec_id' ";
	$spec_data = $spec_fee_dao->get_rows($sql);
	
	$wherearr = array();
	$service_id_arr = array();
	
	foreach ($spec_data as $k => $v) {
		$service_each_id = $v['service_id'];
		$service_id_arr[] = "id = '$service_each_id' ";
	}
	$service_where = implode( ' OR ', $service_id_arr);
	$wherearr [] = "( $service_where )";
	$service_data = $service_dao->search($wherearr);
	
	$category_data = array();
	$category_id_temp = array();
	foreach ($service_data as $k=>$v) {
		if(!in_array($v['category_id'],$category_id_temp)){
			$category_id_temp[] = $v['category_id'];
			$category_id = $v['category_id'];
			$category_data[] = $category_dao->get($category_id);
		}
	}
	
}else{
	
	$service_sql = "select * from mp_service";
	$service_data = $service_dao->get_rows ( $service_sql );
	
	$category_sql = "select * from mp_service_category";
	$category_data = $category_dao->get_rows ( $category_sql );
}


}

$smarty->assign ( 'category_data', $category_data );
$smarty->assign ( 'service_data', $service_data );

$smarty->display ( 'popup_service_master.html' );
?>