<?php
require_once ('../system/smarty.inc');
require_once ('../system/mdao/Class_mp_corporate.php');

$dao = new Class_mp_corporate ();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	
	
	if(isset($_GET['v']) && $_GET['v'] != ''){
		$value=$_GET['v'];
		if (strlen($value) > 0){
				$sql = "select * from mp_corporate where corporate_name like '%$value%' ";
		}else {
			$sql = "select * from mp_corporate";
		}
	}else{
		$sql = "select * from mp_corporate";
	}
	$hint="<thead>";
	$hint += "<tr>";
	$hint += "<th>ID</th>";
	$hint += "<th>クライアント名</th>";
	$hint += "<th>セット</th>";
	$hint += "</tr>";
	$hint += "</thead><tbody>";
	$content = "";
	$end = "</tbody>";
	$data = $dao->get_rows ( $sql );
	foreach ($data as $k => $v) {
		$index = $k+1;
		$content += "<tr>";
		$content += "<td>".$index."</td>";
		$content += "<td>".$v['corporate_name']."</td>";
		$content += "<td class='preview'><a href='javascript:;'>セット</a></td>";
		$content += "<input type='hidden' name='corporate_id' value='".$v['id']."' />";
		$content += "</tr>";
	}
		
	if ($content == ""){
		$response=$hint."<tr><td>"."no suggestion"."</td></tr>".$end;
	}else{
		$response=$hint.$content.$end;
	}
} 

if (isset ( $data ))
	$smarty->assign ( 'data', $data );
$smarty->assign ( 'condition', $value);

$smarty->display ( 'popup_client_select.html' );

?>