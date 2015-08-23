<?php
$smp_floder_flag = true;
require_once( '../../system/smarty.inc' );
require_once( '../../system/mdao/Class_mp_promise.php' );
require_once( '../../system/mdao/Class_mp_promise_spec.php' );

$promise_dao = new Class_mp_promise;
$promise_spec_dao = new Class_mp_promise_spec;

if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
	if( isset($_GET['id']) && $_GET['id'] != '' ){
		//スペシャリストID = 9
		//未完了復数案件検索
		$id = $_GET['id'];
        $other_id = $_GET['id'];

		$sql_promise_spec_on = sprintf("select distinct promise_id from mp_promise_spec where spec_id = '%s' and status<> '3' " , $id);

		$promise_spec_on_forms = $promise_spec_dao->get_rows($sql_promise_spec_on);

		$promise_on_forms = array();
		foreach($promise_spec_on_forms as $k => $v){
			$id = $v['promise_id'];
			$promise_on_forms[] = $promise_dao->get($id);

		}

		//完了復数案件検索
		$id = $_GET['id'];
		$sql_promise_spec_off = sprintf("select distinct promise_id from mp_promise_spec where spec_id = '%s' and status = '3' " , $id);
		$promise_spec_off_forms = $promise_spec_dao->get_rows($sql_promise_spec_off);


		$promise_off_forms = array();
		foreach($promise_spec_off_forms as $k => $vv){

			$id = $vv['promise_id'];
			$promise_off_forms[] = $promise_dao->get($id);
		}


	}
}

if( isset( $promise_on_forms ) ) $smarty->assign('promise_on_forms', $promise_on_forms);
if( isset( $promise_spec_on_forms ) ) $smarty->assign('promise_spec_on_forms', $promise_spec_on_forms);
if( isset( $promise_off_forms ) ) $smarty->assign('promise_off_forms', $promise_off_forms);
if( isset( $promise_spec_off_forms ) ) $smarty->assign('promise_spec_off_forms', $promise_spec_off_forms);


//$smarty->assign('spec_id', $id);
$smarty->assign('spec_id', $other_id);
$smarty->display('smp/opportunity.html');

?>