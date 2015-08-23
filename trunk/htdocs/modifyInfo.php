<?php

require_once( '../system/smarty.inc' );
require_once( '../system/Class_DB.php' );

// 要修改的数据
$id = $_POST['id'];
$login_id = $_POST['login_id'];
$login_pwd = $_POST['login_pwd'];
$user_name = $_POST['user_name'];
$login_flgs = $_POST['login_flgs'];
$sorts = $_POST['sorts'];

session_start();

$u_time = date("Y-m-d H:i:s");
$c_time = date("Y-m-d H:i:s");
$c_user = $_SESSION['ADMIN_LOGIN']['ID'];

$u_user = $c_user;

if (empty($login_flgs)) {
	$login_flgs = 0;
}
$db = new Class_DB;

if($_SESSION['dml'] == 1){
	$sql = "update mp_acount set user_name = '$user_name',login_id = '$login_id',login_pwd = '$login_pwd',login_flgs = '$login_flgs',sorts = '$sorts',u_time='$u_time',u_user='$u_user' where id = '$id'";
}else{
	$countsql= "select id from mp_acount";
	$db->query($countsql);
	$next = $db->num_rows()+1;
	$sql = "insert into mp_acount values($next,'$login_id','$login_pwd','$user_name','$sorts','$login_flgs','$u_time','$u_user','$c_time','$c_user')";	
}

$db->query($sql);

header('Location: account_list.php');
?>