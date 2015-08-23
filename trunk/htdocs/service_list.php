<?php

require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');
require_once ('../system/login.inc.php');
require_once ('../system/mdao/Class_mp_service.php');
require_once ('../system/prego_m.php');

session_name ( 'PREGO_ADMIN' );
session_start ();

$dao = new Class_mp_service ();

if (isset ( $_POST ['csv'] ) && ($_POST ['csv'] == "download") || isset ( $_POST ['hist'] ) && ($_POST ['hist'] == "2")) {
	$forms = $_SESSION ['MSEARCH'] ['service_list'];
} else {
	$forms = $_POST;
	$_SESSION ['MSEARCH'] ['service_list'] = $forms;
}

$wherearr = array ();
$page = array ();

if (isset ( $forms ['page'] ) && is_numeric ( $forms ['page'] )) {
	$page ['current'] = $forms ['page'];
} else {
	$page ['current'] = 1;
}
$page ['item'] = PAGE_MAX;

$data = $dao->search ( $wherearr, $page );

// キャプション、メモ
$caption_arr = array();
$memo_arr = array();
$order = array("\n");
$replace = "<br/>";

foreach ($data as $k => $v) {
	if($v['caption'] != ''){
		$caption_arr [$k] = str_replace($order,$replace,$v['caption']);
	}
	if($v['memo'] != ''){
		$memo_arr [$k] = str_replace($order,$replace,$v['memo']);
	}
}

if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $data ))
	$smarty->assign ( 'data', $data );
if (isset ( $page ))
	$smarty->assign ( 'page', $page );

$smarty->assign('caption_arr', $caption_arr);
$smarty->assign('memo_arr', $memo_arr);

$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->assign ( 'pageing', $smarty->fetch ( 'page.html' ) );
$smarty->display ( 'service_list.html' );
?>
