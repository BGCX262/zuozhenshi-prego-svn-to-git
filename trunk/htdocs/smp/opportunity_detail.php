<?php
$smp_floder_flag = true;
require_once( '../../system/smarty.inc' );
require_once( '../../system/mdao/Class_mp_promise.php' );
require_once( '../../system/mdao/Class_mp_promise_spec.php' );

$promise_dao = new Class_mp_promise;
$promise_spec_dao = new Class_mp_promise_spec;

//echo("</br></br></br></br></br></br></br></br>");

if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
	if( isset($_GET['id']) && $_GET['id'] != ''&& isset($_GET['status']) && $_GET['status'] !='' && isset($_GET['spec_id']) && $_GET['spec_id'] !=''){
		//基本情報
		$id = $_GET['id'];


		$status = $_GET['status'];
		$promise_forms = $promise_dao->get( $id );
		$spec_id = $_GET['spec_id'];

	//echo("spec_id = ".$spec_id);


		if ($status == '1'||$status == '2'){
			//サービス情報一覧
			$sql_promise_spec = "select * from mp_promise_spec where  "."  status <> '3' "." and  spec_id = '$spec_id' ";
			$promise_spec_forms = $promise_spec_dao->get_rows($sql_promise_spec);
		}else if ($status == '3'){
			//サービス情報一覧
			$sql_promise_spec = "select * from mp_promise_spec where promise_id = '$id' and status = '3' and  spec_id = '$spec_id' ";
			$promise_spec_forms = $promise_spec_dao->get_rows($sql_promise_spec);
		}

		$promise_s_1 = '発注確定';
		$promise_s_2 = '約定確定';
		$promise_s_3 = '業務完了';

	}
}

if( isset( $promise_forms ) ) $smarty->assign('promise_forms', $promise_forms);
if( isset( $promise_spec_forms ) ) $smarty->assign('promise_spec_forms', $promise_spec_forms);

        $promise_s_1 =  str_replace("\n", "</br>", $promise_s_1);
        $promise_s_2 =  str_replace("\n", "</br>", $promise_s_2);
        $promise_s_3 =  str_replace("\n", "</br>", $promise_s_3);

$smarty->assign('promise_s_1', $promise_s_1);
$smarty->assign('promise_s_2', $promise_s_2);
$smarty->assign('promise_s_3', $promise_s_3);
$smarty->display('smp/opportunity_detail.html');
?>