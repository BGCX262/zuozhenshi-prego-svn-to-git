<?php

require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');
require_once ('../system/mdao/Class_mp_account.php');
require_once ('../system/prego_m.php');
require_once ('../system/Class_ERROR.php');
require_once ('../system/login.inc.php');

// Class_PWD::valid_auth(AOKI_AUTH_ACCOUNT,$login['staff_auth']);
// $login_auth = $login['staff_auth'];

$dao = new Class_mp_account ();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	$phase = 'input';
	if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {
		$forms = $dao->get ( $_GET ['id'] );
		//print_r($forms);
		$forms ["id"] = $_GET ['id'];
	}
} else {
	$forms = $_POST;
	if ($forms ['mode'] == 'input') {
		$err = new Class_ERROR ();
		$chk = $dao->get_checks ();
		
		foreach ( $chk as $kcol => $chkval ) {
			$err_mes [$kcol] = $err->check ( $forms [$kcol], $chkval );
		}
		// ログインIDチェック
		if ($err_mes ['login_id'] == '') {
			if ($forms ['id'] == '') {
				$where = sprintf ( " login_id = '%s'", $forms ['login_id'] );
			} else {
				$where = sprintf ( " login_id = '%s' AND id <> %s", $forms ['login_id'], $forms ['id'] );
			}
			if ($dao->exits ( $where )) {
				$err->clear = false;
				$err_mes ['login_id'] = "<p class='error'>このログインIDは重複しています</p>";
			}
		}
		/*
		// アカウント名　チェック
		if ($err_mes ['user_name'] == '') {
			if ($forms ['id'] == '') {
				$where = sprintf ( " user_name = '%s'", $forms ['user_name'] );
			} else {
				$where = sprintf ( " user_name = '%s' AND id <> %s", $forms ['user_name'], $forms ['id'] );
			}
			if ($dao->exits ( $where )) {
				$err->clear = false;
				$err_mes ['user_name'] = "<p class='error'>このアカウント名は重複しています</p>";
			}
		}
		*/
		if ($err->clear) {
			$cols = $dao->get_cols ();
			foreach ( $cols as $kcol => $val ) {
				$values [$kcol] = $forms [$kcol];
			}
			// set login_flags '0':ログイン可     '1':ログイン不可
			if (empty ( $values ["login_flgs"] )) {
				$values ["login_flgs"] = 0;
			}
			
			
			// 桁数チェック
			$maxlens = $dao->get_maxlens ();
			foreach ( $maxlens as $k => $v ) {
				$err_mes [$k] = $err->check_size ( $values [$k], $v );
			}
		}
		// check OK
		if ($err->clear) {
			
			
			//登録
			if ($forms ['id'] == '') {
				// set other_id = 0
				$values ['other_id'] = '0';
				if ($id = $dao->add ( $values )) {
					$forms ['flag'] = $id;
					$smarty->assign ( 'message', '登録が完了しました。' );
				} else {
					$smarty->assign ( 'message', '登録が失敗しました。' );
				}
			// 更新
			} else {
				
				$values['other_id'] = $forms['other_id'];
				
				if ($dao->edit ( $forms ['id'], $values )) {
					$smarty->assign ( 'message', '更新が完了しました。' );
				} else {
					$smarty->assign ( 'message', '更新が失敗しました。' );
				}
				$id = $forms ['id'];
			}
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
$smarty->assign ( 'sorts', $prego_account_sorts );
$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'account_edit.html' );

?>