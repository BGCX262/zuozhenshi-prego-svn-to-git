<?php
/*
 * ＩＰアクセス制限 $IP = $_SERVER['REMOTE_ADDR']; $from = strcmp($IP,'192.168.0.0');
 * $to = strcmp($IP,'192.168.0.255'); if (!($from >= 0 && $to <= 0)) echo
 * "Access Denied"; else
 */
$url = mobile_redirect();
if (false !== $url) {
	header('Location: ' . $url);
	exit;
}
function mobile_redirect () {
 
	// 切り替え用URLです。falseにすれば対象を除外できます。
	$docomo = 'http://www.pregosystem.biz/smp/login.php';  // ドコモ
	$au     = 'http://www.pregosystem.biz/smp/login.php'; // au
	$sb     = 'http://www.pregosystem.biz/smp/login.php'; // SoftBank
	$sp     = 'http://www.pregosystem.biz/smp/login.php'; // スマートフォン
	$em     = 'http://www.pregosystem.biz/smp/login.php'; // 
	$willcom= 'http://www.pregosystem.biz/smp/login.php'; // 
	
	$mobile = false;  // モバイル端末
	$ua = $_SERVER['HTTP_USER_AGENT'];
	// ドコモ
	if (preg_match('/^DoCoMo/', $ua)) {
		$mobileredirect = $docomo;
	// au
	} elseif (preg_match('/^KDDI-|^UP\.Browser/',$ua)) {
		$mobileredirect = $au;
	// SoftBank
	} elseif (preg_match('#^J-(PHONE|EMULATOR)/|^(Vodafone/|MOT(EMULATOR)?-[CV]|SoftBank/|[VS]emulator/)#', $ua)) {
		$mobileredirect = $sb;
	// Willcom
	} elseif (preg_match('/(DDIPOCKET|WILLCOM);/', $ua)) {
		$mobileredirect = $willcom;
	// e-mobile
	} elseif (preg_match('#^(emobile|Huawei|IAC)/#', $ua)) {
		$mobileredirect = $em;
	// スマートフォン
	} elseif (preg_match('#\b(iP(hone|od);|Android )|dream|blackberry9500|blackberry9530|blackberry9520|blackberry9550|blackberry9800|CUPCAKE|webOS|incognito|webmate#', $ua)) {
		$mobileredirect = $sp;
	// モバイル端末
	} elseif (preg_match('#(^Nokia\w+|^BlackBerry[0-9a-z]+/|^SAMSUNG\b|Opera Mini|Opera Mobi|PalmOS\b|Windows CE\b)#', $ua)) {
		$mobileredirect = $mobile;
	// PC	
	} else {
		$mobileredirect = false;
	}
 
	return $mobileredirect;
 
}
require_once ('../system/smarty.inc');

require_once ('../system/Class_DB.php');
require_once ('../system/Class_ERROR.php');
require_once ('../system/Class_PWD.php');
require_once ('../system/loginauth.inc.php');


session_name ( 'PREGO_ADMIN' );
session_cache_limiter(private_no_expire);
session_start ();


$err = false;

