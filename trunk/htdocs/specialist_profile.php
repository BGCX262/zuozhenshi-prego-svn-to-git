<?php
error_reporting('off');
require_once ('../system/smarty.inc');
require_once ('../system/Class_DB.php');
require_once ('../system/Class_PWD.php');
require_once ('../system/mdao/Class_mp_spec_profile.php');
require_once ('../system/mdao/Class_mp_spec_fee.php');
require_once ('../system/prego_m.php');
require_once ('../system/Class_ERROR.php');
require_once ('../system/login.inc.php');

$spec_profile_dao = new Class_mp_spec_profile ();
$spec_fee_dao = new Class_mp_spec_fee ();

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	

	$phase = 'input';
	$fee_message_arr = array ();
	if (isset ( $_GET ['spec_id'] ) && $_GET ['spec_id'] != '') {

		$spec_id = $_GET ['spec_id'];

		$smarty->assign ( 'spec_id', $spec_id );
	} else {
		if (isset ( $_GET ['id'] ) && $_GET ['id'] != '') {

			$forms = $spec_profile_dao->get ( $_GET ['id'] );
			$forms ['id'] = $_GET ['id'];

			$spec_id = $forms ['spec_id'];
			$image = $forms['image'];
			$smarty->assign ( 'spec_id', $forms ['spec_id'] );
			$smarty->assign('profile_id', $_GET['id']);
			$smarty->assign('image',$image);
		}
	}

	// get spec_fee_arr by spec_id
	$sql = sprintf ( "select * from mp_spec_fee where spec_id = '%s'", mysql_real_escape_string ( $spec_id ) );
	$spec_fee_arr = $spec_fee_dao->get_rows ( $sql );
	foreach ( $spec_fee_arr as $k => $v ) {
		$fee_message_arr [] = $v ['servers_menu'];
	}
	// show fee_message
	foreach ($fee_message_arr as $k => $v) {
		if($forms['fee_message_a'] != ''){
			if($forms['fee_message_a'] == $v){
				$forms['fee_message_a'] = $k;
			}
		}
		if($forms['fee_message_b'] != ''){
			if($forms['fee_message_b'] == $v){
				$forms['fee_message_b'] = $k;
			}
		}
		if($forms['fee_message_c'] != ''){
			if($forms['fee_message_c'] == $v){
				$forms['fee_message_c'] = $k;
			}
		}

	}
	// show image
	$uploadfile1 = $forms['image1'];
	$filename1 = substr($uploadfile1,7);
	$filetype_str1 = strrchr($filename1,'.');
	$filetype1 ='image/'.substr($filetype_str1,1);
	
	$uploadfile2 = $forms['image2'];
	$filename2 = substr($uploadfile2,7);
	$filetype_str2 = strrchr($filename2,'.');
	$filetype2 ='image/'.substr($filetype_str2,1);
	
	$uploadfile3 = $forms['image3'];
	$filename3 = substr($uploadfile3,7);
	$filetype_str3 = strrchr($filename3,'.');
	$filetype3 ='image/'.substr($filetype_str3,1);
	
	$smarty->assign ( 'filename1', $filename1 );
	$smarty->assign ( 'filetype1', $filetype1 );
	$smarty->assign ( 'filename2', $filename2 );
	$smarty->assign ( 'filetype2', $filetype2 );
	$smarty->assign ( 'filename3', $filetype2 );
	$smarty->assign ( 'filetype3', $filetype3 );
	// POST
} else {
	if($_POST['action']=='ajaximage'){
		$error = "";
		$msg = "";
		$uploadfile = "";
		$fileElementName = 'goods_image';
		if(!empty($_FILES[$fileElementName]['error']))
		{
			switch($_FILES[$fileElementName]['error'])
			{

				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';
					break;

				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error = 'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}
		}elseif(empty($_FILES['goods_image']['tmp_name']) || $_FILES['goods_image']['tmp_name'] == 'none')
		{
			$error = 'No file was uploaded..';
		}else 
		{
				$filename=$_FILES['goods_image']['name'];
				$type=strstr($_FILES['goods_image']['name'], '.');
				if(in_array($type, array('.jpg', '.jpeg', '.gif', '.png', '.swf', '.bmp'))) 
				{
					$uploadfile = "file/".date("ymd")."/".time().$type;
					if(!is_dir("file/".date("ymd"))){
						mkdir("file/".date("ymd"), 0700);
					}
					if (move_uploaded_file($_FILES['goods_image']['tmp_name'], $uploadfile)) {
						$msg = $uploadfile;
					} else {
						$error = "Possible file upload attack!\n";
					}
				}else{
					$error = "The uploaded file was not image!\n";
				}
				
				@unlink($_FILES['goods_image']);		
		}
		echo "{";
		echo				"error: '" . $error . "',\n";
		echo				"msg: '" . $msg . "',\n";
		echo				"filename: '" . $filename . "',\n";
		echo				"filetype: '" . $type . "',\n";
		echo				"path: '" . $uploadfile . "',\n";
		echo				"id:'".$_POST['imgname']. "'\n";
		echo "}";
		return ;
	}

	$forms = $_POST;
	$fee_message_arr = array ();
	// get spec_fee by spec_id
	$spec_id = $forms ['spec_id'];
	$sql = sprintf ( "select * from mp_spec_fee where spec_id = '%s'", mysql_real_escape_string ( $spec_id ) );
	$spec_fee_arr = $spec_fee_dao->get_rows ( $sql );

	// set service_fee items
	foreach ( $spec_fee_arr as $k => $v ) {
		$fee_message_arr [] = $v ['servers_menu'];
	}
	$select = array (
			'' => "選択してください"
	);
	$fee_message = array_merge ( $select, $fee_message_arr );

	// set values
	$values = array ();

	if ($forms ['mode'] == 'input') {

		// item check
		$err = new Class_ERROR ();
		$spec_profile_chk = $spec_profile_dao->get_checks ();
		foreach ( $spec_profile_chk as $kcol => $chkval ) {
			$err_mes [$kcol] = $err->check ( $forms [$kcol], $chkval );
		}

		$fee_arr = array();
		$fee_arr[] = $forms['fee_message_a'];
		$fee_arr[] = $forms['fee_message_b'];
		$fee_arr[] = $forms['fee_message_c'];
		$num = 0;
		foreach ($fee_arr as $k => $v) {
			foreach ($fee_arr as $kk => $vv) {
				if($v != '' && $vv != '' && $v == $vv){
					$num = $num + 1;
				}
			}
		}
		if($num > 3){
			$fee_err= "<p class='error'>フィー情報は重複しています</p>";
		}

		// err , reset values to page
		$smarty->assign ( 'spec_id', $forms ['spec_id'] );
		$smarty->assign ( 'image1', $forms['image1'] );
		$smarty->assign ( 'filename1', $forms['filename1'] );
		$smarty->assign ( 'filetype1', $forms['filetype1'] );
		$smarty->assign ( 'image2', $forms['image2'] );
		$smarty->assign ( 'filename2', $forms['filename2'] );
		$smarty->assign ( 'filetype2', $forms['filetype2'] );
		$smarty->assign ( 'image3', $forms['image3'] );
		$smarty->assign ( 'filename3', $forms['filename3'] );
		$smarty->assign ( 'filetype3', $forms['filetype3'] );
		$smarty->assign ( 'fee_message', $fee_message);
		$smarty->assign('profile_id', $forms ['profile_id']);

		if ($err->clear ) {

			$cols = $spec_profile_dao->get_cols ();
			foreach ( $cols as $kcol => $val ) {
				$values [$kcol] = $forms [$kcol];
			}

			foreach ($fee_message_arr as $k => $v) {
				if($forms['fee_message_a'] != ''){
					if($forms['fee_message_a'] == $k){
						$values['fee_message_a'] = $v;
					}
				}
			}
			foreach ($fee_message_arr as $k => $v) {
				if($forms['fee_message_b'] != ''){
					if($forms['fee_message_b'] == $k){
						$values['fee_message_b'] = $v;
					}
				}
			}
			foreach ($fee_message_arr as $k => $v) {
				if($forms['fee_message_c'] != ''){
					if($forms['fee_message_c'] == $k){
						$values['fee_message_c'] = $v;
					}
				}
			}

			$values ['spec_id'] = $spec_id;

			// 桁数チェック
			$maxlens = $spec_profile_dao->get_maxlens ();
			foreach ( $maxlens as $k => $v ) {
				$err_mes [$k] = $err->check_size ( $values [$k], $v );
			}
		}

		$smarty->assign ( 'spec_id', $forms ['spec_id'] );
		$smarty->assign ( 'fee_message', $fee_message );
		$smarty->assign ( 'image1', $forms['image1'] );
		$smarty->assign ( 'filename1', $forms['filename1'] );
		$smarty->assign ( 'filetype1', $forms['filetype1'] );
		$smarty->assign ( 'image2', $forms['image2'] );
		$smarty->assign ( 'filename2', $forms['filename2'] );
		$smarty->assign ( 'filetype2', $forms['filetype2'] );
		$smarty->assign ( 'image3', $forms['image3'] );
		$smarty->assign ( 'filename3', $forms['filename3'] );
		$smarty->assign ( 'filetype3', $forms['filetype3'] );
		$smarty->assign('profile_id', $forms ['profile_id']);

		if ($err->clear && $msg_err == '' && $fee_err == '') {

			$executeflg = TRUE;
			$url_values = array();

				// 登録
				if ($forms ['id'] == '') {

					$forms ['id'] = $id;

					// deal with image
					if(isset($_FILES['img'])){

						$filename = $_FILES['img']['name'];
						$type_str = $_FILES['img']['type'];

						$type = array("image/jpg","image/gif","image/bmp","image/jpeg","image/png");
						//如果不存在能上传的类型
						if(!empty($type_str)){
							if(!in_array(strtolower($type_str),$type)){
								$text = implode('.',$type);
								$msg_err = "<p class='error'>画像タイプエラー:".$text."</p>";
							}else{

								// 上传文件存放的路径
								$uploadfile = "./file/".$filename;
							}
						}


						move_uploaded_file($_FILES['img']['tmp_name'],$uploadfile);

						$values['image'] = $uploadfile;

					}

					try {
						$spec_profile_dao->begin_trans();
						if ($profile_id = $spec_profile_dao->add ( $values )) {

							$smarty->assign('profile_id', $profile_id );

							$md5_url_id =md5($profile_id);
							$url_values['have_profile_url'] = $md5_url_id;
							$url_values['have_no_profile_url'] = $md5_url_id;

							$smarty->assign ( 'spec_id', $forms ['spec_id'] );
							if($spec_profile_dao->edit($profile_id, $url_values)){
							}else{
								$executeflg = FALSE;
							}
						} else {
							$executeflg = FALSE;
						}
						if($executeflg){
							$spec_profile_dao->commit_trans ();
							$smarty->assign ( 'spec_id', $spec_id );
							$smarty->assign ( 'message', '登録が完了しました。' );
						}else{
							$spec_profile_dao->rollback_trans ();
							$smarty->assign ( 'message', '登録が失敗しました。' );
						}
					} catch (Exception $e) {
						$spec_profile_dao->rollback_trans ();
						$smarty->assign ( 'message', 'ＤＢエラーで失敗しました。' );
					}
					// 更新
				} else {

					if(isset($_FILES['img'])){

						if($_FILES['img']['name'] == ''){
							$filename = $forms['filename'];
						}else{
							$filename = $_FILES['img']['name'];
						}
						if($_FILES['img']['type'] == ''){
							$type_str = $forms['filetype'];
						}else{
							$type_str = $_FILES['img']['type'];
						}

						$type = array("image/jpg","image/gif","image/bmp","image/jpeg","image/png");
						//如果不存在能上传的类型
							if(!in_array(strtolower($type_str),$type)){
								$text = implode('.',$type);
								$msg_err = "<p class='error'>画像タイプエラー:".$text."</p>";
							}else{
								// 上传文件存放的路径
								$uploadfile = "./file/".$filename;
							}

						move_uploaded_file($_FILES['img']['tmp_name'],$uploadfile);

						$values['image'] = $uploadfile;

					}else{
					}

					$md5_url_id =md5($forms ['id']);
					$values['have_profile_url'] = $md5_url_id;
					$values['have_no_profile_url'] = $md5_url_id;

					if ($spec_profile_dao->edit ( $forms ['id'], $values )) {

						$smarty->assign('profile_id', $forms ['profile_id']);
						$smarty->assign ( 'message', '更新が完了しました。' );
					} else {
						$smarty->assign ( 'message', '更新が失敗しました。' );
					}
					$id = $forms ['id'];
				}
			$phase = 'complete';
		} else {
			$phase = 'input';
			$smarty->assign ( 'image1', $forms['image1'] );
			$smarty->assign ( 'filename1', $forms['filename1'] );
			$smarty->assign ( 'filetype1', $forms['filetype1'] );
			$smarty->assign ( 'image2', $forms['image2'] );
			$smarty->assign ( 'filename2', $forms['filename2'] );
			$smarty->assign ( 'filetype2', $forms['filetype2'] );
			$smarty->assign ( 'image3', $forms['image3'] );
			$smarty->assign ( 'filename3', $forms['filename3'] );
			$smarty->assign ( 'filetype3', $forms['filetype3'] );
			$md5_url_id =md5($forms ['id']);
			$forms['have_profile_url'] = $md5_url_id;
			$forms['have_no_profile_url'] = $md5_url_id;

		}
	}
}

$select = array (
		'' => "選択してください"
);
$fee_message = array_merge ( $select, $fee_message_arr );

if (isset ( $forms ))	$smarty->assign ( 'forms', $forms );
if (isset ( $err_mes ))	$smarty->assign ( 'err', $err_mes );
if (isset ( $msg_err ))	$smarty->assign ( 'msg', $msg_err );
if (isset ( $fee_err ))	$smarty->assign ( 'fee_err', $fee_err );


$have_profile_url = $_SERVER["HTTP_REFERER"];
$have_no_profile_url=$_SERVER["HTTP_REFERER"];
$strArr=explode('specialist',$have_profile_url);

$smarty->assign ( 'have_profile_url', $strArr[0]."popup/specialist_profile1.php?ID=");
$smarty->assign ( 'have_no_profile_url', $strArr[0]."popup/specialist_profile2.php?ID=");


$smarty->assign ( 'image1', $forms['image1'] );
$smarty->assign ( 'filename1', $forms['filename1'] );
$smarty->assign ( 'filetype1', $forms['filetype1'] );
$smarty->assign ( 'image2', $forms['image2'] );
$smarty->assign ( 'filename2', $forms['filename2'] );
$smarty->assign ( 'filetype2', $forms['filetype2'] );
$smarty->assign ( 'image3', $forms['image3'] );
$smarty->assign ( 'filename3', $forms['filename3'] );
$smarty->assign ( 'filetype3', $forms['filetype3'] );
$smarty->assign ( 'fee_message', $fee_message );
$smarty->assign ( 'phase', $phase );
$smarty->assign ( 'auth', $auth );

$smarty->assign ( 'menu', $smarty->fetch ( 'menu.html' ) );
$smarty->assign ( 'footer', $smarty->fetch ( 'footer.html' ) );
$smarty->assign ( 'logout', $smarty->fetch ( 'logout.html' ) );
$smarty->display ( 'specialist_profile.html' );
?>