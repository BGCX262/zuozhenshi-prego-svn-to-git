<?php
require_once( '../../system/smarty.inc' );
require_once( '../../system/Class_DB.php' );
require_once( '../../system/loginauth.inc.php' );
require_once( '../../system/loginsmp.inc.php' );

$other_id = $_SESSION['PREGO_ADMIN']['OTHER_ID'];

$smarty->assign('id',$other_id);
$smarty->assign('other_id',$other_id);
$smarty->display('smp/index.html');
?>