if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	$forms = $_POST;
	
	// 看是否設置了cookie
	if(isset($_COOKIE['login_id']) && isset($_COOKIE['login_pass'])){
		//$id = $_COOKIE['login_id'];
		//$pass = $_COOKIE['login_pass'];
	}else{
		$id = $forms ['login_id'];
		$pass = $forms ['login_pass'];
	}
	
	$keep = $forms['keep_login'];
	if($forms['keep_login'] != ''){
		//setcookie("login_id",$id,time()+300);
		//setcookie("login_pass",$pass,time()+300);
		
	}
	
	$oerr = new Class_ERROR ( '', '' );
	// check login_id and login_pass
	$errchk = array (
			"EXIST" 
	);
	$err_mes ['login_id'] = $oerr->check ( $id, $errchk );
	$err_mes ['login_pass'] = $oerr->check ( $pass, $errchk );

	$msg_bg = '<p class="caution">';
	$msg_ed = '</p>';
	// login_id err
	if ($err_mes ['login_id']) {
		$err_msg = $msg_bg . "IDは" . $err_mes ['login_id'] . $msg_ed;
	}
	// login_pass err
	if ($err_mes ['login_pass']) {
		$passmsg = $msg_bg . "パスワードは" . $err_mes ['login_pass'] . $msg_ed;
		if ($err_msg) {
			$err_msg = $err_msg . $passmsg;
		} else {
			$err_msg = $passmsg;
		}
	}
	// login_id and login_pass ok
	if ($oerr->clear) {
		// get data by login_id and login_pwd
		$db = new Class_DB ();
		$sql = sprintf ( "SELECT * FROM mp_account WHERE login_id = '%s' AND login_pwd = '%s' ", mysql_real_escape_string ( $id ), mysql_real_escape_string ( Class_PWD::do_encode ( $pass ) ) );
		$db->query ( $sql );
		
		if ($db->num_rows ()) {
			$row = $db->fetch ();
			// ログイン不可
			if ($row ['login_flgs'] == '1') {
				$err_msg = '<p class="caution">ログインできません。管理者にお問い合わせください。</p>';
				$err = true;
				$db->close ();
			// ログイン可
			} else {
				// set auth and session
				session_name ( 'PREGO_ADMIN' );
				//session_cache_limiter(private_no_expire);
				session_start ();
				$auth = $row ['sorts'];
				$_SESSION ['PREGO_ADMIN'] ['STAFF_SEQ'] = $row ['id'];
				$_SESSION ['PREGO_ADMIN'] ['STAFF_ID'] = $row ['login_id'];
				$_SESSION ['PREGO_ADMIN'] ['STAFF_PWD'] = $row ['login_pwd'];
				$_SESSION ['PREGO_ADMIN'] ['STAFF_AUTH'] = $auth;
				$_SESSION ['PREGO_ADMIN'] ['STAFF_NAME'] = $row ['user_name'];
				$db->close ();
				// prego model auth
				$prego_menu_auth = array (
						
						PREGO_ACCOUNT 		=> array ( 1 ),
						PROGE_CORPORATE 	=> array ( 1, 2 ),
						PROGE_SPECIALIST 	=> array (	1, 3 ),
						PROGE_OPPORTUNITY 	=> array ( 1,	2, 3 ),
						PROGE_BILL 			=> array ( 1, 2 ),
						PROGE_PAYMENT 		=> array ( 1,	3 ),
						PROGE_SERVICE 		=> array ( 1 ) 
				);
				// 0 権限がある　1 権限がない
				$prego_file_auth = array (
						"account_list" 				=> array (0, 0, 1, 1 ),
						"account_edit" 				=> array (0, 0,	1, 1 ),
						"corporate_unregistered" 	=> array (0, 0,	1, 1 ),
						"corporate_search" 			=> array (0, 0,	1, 1 ),
						"corporate_refer"           => array (0, 1, 0, 1 ),
						"specialist_unregistered" 	=> array (0, 0,	1, 1 ),
						"specialist_search" 		=> array (0, 0, 1, 1 ),
						"specialist_refer"			=> array (0, 1, 1, 0 ),
						"opportunity_search" 		=> array (0, 0, 0, 0 ),
						"opportunity_edit" 			=> array (0, 0, 1, 1 ),
						"bill_search" 				=> array (0, 0, 0, 1 ),
						"payment_search" 			=> array (0, 0, 1, 0 ),
						"service_list" 				=> array (0, 0, 1, 1 ),
						"service_edit" 				=> array (0, 0, 1, 1 ),
						"service_category" 			=> array (0, 0, 1, 1 ) 
				);
				// define $prego_auth array
				$prego_auth = array ();
				// get model auth
				foreach ( $prego_menu_auth as $k => $v ) {
					if (in_array ( $auth, $v )) {
						$prego_auth [$k] = 1;
					}
				}
				// get model detail auth
				foreach ( $prego_file_auth as $k => $v ) {
					if ($v [$auth] == 0) {
						$prego_auth [$k] = 1;
					}
				}
				// set auth session
				$_SESSION ['PREGO_ADMIN'] ['STAFF_AUTH_ARR'] = $prego_auth;
				
				if (isset($_SESSION['jumpurl'])) {
					$jumpurl = $_SESSION['jumpurl'];
					unset($_SESSION['jumpurl']);
					$profile1 = 'popup/specialist_profile1.php';
					$profile2 = 'popup/specialist_profile2.php';
					if (strpos($jumpurl,$profile1)||strpos($jumpurl,$profile2)) {
						header ( "Location: ".$jumpurl );
						exit ();
					}
				}
				header ( "Location: ./index.php" );
				exit ();
			}
		} else {
			$err_msg = '<p class="caution">IDまたはパスワードが間違っています</p>';
			$err = true;
			$db->close ();
		}
	} else {
		
		$err = true;
	}
	
	$err = true;
}

if(isset($_COOKIE['login_id']) && isset($_COOKIE['login_pass'])){
	$smarty->assign('cooki_login_id', $_COOKIE['login_id']);
	$smarty->assign('cooki_login_pass', $_COOKIE['login_pass']);
}


if (isset ( $forms )) {
	$smarty->assign ( 'forms', $forms );
}

$smarty->assign ( 'err', $err );
if (isset ( $err_msg )) {
	$smarty->assign ( 'err_msg', $err_msg );
}

$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );

$smarty->display ( 'login.html' );




?>