<?php
require_once ('../system/smarty.inc');
require_once ('../system/mdao/Class_mp_specialist.php');
require_once ('../system/mdao/Class_mp_spec_profile.php');

$spec_dao = new Class_mp_specialist ();
$spec_profile_dao = new Class_mp_spec_profile ();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {


	if(isset($_GET['v']) && $_GET['v'] != ''){
		$value=$_GET['v'];
		if (strlen($value) > 0){
			$spec_sql = "select * from mp_spec where spec_name like '%$value%' ";
		}else {
			$spec_sql = "select * from mp_spec";
		}
	}else{
		$spec_sql = "select * from mp_spec";
		}
		//$spec_profile_sql = "select * from mp_spec_profile";
		
		$hint="<thead>";
		$hint += "<tr>";
		$hint += "<th>ID</th>";
		$hint += "<th>スペシャリスト名</th>";
		$hint += "<th>セット</th>";
		$hint += "</tr>";
		$hint += "</thead><tbody>";
		$content = "";
		$end = "</tbody>";
		$spec_profile_data = array();
		$spec_data = $spec_dao->get_rows ( $spec_sql );
		if ($spec_data) {
			foreach ($spec_data as $key=>$spec){
				$spec_profile_sql = "select * from mp_spec_profile where spec_id =".$spec['id'];
				$spec_profile_data[] = $spec_profile_dao->get_rows ( $spec_profile_sql );
				
			}
		}
		$index = 0;
		foreach ($spec_data as $k => $v) {
			$index = $k + 1;
			$content += "<tr>";
			$content += "<td>".$index."</td>";
			$content += "<td>".$v['spec_name']."</td>";
			$content += "<td>";
			$content += "<table>";
			foreach ($spec_profile_data as $kk => $vv) {
				if($v['id'] == $vv['spec_id']){
					$content += "<tbody>";
					$content += "<tr>";
					$content += "<td class='td_name' width='100%'><a href='javascript:;' data-url='popup_specialist_profile1.php?id=".$vv['id'].">".$vv['profile_name']."</a></td>";
					$content += "<td class='preview' ><a href='javascript:;'>セット</a></td>";
					$content += "<input type='hidden' name='profile_id' value=".$vv['id']."/>";
					$content += "<input type='hidden' name='spec_id' value=".$v['id']."/>";
					$content += "<input type='hidden' name='spec_name' value=".$v['spec_name']."/>";
					$content += "</tr>";
					$content += "</tbody>";
				}
			}
			$content += "</table>";
			$content += "</td>";
			$content += "</tr>";
		}
		
		if ($content == ""){
			$response=$hint."<tr><td>"."no suggestion"."</td></tr>".$end;
		}else{
			$response=$hint.$content.$end;
		}
		
		
		
}

if (isset ( $spec_data ) && isset ( $spec_profile_data )) {
	
	$smarty->assign ( 'spec_data', $spec_data );
	$smarty->assign ( 'spec_profile_data', $spec_profile_data );
}
$smarty->assign ( 'condition', $value);
$smarty->display ( 'popup_specialist_select.html' );
?>