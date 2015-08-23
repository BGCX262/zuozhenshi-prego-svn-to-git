<?php
require_once ('../system/smarty.inc');
require_once ('../system/login.inc.php');
require_once ('../system/prego_m.php');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_promise.php');
require_once ('../system/mdao/Class_mp_spec_profile.php');
require_once ('../system/mdao/Class_mp_spec_fee.php');
require_once ('../system/mdao/Class_mp_spec_traffic_fee.php');
require_once ('../system/mdao/Class_mp_corporate.php');
require_once ('../system/mdao/Class_mp_request.php');
require_once ('../system/mdao/Class_mp_request_add.php');

$promise_spec_dao = new Class_mp_promise_spec ();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	if (isset ( $_GET ['corporate_id'] ) && ! empty ( $_GET ['corporate_id'] ) && isset ( $_GET ['request_time'] ) && ! empty ( $_GET ['request_time'] )) {
		
		$hidden_request_time = $_GET['request_time'];
		$hidden_corporate_id = $_GET['corporate_id'];
		$hidden_request_status = $_GET['request_status'];
		$hidden_promise_id = $_GET['promise_id'];
		
		// get request_time
		$request_time = $_GET ['request_time'];
		// get corporate_id
		$corporate_id = $_GET ['corporate_id'];
		$request_id  = $_GET ['id'];
			
		$u_time_temp = strtotime($request_time.'-01');
		
		$timeNowYM = date('Y-m',$u_time_temp);
		$dateNowYM = date('Y年m月',$u_time_temp);
	
		
		// get corporate_name by corporate_id
		//$corporate_data = $corporate_dao->get ( $corporate_id );
		// get corporate_name
		//$corporate_name = $corporate_data ['corporate_name'];
		// get corporate_data
		$sql = sprintf ( "select * from mp_corporate where id = '%s'", $corporate_id );
		$corporate_forms = $promise_spec_dao->get_rows ( $sql );
		//select * from mp_request where corporate_id = '35'
		//select * from mp_request_add where request_id = '9' 

		$sql = " SELECT * FROM `mp_request` where  corporate_id = '$corporate_id' AND request_time= '$timeNowYM'";
		$nowrequestment =  $promise_spec_dao->get_row($sql);
		$requestment_id  = $nowrequestment["id"];
		
		$tmp_date=date("Ym",$u_time_temp);   
    
    	$tmp_year = substr($tmp_date,0,4);   
    	$tmp_mon  = substr($tmp_date,4,2);   
  
    	$tmp_forwardmonth = mktime(0,0,0,$tmp_mon-1,1,$tmp_year);   
		$timeYM           = date("Y-m", $tmp_forwardmonth);  
		
		
			$sql = "select a.*,b.promise_name,c.spec_fee,c.servers_fee,d.memo as cmemo  from mp_promise_spec a  " .
				" inner join  mp_promise b  on b.id = a.promise_id  " .
				" inner join  mp_spec_fee c  on c.spec_id = a.spec_id and  c.service_id  = a.service_id  " .
				" inner join  mp_service  d  on d.id =  a.service_id  " .
				" where  a.status = '3' and b.corporate_id = '$corporate_id' and a.doing_time like '$timeYM%'" .
				" order by a.doing_time ";
				
		$promise_rows = $promise_spec_dao->get_rows($sql);
	
		
		//print_r($promise_rows);
		
		// get payment_add by pay_id
		/*$sql = "select * from mp_request_add where request_id = '$request_id' ";
		$request_add_data = $request_add_dao->get_rows($sql);
		$other_num = 0;
		foreach ($request_add_data as $k => $v) {
			$other_num = $other_num + $v['money'];
		}
		*/
		$sql = "select * from mp_request_add where request_id = '$requestment_id' ";
		//echo '*******$request_id******';
		
		$request_add_data = $promise_spec_dao->get_rows($sql);
		$other_num        = 0;
		foreach ($request_add_data as $k => $v) {
			$other_num = $other_num + $v['money']; 
			
		}
		$before_tax  = 0;
		$race        = $nowrequestment["rate"];
		$tax         = 0;
		$after_tax   = 0;
		$traffic_fee = 0;
		$all_num     = 0;
		
		foreach ($promise_rows as $k => $v) {
			$before_tax = $before_tax + $v["spec_fee"];
			$traffic_fee = $traffic_fee + $v['other_fee'] + $v['traffic_fee'] + $v['live_fee'] + $v['overtime_fee'];
		}
		// get tax
		$tax = $before_tax * $race;
		// get after_tax
		$after_tax = $before_tax + $tax;
		
		// get all_num
		$all_num = $after_tax + $traffic_fee + $other_num;
		
		//---------------------------------------------------------------------------------------------
		//$date = date ( "Y年m月d日" ,time());
		$date = $pay_time = date ( "Y年m月d日", strtotime("-1 day", $u_time_temp) );
		
		$formsum = array();
		$formsum["A"] = "A" ;
		$formsum["ALL"] = "A + B + C" ;
		
		//
		/*
		if ( empty($traffic_fee) && empty($other_num) ){
			$formsum["A"] = "";
			$formsum["ALL"] ="";
		}elseif(empty($other_num)) {
			$formsum["ALL"] ="A + B";
			
		}elseif (empty($traffic_fee)){
			$formsum["ALL"] ="A + C";
		}
		$formsum["ALL"] = "A + B + C" ;
		*/
		/*
		// get corporate_name by corporate_id
		$corporate_data = $corporate_dao->get ( $corporate_id );
		// get corporate_name
		$corporate_name = $corporate_data ['corporate_name'];
		// get corporate_data
		$sql = sprintf ( "select * from mp_corporate where corporate_name = '%s'", $corporate_name );
		$corporate_forms = $corporate_dao->get_rows ( $sql );
		
		// get promise info by corporate_name
		// set query sql
		$sql = "select * from mp_promise where corporate_id = '$corporate_id'";
		// get promise_data by corporate_name , exist 1,2,3..or more promise
		$promise_data = $promise_dao->get_rows ( $sql );
		
		// define before_tax,tax,after_tax
		$before_tax = 0;
		$race = 0.05;
		$tax = 0;
		$after_tax = 0;
		$traffic_fee = 0;
		$all_num = 0;
		// define array
		$forms ['mutirow'] = array();
		
		$promise_spec_data = array();
		// foreach promise_data
		foreach ( $promise_data as $k => $v ) {
			
			// get promise spec info condition: 1.promise_id 2.status='3'
			// 3.u_time like '$request_time'
			// set promise_id
			$promise_id = $v ['id'];
			// set status
			$status = '3';
			
			
			// set u_time
			$u_time_temp = time($request_time)-60*24*30;
			$u_time = date('Y-m',$u_time_temp);
			
			// set sql
			$sql = "select * from mp_promise_spec where promise_id = '$promise_id' and status = '3' and u_time like '$u_time%'";
			// query data with condition
			$promise_spec_forms = $promise_spec_dao->get_rows ( $sql );
			
			// get spec_fee and service_fee
			foreach ( $promise_spec_forms as $kk => $vv ) {
				
				$promise_spec_data[] = $vv;
				
				// get spec_id and servers_name
				$servers_name = $vv ['service_name'];
				$profile_id = $vv ['profile_id'];
				$profile_forms = $spec_profile_dao->get ( $profile_id );
				$profile_name = $profile_forms ['profile_name'];
				$spec_id = $profile_forms ['spec_id'];
				
				// get spec_fee and servers_fee
				$sql = sprintf ( "select * from mp_spec_fee where spec_id = '%s' and servers_menu = '%s'", $spec_id, $servers_name );
				$spec_fee_arr = $spec_fee_dao->get_rows ( $sql );
				foreach ( $spec_fee_arr as $kkk => $vvv ) {
					
					$forms ['mutirow'] [] = array (
							"promise_id" => $promise_id,
							"profile_id" => $profile_id,
							"spec_fee" => $vvv ['spec_fee'],
							"servers_fee" => $vvv ['servers_fee'] 
					);
				}
				
				$traffic_fee = $traffic_fee + $vv['other_fee']+$vv['traffic_fee']+$vv['live_fee'];
				
			}
		}
		
		// get corporate_id
		$corporate_id = $_GET['corporate_id'];
		
		$sql = "select * from mp_request where corporate_id = '$corporate_id'";
		$request_data = $request_dao->get_rows($sql);
		foreach ($request_data as $k => $v) {
			$request_id = $v['id'];
		}
		
		// get payment_add by pay_id
		$sql = "select * from mp_request_add where request_id = '$request_id' ";
		$request_add_data = $request_add_dao->get_rows($sql);
		$other_num = 0;
		foreach ($request_add_data as $k => $v) {
			$other_num = $other_num + $v['money'];
		}
		
		// get all fee of each promise
		foreach ( $forms ['mutirow'] as $kk => $vv ) {
			$before_tax = $before_tax + $vv ['servers_fee'];
		}
		
		// get tax
		$tax = $before_tax * $race;
		// get after_tax
		$after_tax = $before_tax + $tax;
		// get all_num
		$all_num = $after_tax + $traffic_fee + $other_num;
		
		$date = date ( "Y年m月d日" ,time()-3600*24*30);
		*/
	}
}
/*
if (isset ( $promise_data ))
	$smarty->assign ( 'promise_data', $promise_data )
	if (isset ( $promise_spec_data ))
	$smarty->assign ( 'promise_spec_data', $promise_spec_data );

if (isset ( $forms ['mutirow'] ))
	$smarty->assign ( 'fee', $forms ['mutirow'] );
*/
if (isset ( $corporate_forms ))
	$smarty->assign ( 'corporate_forms', $corporate_forms );

if (isset ( $formsum )) $smarty->assign ( 'formsum', $formsum );

if (isset ( $request_add_data ))
	$smarty->assign ( 'request_add_data', $request_add_data );
	
$smarty->assign ( 'before_tax', $before_tax );
$smarty->assign ( 'tax', $tax );
$smarty->assign ( 'after_tax', $after_tax );
$smarty->assign ( 'traffic_fee', $traffic_fee );
$smarty->assign ( 'other_num', $other_num );
$smarty->assign ( 'all_num', $all_num );
$smarty->assign ( 'date_now_ym', $dateNowYM );

$smarty->assign ( 'date', $date );


$smarty->assign ( 'hidden_corporate_id', $hidden_corporate_id );
$smarty->assign ( 'hidden_request_time', $hidden_request_time );
$smarty->assign ( 'hidden_request_status', $hidden_request_status );
$smarty->assign ( 'hidden_promise_id', $hidden_promise_id );
$smarty->assign ( 'hidden_request_id', $request_id );


 $smarty->assign ( 'promise_rows', $promise_rows );

$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'bill_refer.html' )
?>