<?php
require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');
require_once ('../system/prego_m.php');
require_once ('../system/login.inc.php');

$insertforms = $_SESSION['insertforms'];
$smarty->assign ( 'forms', $insertforms );
$smarty->assign ( 'insertforms', $insertforms );
$smarty->assign ( 'auth', $auth );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'corporate_insert.html' );

?>

