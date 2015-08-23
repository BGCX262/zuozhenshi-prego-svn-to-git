<?php
require_once( '../system/smarty.inc' );
require_once( '../system/Class_DB.php' );
require_once( '../system/login.inc.php' );


$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display('index.html');
?>