<?php
require_once ('../../system/prego_m.php');
require_once ('../../system/smarty.inc');
require_once ('../../system/mdao/Class_mp_specialist_profile.php');
require_once ('../../system/mdao/Class_smp_spec_fee.php');
$spec_profile_dao = new Class_mp_specialist_profile ();
$spec_fee_dao = new Class_smp_spec_fee;
$profile_id = $_GET ['ID'];
if ($profile_id) {
	$jumpurl =  'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
	if (!$_SESSION){
		session_name ( 'PREGO_ADMIN' );
		session_start ();
		$_SESSION['jumpurl'] = $jumpurl;
		if( !isset($_SESSION['PREGO_ADMIN']['STAFF_ID']) ){
			header("Location: ../login.php");
			exit;
		}
	}
}
$sql = $sql = "select* from mp_spec,mp_spec_profile   where mp_spec_profile.spec_id = mp_spec.id and      mp_spec_profile.have_profile_url ='$profile_id'";
$spec_data = $spec_profile_dao->get_rows($sql);



        $auth = $_SESSION ['PREGO_ADMIN']['STAFF_AUTH'];


	foreach ($spec_data as $k => $v) {
		$have_profile_url =  str_replace("\n", "</br>", $v ['have_profile_url']);
		$spec_name = str_replace("\n", "</br>", $v ['spec_name']);
		$interlingua= str_replace("\n", "</br>", $v['interlingua']);
		$title = str_replace("\n", "</br>", $v['title']);
		$summary = str_replace("\n", "</br>", $v['summary']);
		$birthday=str_replace("\n", "</br>", $v['birthday']);
		$address = str_replace("\n", "</br>", $v['address']);
		$image1 =str_replace("\n", "</br>", $v['image1']);
		$image2 =str_replace("\n", "</br>", $v['image2']);
		$image3 =str_replace("\n", "</br>", $v['image3']);
		$experience = str_replace("\n", "</br>", $v['experience']);
		$qualifications = str_replace("\n", "</br>", $v['qualifications']);
		$actual_result = str_replace("\n", "</br>", $v['actual_result']);
		$famous = str_replace("\n", "</br>", $v['famous'] );
		$cartoon_url = str_replace("\n", "</br>", $v['cartoon_url']);
		$fee_message_a = str_replace("\n", "</br>", $v['fee_message_a']);
		$fee_message_b = str_replace("\n", "</br>", $v['fee_message_b']);
		$fee_message_c = str_replace("\n", "</br>", $v['fee_message_c']);
		$spec_id =  $v['spec_id'];

		//echo("</br></br></br></br></br></br></br></br>".$v['fee_message_a']);
	}


        $sql = "select * from mp_spec_fee where spec_id = '$spec_id' ";
		$spec_fee_data = $spec_fee_dao->get_rows($sql);

	$smarty->assign ( 'spec_fee_data', $spec_fee_data );
	$smarty->assign ( 'spec_profile_forms', $spec_data );
$smarty->assign ( 'auth', $auth);
$smarty->assign ( 'spec_name', $spec_name);
$smarty->assign ( 'interlingua', $interlingua);
$smarty->assign ( 'title', $title);
$smarty->assign ( 'summary', $summary);
$smarty->assign ( 'birthday', $birthday);
$smarty->assign ( 'address', $address);
if($image1){$smarty->assign ( 'image1', "../".$image1);}
if($image2){$smarty->assign ( 'image2', "../".$image2);}
if($image3){$smarty->assign ( 'image3', "../".$image3);}
$smarty->assign ( 'experience', $experience);
$smarty->assign ( 'qualifications', $qualifications);
$smarty->assign ( 'actual_result', $actual_result);
$smarty->assign ( 'famous', $famous);
$smarty->assign ( 'cartoon_url', $cartoon_url);

$smarty->assign ( 'fee_message_a', $fee_message_a);
$smarty->assign ( 'fee_message_b', $fee_message_b);
$smarty->assign ( 'fee_message_c', $fee_message_c);

$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display('popup/popup_specialist_profile2.html');
?>
