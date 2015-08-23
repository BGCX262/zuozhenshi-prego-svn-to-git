<?php
/*
require_once('C:\apache2\htdocs\prego\system/Smarty-2.6.26/libs/Smarty.class.php');

$smarty = new Smarty();

$smarty->template_dir = 'C:\apache2\htdocs\prego\templates/';
$smarty->compile_dir  = 'C:\apache2\htdocs\prego\system/templates_c/';
$smarty->config_dir   = 'C:\apache2\htdocs\prego\system/configs/';
$smarty->cache_dir    = 'C:\apache2\htdocs\prego\system/cache/';
*/

$REAL_DOCUMENT_ROOT =$_SERVER['DOCUMENT_ROOT'];

define('SMARTY_DIR',dirname(__FILE__).'/Smarty-2.6.26/libs/');

//echo $_SERVER['DOCUMENT_ROOT'].'/libs/Smarty-2.6.26/libs/';

require_once(SMARTY_DIR . 'Smarty.class.php');

$smarty = new Smarty();

//$smarty->default_modifiers = array('escape:"htmlall":"utf-8"');
$smarty->template_dir =dirname(__FILE__).'/../templates/';
$smarty->compile_dir  = dirname(__FILE__).'/templates_c/';
$smarty->config_dir   = dirname(__FILE__).'/configs/';
$smarty->cache_dir    =dirname(__FILE__). '/cache/';

$smarty->left_delimiter = '{{';
$smarty->right_delimiter = '}}';


?>
