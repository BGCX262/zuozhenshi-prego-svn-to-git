<?php
$smp_floder_flag = true; 
require_once( '../../system/smarty.inc' );
require_once( '../../system/Class_DB.php' );
require_once( '../../system/Class_ERROR.php' );
require_once( '../../system/Class_PWD.php' );
require_once( '../../system/loginauth.inc.php' );

session_name('PREGO_ADMIN');
session_start();


$err = false;

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
	$forms = $_POST;
	
	$id = $forms['email']; 
	
	
	$pass = $forms['login_pass'];
	$oerr = new Class_ERROR('','');

	$errchk =  array( "EXIST" ,"ALNUM" );

	
	$err_mes['login_id']	= $oerr->check( $id, $errchk );
	
	$err_mes['login_pass']	= $oerr->check( $pass, $errchk );
	
	$msg_bg =  '<p class="caution">';
	$msg_ed =  '</p>';
	if ($err_mes['login_id']){
		$err_msg =$msg_bg."IDは".$err_mes['login_id'].$msg_ed;
	}
	
	if ($err_mes['login_pass']){
		$passmsg = $msg_bg."パスワードは".$err_mes['login_pass'].$msg_ed;
		if ($err_msg) {
			$err_msg = $err_msg.$passmsg;
		} else {
			$err_msg = $passmsg;
		}
		
	}

	if(  $oerr->clear ){
		

		$db = new Class_DB;
        //権限スペシャリスト可登録
		//AND sorts = '3'
		$sql = sprintf("SELECT * FROM mp_account WHERE login_id = '%s' AND login_pwd = '%s' AND sorts = '3' AND login_flgs = '0'",
			mysql_real_escape_string( $id ),
			mysql_real_escape_string( Class_PWD::do_encode($pass) )
		);
		
		$db->query( $sql );

		if( $db->num_rows() ){
			$row = $db->fetch();

			//other_id
			$_SESSION['PREGO_ADMIN']['OTHER_ID']=$row['other_id'];
			$_SESSION['PREGO_ADMIN']['STAFF_SEQ'] = $row['id'];
			$_SESSION['PREGO_ADMIN']['STAFF_NAME'] = $row ['user_name'];
			$_SESSION['PREGO_ADMIN']['STAFF_AUTH']=$row['sorts'];
					
			$db->close();
			header("Location: ./index.php");
			exit;
		}else{
			
			$err_msg = '<p class="caution">IDまたはパスワードが間違っています</p>';
			$err = true;
			$db->close();
		}

	}else{

		$err = true;
	}
	
$err = true;
}

if( isset( $forms ) ) {
	$smarty->assign('forms', $forms );
}
$smarty->assign('err', $err );
if( isset( $err_msg ) ){
	$smarty->assign('err_msg', $err_msg );
}
//$smarty->assign('footer', $smarty->fetch('footer.html') );
$smarty->display('smp/login.html');
?>