<?php
require_once ('../system/smarty.inc');
require_once ('../system/login.inc.php');
require_once ('../system/prego_m.php');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_spec_fee.php');
require_once ('../system/mdao/Class_mp_promise.php');
require_once ('../system/mdao/Class_mp_spec_profile.php');
require_once ('../system/mdao/Class_mp_payment_add.php');
require_once ('../system/mdao/Class_mp_payment.php');

$spec_dao = new Class_mp_specialist;
$promise_spec_dao = new Class_mp_promise_spec;
//$spec_fee_dao = new Class_mp_spec_fee;
//$promise_dao = new Class_mp_promise;
//$spec_profile_dao = new Class_mp_spec_profile;
$payment_dao = new Class_mp_payment;
$payment_add_dao = new Class_mp_payment_add;

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	if (isset ( $_GET ['spec_id'] ) && ! empty ( $_GET ['spec_id'] )) {
		
		$hidden_pay_time = $_GET['pay_time'];
		$hidden_spec_id = $_GET['spec_id'];
		$hidden_pay_status = $_GET['pay_status'];
		$hidden_promise_spec_id = $_GET['id'];
		
		// get pay_time
		$pay_time = $_GET['pay_time'];
		// get spec_id
		$spec_id = $_GET['spec_id'];
		// get spec_data by spec_id
		$spec_data = $spec_dao->get($spec_id);
		// set promise_spec sql
		$spec_name = $spec_data['spec_name'];
		//--------------------------------------------------------------------------------------------
		// set u_time 
		
		$u_time_temp = strtotime($pay_time.'-01');
		
		$timeNowYM = date('Y-m',$u_time_temp);
		$dateNowYM = date('Y年m月',$u_time_temp);
	
		$sql = " SELECT * FROM `mp_payment` where  spec_id = '$spec_id' AND pay_time= '$timeNowYM'";
		$nowpayment =  $promise_spec_dao->get_row($sql);
		$payment_id  = $nowpayment["id"];
		
		$tmp_date=date("Ym",$u_time_temp);   
    
    	$tmp_year = substr($tmp_date,0,4);   
    	$tmp_mon  = substr($tmp_date,4,2);   
    	
    	//$tmp_nextmonth=mktime(0,0,0,$tmp_mon+1,1,$tmp_year);   
    	$tmp_forwardmonth = mktime(0,0,0,$tmp_mon-1,1,$tmp_year);   
		$timeYM           = date("Y-m", $tmp_forwardmonth);  
		
		$sql = "select a.*,b.promise_name,c.spec_fee,d.memo  as cmemo from mp_promise_spec a  " .
				" inner join  mp_promise b  on b.id = a.promise_id  " .
				" inner join  mp_spec_fee c  on c.spec_id = a.spec_id and  c.service_id  = a.service_id  " .
				" inner join  mp_service  d  on d.id =  a.service_id  " .
				" where  a.status = '3' and a.spec_id = '$spec_id' and a.doing_time like '$timeYM%'" .
				" order by a.doing_time ";
				
		$promise_rows = $promise_spec_dao->get_rows($sql);
		//print_r($promise_rows);
		
		// get payment_add by pay_id
		$sql = "select * from mp_payment_add where payment_id = '$payment_id' ";
		$payment_add_data = $payment_add_dao->get_rows($sql);
		$other_num        = 0;
		foreach ($payment_add_data as $k => $v) {
			$other_num = $other_num + $v['money']; 
			
		}
		$before_tax  = 0;
		$race        = $nowpayment["rate"];
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
	}
}

if (isset ( $promise_data )) $smarty->assign ( 'promise_data', $promise_data );
if (isset ( $promise_spec_data )) $smarty->assign ( 'promise_spec_data', $promise_spec_data );
if (isset ( $spec_name )) $smarty->assign ( 'spec_name', $spec_name );
if (isset ( $forms ['mutirow'] )) $smarty->assign ( 'fee', $forms ['mutirow'] );
if (isset ( $payment_add_data )) $smarty->assign ( 'payment_add_data', $payment_add_data );
if (isset ( $spec_data )) $smarty->assign ( 'spec_data', $spec_data );
if (isset ( $promise_rows )) $smarty->assign ( 'promise_rows', $promise_rows );

if (isset ( $formsum )) $smarty->assign ( 'formsum', $formsum );

$person_obj_text = "" ; 
if ($spec_data['person_choose'] == '1') {
	$person_obj_text = "(源泉対象)" ; 
}
$smarty->assign ( 'p_obj_text', $person_obj_text );

$smarty->assign ( 'before_tax', $before_tax );
$smarty->assign ( 'tax', $tax );
$smarty->assign ( 'after_tax', $after_tax );
$smarty->assign ( 'traffic_fee', $traffic_fee );
$smarty->assign ( 'other_num', $other_num );
$smarty->assign ( 'all_num', $all_num );
$smarty->assign ( 'date_now_ym', $dateNowYM );

$smarty->assign ( 'date', $date );

$smarty->assign ( 'prego_account_kinds', $prego_account_kinds );

$smarty->assign ( 'hidden_spec_id', $hidden_spec_id );
$smarty->assign ( 'hidden_pay_time', $hidden_pay_time );
$smarty->assign ( 'hidden_pay_status', $hidden_pay_status );
$smarty->assign ( 'hidden_promise_spec_id', $hidden_promise_spec_id );


$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'payment_refer.html' );
?>