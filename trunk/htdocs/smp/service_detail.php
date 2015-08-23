<?php
$smp_floder_flag = true;
require_once( '../../system/smarty.inc' );
require_once( '../../system/mdao/Class_mp_promise_spec.php' );
require_once( '../../system/mdao/Class_mp_spec_profile.php' );
require_once( '../../system/mdao/Class_mp_service.php' );
require_once( '../../system/prego_m.php' );
require_once( '../../system/mdao/Class_mp_promise_operation_history.php' );

session_name('PREGO_ADMIN');
session_start();

$promise_spec_dao = new Class_mp_promise_spec;
$spec_profile_dao = new Class_mp_spec_profile;
$service_dao = new Class_mp_service;
$operation_history_dao = new Class_mp_promise_operation_history;

if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
	if( isset($_GET['id']) && $_GET['id'] != '' ){

		if( isset($_GET['u_id']) && $_GET['u_id'] != '' ){

			//mp_promise_spec の id
			$id = $_GET['id'];
			$promise_spec_forms = $promise_spec_dao->get($id);
			$arr =  array();
			$arr['status'] = 2;
			$promise_spec_dao->edit($id,$arr);

			// add operate_data
			$operate_time = date ( 'y-m-d H:i:s', time () );
			$promise_id = $promise_spec_forms['promise_id'];
			$operate_details = "受注確定（約定確定）";
			$user_name = $_SESSION ['PREGO_ADMIN'] ['STAFF_NAME'];
			$operate_man = $user_name . "(スペシャリスト)";

			$operate_history_val ['operate_time'] = $operate_time;
			$operate_history_val ['operate_details'] = $operate_details;
			$operate_history_val ['operate_man'] = $operate_man;
			$operate_history_val ['promise_id'] = $promise_id;
			// add data to operation_history
			$operation_history_dao->add0 ( $operate_history_val );
			// add oprerate_data end


			$promise_spec_forms = $promise_spec_dao->get($id);

			$id = $promise_spec_forms['profile_id'];
			$spec_profile_forms = $spec_profile_dao->get($id);
			$profile_id = $spec_profile_forms['id'];

			$id = $promise_spec_forms['service_id'];
			$service_forms = $service_dao->get($id);
			//約定s,完了F,CF
			if( $promise_spec_forms['status'] == 1 ){
				$promise_s = '発注確定';
				$over_f = '-';
				$cf ='-';
			}else if( $promise_spec_forms['status'] == 2 ){
				$promise_s = '約定確定';
				$over_f = '-';
				$cf ='-';
			}else if( $promise_spec_forms['status'] == 3 ){
				$promise_s = '業務完了';
				$over_f = '〇';
				$cf ='-';
			}
			//アンケートの編集
			if ($promise_spec_forms['satisfy_status'] = '02'){
				$satisfy_status = "満足した";
			}else if($promise_spec_forms['satisfy_status'] = '01'){
				$satisfy_status = "不満足";
			}else if($promise_spec_forms['satisfy_status'] = '00'){
				$satisfy_status = "どちらでもない";
			}

		}else{

			//mp_promise_spec の id
			$id = $_GET['id'];
			$promise_spec_forms = $promise_spec_dao->get($id);
			$id = $promise_spec_forms['profile_id'];
			$spec_profile_forms = $spec_profile_dao->get($id);
			$profile_id = $spec_profile_forms['id'];

			$id = $promise_spec_forms['service_id'];
			$service_forms = $service_dao->get($id);
			//約定s,完了F,CF
			if( $promise_spec_forms['status'] == 1 ){
				$promise_s = '発注確定';
				$over_f = '-';
				$cf ='-';
			}else if( $promise_spec_forms['status'] == 2 ){
				$promise_s = '約定確定';
				$over_f = '-';
				$cf ='-';
			}else if( $promise_spec_forms['status'] == 3 ){
				$promise_s = '業務完了';
				$over_f = '〇';
				$cf ='-';
			}
				//アンケートの編集
			if ($promise_spec_forms['satisfy_status'] = '00'){
				$satisfy_status = "満足した";
			}else if($promise_spec_forms['satisfy_status'] = '01'){
				$satisfy_status = "不満足";
			}else if($promise_spec_forms['satisfy_status'] = '02'){
				$satisfy_status = "どちらでもない";
			}
		}

		$service_id = $_GET[id];
	}
}

if( isset( $promise_spec_forms ) ) $smarty->assign('promise_spec_forms', $promise_spec_forms);
if( isset( $spec_profile_forms ) ) $smarty->assign('spec_profile_forms', $spec_profile_forms);
if( isset( $service_forms ) ) $smarty->assign('service_forms', $service_forms);


 $satisfy_status =  str_replace("\n", "</br>", $satisfy_status);
 $promise_s =  str_replace("\n", "</br>", $promise_s);
 $over_f =  str_replace("\n", "</br>", $over_f);
 $cf =  str_replace("\n", "</br>", $cf);



$smarty->assign('id', $profile_id);
$smarty->assign('satisfy_status', $satisfy_status);
$smarty->assign('promise_s', $promise_s);
$smarty->assign('over_f', $over_f);
$smarty->assign('cf', $cf);
$smarty->assign('service_id', $service_id);

$smarty->display('smp/service_detail.html');
?>