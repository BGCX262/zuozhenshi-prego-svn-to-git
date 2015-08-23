<?php

require_once ('../system/smarty.inc');
require_once ('../system/mdao/Class_mp_service_category.php');
require_once ('../system/Class_ERROR.php');
require_once ('../system/login.inc.php');
require_once ('../system/prego_m.php');

$dao = new Class_mp_service_category ();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	
	$phase = 'input';
	// get category data
	$sql = "select * from mp_service_category";
	$forms = $dao->get_rows ( $sql );
} else {
	
	$forms = $_POST;
	
	// set $forms['mutirow'] array
	if (isset ( $forms ['category_id'] )) {
		foreach ( $forms ['category_id'] as $k => $v ) {
			$forms ['mutirow'] [] = array (
					"id" => $v,
					"category_name" => $forms ['category_name'] [$k] 
			);
		}
	}
	
	if ($forms ['mode'] == 'input') {
		
		// check $forms['mutirow'] items
		$err = new Class_ERROR ();
		$index = 0;
		$category_chk = $dao->get_checks ();
		foreach ( $forms ['mutirow'] as $k => $v ) {
			$err_mes ['category_name'] [$index] = $err->check ( $v ['category_name'], $category_chk ['category_name'] );
			$index = $index + 1;
		}
		
		// verification check
		// $temp = 1;
		// foreach ($forms ['mutirow'] as $k => $v) {
		// $num = 0;
		// foreach ($forms ['mutirow'] as $kk => $vv){
		// if($v['category_name'] == $vv['category_name']){
		// $num = $num + 1;
		// }
		// }
		// if( $num > 1 ){
		// $err->clear = false;
		// $err_mes['category_name'][$temp] = "<p
		// class='error'>このカテゴリ名は重複しています</p>";
		// }
		// $temp = $temp + 1;
		// }
		
		// if check ok
		if ($err->clear) {
			$executeflg = TRUE;
			
			if ($executeflg) {
				
				// get category data
				$sql = "select * from mp_service_category";
				$dbarray = $dao->get_rows ( $sql );
				
				// foreach $dbarray
				foreach ( $dbarray as $k => $v ) {
					$delflag = true;
					$val_category_name = "";
					foreach ( $forms ['mutirow'] as $kk => $vv ) {
						if ($v ['id'] == $vv ['id']) {
							$delflag = false;
							$val_category_name = $vv ['category_name'];
						}
					}
					
					// remove data
					if ($delflag) {
						if ($dao->remove ( $v ['id'] )) {
						} else {
							$executeflg = false;
						}
						// update data
					} else {
						$values = array ();
						$values ['category_name'] = $val_category_name;
						if ($dao->edit ( $v ['id'], $values )) {
						} else {
							$executeflg = false;
						}
					}
				}
				
				// foreach $forms['mutirow']
				foreach ( $forms ['mutirow'] as $k => $v ) {
					$taddflag = true;
					foreach ( $dbarray as $kk => $vv ) {
						if ($v ['id'] == $vv ['id']) {
							$taddflag = false;
							break;
						}
					}
					
					// add data
					if ($taddflag) {
						$values = array ();
						$values ['category_name'] = $v ['category_name'];
						if ($dao->add0 ( $values )) {
						} else {
							$executeflg = FALSE;
						}
					}
				}
			}
			
			if ($executeflg) {
				$smarty->assign ( 'message', '更新が完了しました。' );
			} else {
				$smarty->assign ( 'message', '更新が失敗しました。' );
			}
			
			$id = $forms ['id'];
			$phase = 'complete';
		} else {
			$phase = 'input';
		}
	}
}

if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $err_mes ))
	$smarty->assign ( 'err', $err_mes );

$smarty->assign ( 'phase', $phase );

$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'service_category.html' );
?>