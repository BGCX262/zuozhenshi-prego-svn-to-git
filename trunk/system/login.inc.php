<?php
header("Cache-control: private");
require_once( '../system/loginauth.inc.php' );
session_name( 'PREGO_ADMIN' );
//session_cache_limiter(private_no_expire);
if (!isset($_SESSION)){
	session_cache_limiter('private, must-revalidate');
	session_start();
}
if( !isset($_SESSION['PREGO_ADMIN']['STAFF_ID']) ){
	header("Location: ./login.php");
	exit;
}
$login['autoid']     = $_SESSION['PREGO_ADMIN']['STAFF_SEQ'];
$login['staff_id']   = $_SESSION['PREGO_ADMIN']['STAFF_ID'];
$login['staff_name'] = $_SESSION['PREGO_ADMIN']['STAFF_NAME'];
$login['staff_auth'] = $_SESSION['PREGO_ADMIN']['STAFF_AUTH'];

$smarty->assign('login', $login );
$auth = $_SESSION['PREGO_ADMIN']['STAFF_AUTH'];
$prego_auth = $_SESSION['PREGO_ADMIN']['STAFF_AUTH_ARR'];

error_reporting(NULL);
ini_set("display_errors", 0);

$pregomenu=array(PREGO_ACCOUNT => array("name" => "アカウントデスク","class" => "icon_account" ,
				   "li" =>array(
				   	"account_list"  => array("name" => "アカウント検索"),
				   	"account_edit"   => array("name" => "アカウント登録")
				   )),
				PROGE_CORPORATE => array("name" => "クライアント様<br/>デスク","class" => "icon_corporate" ,
					"li" =>array(
					"corporate_unregistered"  => array("name" => "未登録一覧"),
					"corporate_search"   => array("name" => "クライアント検索"),
					"corporate_refer" => array("name" => "クライアント情報")
					)),
				PROGE_SPECIALIST => array("name" => "スペシャリスト<br/>デスク","class" => "icon_specialist" ,
					"li" =>array(
					"specialist_unregistered"  => array("name" => "未登録一覧"),
					"specialist_search"   => array("name" => "スペシャリスト検索"),
					"specialist_refer"	=> array("name" => "スペシャリスト情報")
					)),
				PROGE_OPPORTUNITY => array("name" => "約定デスク","class" => "icon_opportunity" ,
					"li" =>array(
					"opportunity_search"  => array("name" => $auth == 1? "案件検索":"案件情報" ),
					"opportunity_edit"   => array("name" => "案件登録")
					)),
				PROGE_BILL => array("name" => "請求デスク","class" => "icon_bill" ,
					"li" =>array(
					"bill_search"  => array("name" => "請求検索")
					)),
				PROGE_PAYMENT => array("name" => "支払デスク","class" => "icon_payment" ,
					"li" =>array(
					"payment_search"  => array("name" => "支払検索")
					)),
				PROGE_SERVICE => array("name" => "サービスマスタ","class" => "icon_service" ,
					"li" =>array(
					"service_list"  => array("name" => "一覧"),
					"service_edit"   => array("name" => "登録"),
					"service_category"   => array("name" => "カテゴリ")
					))
		);

		foreach ($pregomenu as $k =>$v) {
			if(isset($prego_auth[$k])){
				$pregomenu[$k]["auth"] = TRUE;
			}else{
				$pregomenu[$k]["auth"] = FALSE;
			}

			foreach ($v["li"] as $kk =>$vv) {
				if(isset($prego_auth[$kk])){
					$pregomenu[$k]["li"][$kk]["auth"] = TRUE;
				}else{
					$pregomenu[$k]["li"][$kk]["auth"] = FALSE;
				}
			}

		}

$smarty->assign( 'pregomenu', $pregomenu );


?>