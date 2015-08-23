<?php
$smp_floder_flag = true;
require_once( '../../system/smarty.inc' );

require_once( '../../system/mdao/Class_mp_specialist.php' );
require_once( '../../system/mdao/Class_mp_spec_fee.php' );

require_once( '../../system/mdao/Class_mp_spec_profile.php' );
require_once ('../../system/mdao/Class_mp_pro.php');

$spec_dao = new Class_mp_specialist;
$spec_fee_dao = new Class_mp_spec_fee;
$spec_profile_dao = new Class_mp_spec_profile;
$pro_dao = new Class_mp_pro();
//DBからデータを取ります

if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
	if( isset($_GET['id']) && $_GET['id'] != '' ){

		$spec_forms  = $spec_dao->get( $_GET['id'] );

		$id = $_GET['id'];
		//mp_spec_feeを検索するmp_spec_fee.spec_id = $id
		$sql_fee = sprintf("select * from mp_spec_fee where spec_id = '%s' ", $id);
		$fee_forms = $spec_fee_dao->get_rows($sql_fee);

		$sql_profile = sprintf("select * from mp_spec_profile where spec_id = '%s' ", $id);
		$profile_forms = $spec_profile_dao->get_rows($sql_profile);

		//分野の編集
		$prolist = $pro_dao->getProBySpecId($_GET ['id']);
		if (is_array($prolist)){
			foreach ($prolist as $pro){
				$pro_names [] = $pro['pro_name'];
			}
		}
		$spec_area = implode(',', $pro_names);
//		$spec_area_a ="";
//		$spec_area_b ="";
//		$spec_area_c ="";
//		$spec_area_else ="";
//		if($spec_forms['spec_area_a'] == 1){
//			$spec_area_a ="分野A"." ";
//		}
//		if($spec_forms['spec_area_b'] == 1){
//			$spec_area_b ="分野B"." ";
//		}
//		if($spec_forms['spec_area_c'] == 1){
//			$spec_area_c ="分野C"." ";
//		}
//		if($spec_forms['spec_area_d'] == 1){
//			$spec_area_else =$spec_forms['spec_area_else'];
//		}
//
//		$spec_area = $spec_area_a.$spec_area_b.$spec_area_c.$spec_area_else;


		//郵便番号の編集
		$post_code = $spec_forms['post_code'];
		//telの編集
		$tel = $spec_forms['tel'];
		//phoneの編集
		$phone = $spec_forms['phone'];
		//faxの編集
		$fax = $spec_forms['fax'];

	}

}

if( isset( $spec_forms ) ) $smarty->assign('spec_forms', $spec_forms);

if( isset( $fee_forms ) ) $smarty->assign('fee_forms', $fee_forms);

if( isset( $profile_forms ) ) $smarty->assign('profile_forms', $profile_forms);


$spec_area =  str_replace("\n", "</br>", $spec_area);
$post_code =  str_replace("\n", "</br>", $post_code);
$tel =  str_replace("\n", "</br>", $tel);
$phone =  str_replace("\n", "</br>", $phone);
$fax =  str_replace("\n", "</br>", $fax);

$smarty->assign('spec_area',$spec_area);
$smarty->assign('post_code', $post_code);
$smarty->assign('tel', $tel);
$smarty->assign('phone', $phone);
$smarty->assign('fax', $fax);
$smarty->display('smp/account.html');

?>