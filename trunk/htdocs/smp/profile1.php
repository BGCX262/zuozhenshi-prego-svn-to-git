<?php
$smp_floder_flag = true;
require_once ('../../system/smarty.inc');
require_once( '../../system/mdao/Class_mp_spec_profile.php' );
require_once( '../../system/mdao/Class_mp_specialist.php' );


$spec_profile_dao = new Class_mp_spec_profile;
$spec_dao = new Class_mp_specialist;

//DBからデータを取ります
if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
	if( isset($_GET['id']) && $_GET['id'] != '' ){
		$profile_forms  = $spec_profile_dao->get( $_GET['id'] );
		$id=$profile_forms['spec_id'];
		$spec_forms = $spec_dao->get($id);
		$image = $profile_forms['image'];


		$bodytag = str_replace("./", "", $image);
		$new_image = $bodytag;
        $famous =  str_replace("\n", "</br>", $profile_forms['famous']);

        $address =  str_replace("\n", "</br>", $profile_forms['address']);

        $spec_name =  str_replace("\n", "</br>", $spec_forms['spec_name']);

        $interlingua =  str_replace("\n", "</br>", $spec_forms['interlingua']);

        $title =  str_replace("\n", "</br>", $profile_forms['title']);

        $summary =  str_replace("\n", "</br>", $profile_forms['summary']);

        $experience =  str_replace("\n", "</br>", $profile_forms['experience']);

        $qualifications =  str_replace("\n", "</br>", $profile_forms['qualifications']);

        $actual_result =  str_replace("\n", "</br>", $profile_forms['actual_result']);
	}
}

if( isset( $profile_forms ) ) $smarty->assign('profile_forms', $profile_forms);
if( isset( $spec_forms ) ) $smarty->assign('spec_forms', $spec_forms);
if( isset( $new_image ) ) $smarty->assign('image', $new_image);

//echo("</br></br></br></br></br></br></br></br></br></br>image=".$new_image);

$smarty->assign('famous',$famous);
$smarty->assign('address',$address);
$smarty->assign('spec_name',$spec_name);
$smarty->assign('interlingua',$interlingua);
$smarty->assign('summary',$summary);
$smarty->assign('title',$title);
$smarty->assign('experience',$experience);
$smarty->assign('qualifications',$qualifications);
$smarty->assign('actual_result',$actual_result);

$smarty->display('smp/profile1.html');

?>