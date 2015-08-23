<?php
require_once ('../system/smarty.inc');
require_once ('../system/prego_m.php');
require_once ('../system/login.inc.php');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_promise.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_spec_profile.php');
require_once ('../system/mdao/Class_mp_spec_fee.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/smtpsend.class.php');
require_once ('../system/mdao/Class_mp_promise_operation_history.php');

$promise_dao = new Class_mp_promise();
$promise_spec_dao = new Class_mp_promise_spec();
$spec_profile_dao = new Class_mp_spec_profile();
$spec_fee_dao = new Class_mp_spec_fee();
$account_dao = new Class_mp_account();
$spec_dao = new Class_mp_specialist();
$specialist_dao = new Class_mp_specialist();
$smtp_dao = new smtpclass();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset ($_GET['id']) && !empty ($_GET['id'])) {

		if (isset ($_GET['satisfy_status']) && $_GET['satisfy_status'] != '' && isset ($_GET['count_id']) && $_GET['count_id'] != '') {

			$id = $_GET['count_id'];
			$satisfy_status = $_GET['satisfy_status'];
			$values = array ();
			$values['satisfy_status'] = $satisfy_status;

			$promise_spec_dao->edit($id, $values);
			
			$operate_time = date ( 'y-m-d H:i:s', time () );
			$operate_details = "アンケート（回答）";
			$user_name = $_SESSION ['PREGO_ADMIN'] ['STAFF_NAME'];
			
			$operate_man = $user_name . "(" .$prego_account_sorts[$auth] . ")";

			$operate_history_val ['operate_time'] = $operate_time;
			$operate_history_val ['operate_details'] = $operate_details;
			$operate_history_val ['operate_man'] = $operate_man;
			
			
			$nowrow = $promise_spec_dao->get($id);
			$operate_history_val ['promise_spec_id'] = $id;
			$operate_history_val ['promise_id'] = $nowrow['promise_id'];
			$operate_history_val ['spec_id'] = $nowrow['spec_id'];
			$operate_history_val ['service_id'] = $nowrow['service_id'];
			$operation_history_dao = new Class_mp_promise_operation_history;
			
			// add data to operation_history
			if ($operation_history_dao->add0 ($operate_history_val )) {
			} else {
				$executeflg = FALSE;
				
			}
			$smarty->assign('thankanswer', 'anw'.$satisfy_status);
			//$smtp_dao->senduserMail("満足度アンケートメール","満足度アンケートメール送信");
		}

		if (isset ($_GET['pro_spec_id']) && $_GET['pro_spec_id'] != '') {

			$val = array ();
			$val['overtime_have'] = $_GET['overtime_have'];
			$val['overtime_fee'] = $_GET['overtime_fee'];
			$val['traffic_fee_have'] = $_GET['traffic_fee_have'];
			$val['traffic_fee'] = $_GET['traffic_fee'];
			$val['traffic_fee_detail'] = $_GET['traffic_fee_detail'];
			$val['live_fee_have'] = $_GET['live_fee_have'];
			$val['live_fee'] = $_GET['live_fee'];
			$val['live_fee_detail'] = $_GET['live_fee_detail'];
			$val['other_fee_have'] = $_GET['other_fee_have'];
			$val['other_fee'] = $_GET['other_fee'];
			$val['other_fee_name'] = $_GET['other_fee_name'];
			$val['other_fee_detail'] = $_GET['other_fee_detail'];

			$promise_spec_dao->edit($_GET['pro_spec_id'], $val);
		}

		$promise_forms = $promise_dao->get($_GET['id']);
		$promise_id = $_GET['id'];
		// if (isset ( $_GET ['promise_status'] ) && ! empty ( $_GET
		// ['promise_status'] )) {
		// $promise_status = $_GET ['promise_status'];
		// } else {
		// $promise_status = $promise_forms ['promise_status'];
		// }
		// specialist auth
		if ($auth == '3') {
			// get current auth account_id from session
			$id = $_SESSION['PREGO_ADMIN']['STAFF_SEQ'];
			$account_data = $account_dao->get($id);
			$other_id = $account_data['other_id'];
			// get spec_name from mp_spec by $other_id
			//$spec_data = $spec_dao->get($other_id);
			//$spec_name = $spec_data['spec_name'];
			// set query sql
			$sql = sprintf("select * from mp_promise_spec where promise_id = '%s' and spec_id = '%s' ", $promise_id, $other_id);
		} else {

			if (isset ($_GET['doing_time']) && $_GET['doing_time'] != '') {
				$doing_time = $_GET['doing_time'];
				// set query sql
				$sql = "select * from mp_promise_spec where promise_id = '$promise_id' and doing_time like '$doing_time%'";
			} else {
				// set query sql
				$sql = sprintf("select * from mp_promise_spec where promise_id = '%s' ", $promise_id);
			}
		}
		// get promise spec data
		$promise_spec_forms = $promise_spec_dao->get_rows($sql);
		// foreach promise spec data
		//print_r($promise_spec_forms);
		foreach ($promise_spec_forms as $k => $v) {
			// get each promise spec profile_id
			$profile_id = $v['profile_id'];
			// get profile data by profile_id
			$profile_forms = $spec_profile_dao->get($profile_id);
			// get profile_name
			$profile_name = $profile_forms['profile_name'];
			// get spec_id
			$spec_id = $profile_forms['spec_id'];
			$service_id = $v['service_id'];

			if (empty ($v['doing_time'])) {
				//$promise_spec_forms[$k]['day'] = "";
				//$promise_spec_forms[$k]['hour'] = "";
				//$promise_spec_forms[$k]['minute'] = "";
				$promise_spec_forms[$k]['datetime'] = "";
			} else {
				$nowdatetime = $v["doing_time"];
				$promise_spec_forms[$k]['dodate'] = substr($nowdatetime, 0, 10);
				$promise_spec_forms[$k]['dotime'] = substr($nowdatetime, 11, 2) . ":" . substr($nowdatetime, 14, 2);
				//$promise_spec_forms[$k]['day'] = substr($nowdatetime,0,10);
				//$promise_spec_forms[$k]['hour'] =  substr($nowdatetime,11,2);
				//$promise_spec_forms[$k]['minute'] =  substr($nowdatetime,14,2);
			}

			// set query condition
			$sql = sprintf("select * from mp_spec_fee where spec_id = '%s' and service_id = '%s'", $spec_id, $service_id);
			// get spec fee and service fee
			$spec_fee_arr = $spec_fee_dao->get_rows($sql);

			foreach ($spec_fee_arr as $kk => $vv) {

				$forms['mutirow'][] = array (

					"profile_id" => $profile_id,
					"status" => $promise_spec_forms['status'],
					"service_name" => $vv['servers_menu'],
					"profile_name" => $profile_name,
					"spec_fee" => $vv['spec_fee'],
					"servers_fee" => $vv['servers_fee']
				);
			}

			// $promise_spec_status ['mutirow'] [] = array (

			// "profile_id" => $profile_id,
			// "status" => $v ['status']
			// );
		}
	}
}

if (isset ($forms['mutirow']))
	$smarty->assign('fee', $forms['mutirow']);
// if (isset ( $promise_spec_status ['mutirow'] ))
// $smarty->assign ( 'status', $promise_spec_status ['mutirow'] );
if (isset ($promise_spec_forms))
	$smarty->assign('promise_spec_forms', $promise_spec_forms);
if (isset ($promise_forms))
	$smarty->assign('promise_forms', $promise_forms);

$smarty->assign('auth', $auth);

// $smarty->assign ( 'promise_status', $promise_status );

$smarty->assign('menu', $smarty->fetch('menu.html'));
$smarty->assign('footer', $smarty->fetch('footer.html'));
$smarty->assign('logout', $smarty->fetch('logout.html'));

$smarty->display('opportunity_refer.html');
?>