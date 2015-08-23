<?php

require_once ('../system/smarty.inc');
require_once ('../system/Class_ERROR.php');
require_once ('../system/login.inc.php');
require_once ('../system/prego_m.php');
require_once ('../system/mdao/Class_mp_service.php');
require_once ('../system/mdao/Class_mp_service_category.php');
require_once ('../system/mdao/Class_mp_promise_spec.php');
require_once ('../system/mdao/Class_mp_spec_fee.php');

$dao = new Class_mp_service ();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	
	$phase = 'input';
	
	if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
		
		$service_forms = $dao->get ( $_GET ['id'] );
		$forms ['id'] = $_GET ['id'];
	}
	
} else {
	
	$forms = $_POST;
	
	$values = array ();
	if ($forms ['mode'] == 'input') {
		
		// check service items
		$err = new Class_ERROR ();
		$service_chk = $dao->get_checks ();
		foreach ( $service_chk as $kcol => $chkval ) {
			$err_mes [$kcol] = $err->check ( $forms [$kcol], $chkval );
		}
		
		$err_mes["kinds"] = $err->check ($forms['kinds'],array("EXIST"));
		
		// reset values
		$smarty->assign ( 'forms', $forms );
		
		if($err->clear){
			$cols = $dao->get_cols ();
			foreach ( $cols as $kcol => $val ) {
				$values [$kcol] = $forms [$kcol];
			}
				
			$values ['category_id'] = $forms ['category_id'];
			
			
			if (isset ( $forms ['service_fee'] ) && is_numeric ( $forms ['service_fee'] )) {
				$values ['service_fee'] = $forms ['service_fee'];
			}else{
				$values ['service_fee'] = 0;
			}
			if (isset ( $forms ['spec_fee'] ) && is_numeric ( $forms ['spec_fee'] )) {
				$values ['spec_fee'] = $forms ['spec_fee'];
			}else{
				$values ['spec_fee'] = 0;
			}
			
			
			// 桁数チェック
			$maxlens = $dao->get_maxlens ();
			foreach ( $maxlens as $k => $v ) {
				$err_mes [$k] = $err->check_size ( $values [$k], $v );
			}
		}
		
		$smarty->assign ( 'forms', $forms );
		
		// check ok
		if ($err->clear) {
			
			$executeflg = TRUE;
			
			// 登録
			if ($forms ['id'] == '') {
				
				$forms ['id'] = $id;
				
				if ($dao->add0 ( $values )) {
					$smarty->assign ( 'message', '登録が完了しました。' );
				} else {
					$smarty->assign ( 'message', '登録が失敗しました。' );
				}
				// 更新
			} else {
				
				$promise_spec_dao = new Class_mp_promise_spec($dao->get_db());
				$spec_fee_dao = new Class_mp_spec_fee($dao->get_db());
				
				try {
					$dao->begin_trans();
					
					$forms['memo'] = str_replace(" ","",$forms['memo']);
					$forms['memo'] = str_replace("　","",$forms['memo']);
					$forms['caption'] = str_replace(" ","",$forms['caption']);
					$forms['caption'] = str_replace("　","",$forms['caption']);
					$values['memo'] = $forms['memo'];
					$values['caption'] = $forms['caption'];
					
					if ($dao->edit ( $forms ['id'], $values )) {
						// update promise_spec  service_name
						$service_data = $dao->get($forms['id']);
						$service_menu = $service_data['service_menu'];
						$promise_spec_service_id = $forms['id'];
						$promise_spec_values = array();
						$promise_spec_values['service_name'] = $service_menu;
						$where = "service_id = '$promise_spec_service_id' ";
						
						if($promise_spec_dao->editbywhere($where, $promise_spec_values)){
							
						}else{
							$executeflg = FALSE;
							break;
						}
						
						// update spec_fee service_name
						$spec_fee_service_id = $forms['id'];
						$spec_fee_values = array();
						$spec_fee_values['servers_menu'] = $service_menu;
						$where = "service_id = '$spec_fee_service_id' ";
						if($spec_fee_dao->editbywhere($where, $spec_fee_values)){
							
						}else{
							$executeflg = FALSE;
							break;
						}
					}else{
						$executeflg = FALSE;
						break;
					}
					
					if($executeflg){
						$dao->commit_trans();
						$smarty->assign ( 'message', '更新が完了しました。' );
					}else{
						$dao->rollback_trans();
						$smarty->assign ( 'message', '更新が失敗しました。' );
					}
				} catch (Exception $e) {
					$dao->rollback_trans();
					$smarty->assign ( 'message', 'ＤＢエラーで失敗しました。' );
				}
				$id = $forms ['id'];
			}
			$phase = 'complete';
		} else {
			$phase = 'input';
		}
	}
}

$categorydao = new Class_mp_service_category ();

$sql = "select * from mp_service_category";

$categorydata = $categorydao->get_rows ( $sql );

if (isset ( $categorydata ))
	$smarty->assign ( 'categorydata', $categorydata );

if (isset ( $forms ))
	$smarty->assign ( 'forms', $forms );
if (isset ( $err_mes ))
	$smarty->assign ( 'err', $err_mes );
if (isset ( $service_forms ))
	$smarty->assign ( 'forms', $service_forms );
$smarty->assign ( 'phase', $phase );

$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'service_edit.html' );
?>