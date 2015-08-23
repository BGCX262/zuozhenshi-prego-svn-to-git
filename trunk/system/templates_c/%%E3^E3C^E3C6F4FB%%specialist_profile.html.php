<?php /* Smarty version 2.6.26, created on 2013-03-24 23:11:01
         compiled from specialist_profile.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'specialist_profile.html', 93, false),array('function', 'html_options', 'specialist_profile.html', 190, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-2022-JP">
<link href="./assets/styles/default.css" rel="stylesheet" />
<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="./assets/scripts/import.js" type="text/javascript"></script>
<script src="./assets/scripts/plugin/jquery.datasort.js" type="text/javascript"></script>
<script src="./assets/scripts/plugin/ajaxfileupload.js" type="text/javascript"></script>
<script type="text/javascript">

	function ajaxFileUpload(id)
	{
		
		$.ajaxFileUpload
		(
			{
				url:'specialist_profile.php',
				secureuri:false,
				fileElementId:id,
				dataType: 'json',
				data:{action:'ajaximage' },
				
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{	
							$("#img").html('<div id='+data.id+'><img src="'+data.msg+'" width="240"><br><a href="javascript:;" onclick="remove_img('+data.id+');" class="delete_mini">削除</a><input type="hidden" name="filename" value="'+data.filename+'" /><input type="hidden" name="filetype" value="'+data.filetype+'" /><input type="hidden" name="image" value="'+data.path+'" /></div>');
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		return false;
	}
	
	function remove_img(id){
		$("#"+id).remove();
		$(".filename").html('No file selected');
	}
</script>	
<title>コントロールパネル</title>
<script type="text/javascript">
function GoToRefer(){
	var val = document.getElementById("id").value;
	window.location.href="specialist_refer.php?"+"id="+val;
}
</script>

</head>
<body>
<?php echo $this->_tpl_vars['logout']; ?>

<div id="container">
<?php echo $this->_tpl_vars['menu']; ?>

<article id="article" class="load">
		<h2>スペシャリストデスク</h2>
		<nav>
			<ul>
			<?php if ($this->_tpl_vars['auth'] == '1'): ?>
				<li><a href="specialist_unregistered.php"><span>未登録一覧</span></a></li>
				<li class="active"><a href="specialist_search.php"><span>スペシャリスト検索</span></a></li>
			<?php elseif ($this->_tpl_vars['auth'] == '3'): ?>
				<li class="active"><a href="specialist_edit.php"><span>スペシャリスト情報</span></a></li>
			<?php endif; ?>
			</ul>
		</nav>
		<section id="content">
			<h3>プロフィール<?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>更新 <?php endif; ?><?php if ($this->_tpl_vars['phase'] == 'complete'): ?>完了<?php endif; ?></h3>
<?php if ($this->_tpl_vars['phase'] == 'input'): ?>
			<p class="message"><?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>更新<?php endif; ?>内容を確認し、<?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>更新<?php endif; ?>ボタンをクリックしてください。</p>
			<form name="fm" action="specialist_profile.php" method="post" enctype="multipart/form-data">
				<h4>基本情報</h4>
				<table class="formTable">
					<tbody>
                       <?php if ($this->_tpl_vars['forms']['id'] != ''): ?>
						<tr>
							<th>ID</th>
							<td><?php echo $this->_tpl_vars['forms']['id']; ?>
</td>
						</tr>
						<tr>
							<th>登録日時</th>
							<td>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['forms']['c_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M")); ?>
<input type="hidden" name="c_time" value="<?php echo $this->_tpl_vars['forms']['c_time']; ?>
" />
							</td>
						</tr>
						<tr>
							<th>更新日時</th>
							<td>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['forms']['u_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M")); ?>
<input type="hidden" name="u_time" value="<?php echo $this->_tpl_vars['forms']['u_time']; ?>
" />
							</td>
						</tr>
<?php endif; ?>
						<tr>
							<th class="must">プロフィール名</th>
							<td>
								<input type="text" class="text" name="profile_name" value="<?php echo $this->_tpl_vars['forms']['profile_name']; ?>
" maxlength="100"/><?php echo $this->_tpl_vars['err']['profile_name']; ?>

							</td>
						</tr>
<?php if ($this->_tpl_vars['forms']['id'] != ''): ?>
						<tr>
							<th>プロフィールURL<br />（履歴あり）</th>
							<td><?php echo $this->_tpl_vars['have_profile_url']; ?>
<?php echo $this->_tpl_vars['forms']['have_profile_url']; ?>
</td>
						</tr>
						<tr>
							<th>プロフィールURL<br />（履歴なし）</th>
							<td><?php echo $this->_tpl_vars['have_no_profile_url']; ?>
<?php echo $this->_tpl_vars['forms']['have_no_profile_url']; ?>
</td>
						</tr>
<?php endif; ?>
						<tr>
							<th>肩書</th>
							<td>
								<input type="text" class="text" name="title" value="<?php echo $this->_tpl_vars['forms']['title']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['title']; ?>

							</td>
						</tr>
						<tr>
							<th>画像</th>
							<td>
							<div id="img" >
							<?php if ($this->_tpl_vars['image'] != ''): ?>
								<div id="1">
									<img src="<?php echo $this->_tpl_vars['image']; ?>
" width="240">
									<br>
									<a href="javascript:;" onclick="remove_img(1);" class="delete_mini">削除</a>
									<input type="hidden" name="filename" value="<?php echo $this->_tpl_vars['filename']; ?>
">
									<input type="hidden" name="filetype" value="<?php echo $this->_tpl_vars['filetype']; ?>
">
									<input type="hidden" name="image" value="<?php echo $this->_tpl_vars['image']; ?>
">
								</div>
							<?php endif; ?>
							</div>
							<div style="clear:both"></div>
							<input id="fileToUpload" type="file" name="goods_image" value="<?php echo $this->_tpl_vars['forms']['goods_image']; ?>
" onchange="return ajaxFileUpload('fileToUpload');" >
							</td>

						</tr>
						<tr>
							<th>概要</th>
							<td>
								<textarea name="summary" maxlength="1000" ><?php echo $this->_tpl_vars['forms']['summary']; ?>
</textarea><?php echo $this->_tpl_vars['err']['summary']; ?>

							</td>
						</tr>
						<tr>
							<th>現住所</th>
							<td>
								<input type="text" class="text" name="address" value="<?php echo $this->_tpl_vars['forms']['address']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['address']; ?>

							</td>
						</tr>
						<tr>
							<th>経歴</th>
							<td>
								<textarea name="experience" maxlength="1000"><?php echo $this->_tpl_vars['forms']['experience']; ?>
</textarea><?php echo $this->_tpl_vars['err']['experience']; ?>

							</td>
						</tr>
						<tr>
							<th>資格</th>
							<td>
								<textarea name="qualifications" maxlength="1000"><?php echo $this->_tpl_vars['forms']['qualifications']; ?>
</textarea><?php echo $this->_tpl_vars['err']['qualifications']; ?>

							</td>
						</tr>
						<tr>
							<th>実績</th>
							<td>
								<textarea name="actual_result" maxlength="1000"><?php echo $this->_tpl_vars['forms']['actual_result']; ?>
</textarea><?php echo $this->_tpl_vars['err']['actual_result']; ?>

							</td>
						</tr>
						<tr>
							<th>著書・著名</th>
							<td>
								<textarea name="famous" maxlength="200"><?php echo $this->_tpl_vars['forms']['famous']; ?>
</textarea><?php echo $this->_tpl_vars['err']['famous']; ?>

							</td>
						</tr>
						<tr>
							<th>経歴・資格・実績<br />著書/著名</th>
							<td>
								<textarea name="comprehensive" maxlength="1000"><?php echo $this->_tpl_vars['forms']['comprehensive']; ?>
</textarea><?php echo $this->_tpl_vars['err']['comprehensive']; ?>

							</td>
						</tr>
						<tr>
							<th>フィー情報</th>
							<td>
<?php echo smarty_function_html_options(array('name' => 'fee_message_a','options' => $this->_tpl_vars['fee_message'],'selected' => $this->_tpl_vars['forms']['fee_message_a']), $this);?>

<?php echo smarty_function_html_options(array('name' => 'fee_message_b','options' => $this->_tpl_vars['fee_message'],'selected' => $this->_tpl_vars['forms']['fee_message_b']), $this);?>

<?php echo smarty_function_html_options(array('name' => 'fee_message_c','options' => $this->_tpl_vars['fee_message'],'selected' => $this->_tpl_vars['forms']['fee_message_c']), $this);?>

<?php echo $this->_tpl_vars['fee_err']; ?>

							</td>
						</tr>
						<tr>
							<th>動画URL</th>
							<td>
								<input type="text" class="text" name="cartoon_url" value="<?php echo $this->_tpl_vars['forms']['cartoon_url']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['cartoon_url']; ?>

							</td>
						</tr>
					</tbody>
				</table>

				<p class="button">

					<?php if ($this->_tpl_vars['forms']['id']): ?>
						<button type="button" class="btn_back" onclick="GoToRefer()"><span>戻る</span></button>
						<button type="submit" class="btn_update" class="submit"><span>更新</span></button>
					<?php else: ?>
						<button type="button" class="btn_regist" class="submit"><span>登録</span></button>
					<?php endif; ?>
				</p>
				<input type="hidden" name="id"  value="<?php echo $this->_tpl_vars['forms']['id']; ?>
" />
				<input type="hidden" name="mode" value="" />
				<input type="hidden" name="spec_id" id="id" value="<?php echo $this->_tpl_vars['spec_id']; ?>
" />
				<input type="hidden" name="profile_id" value="<?php echo $this->_tpl_vars['profile_id']; ?>
" />
			</form>
		</section>
	</article>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['phase'] == 'complete'): ?>
					<p class="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
					<ul class="result_btn">

						<?php if ($this->_tpl_vars['forms']['id'] != ''): ?>
							<li><a href="specialist_search.php?hist=2">一覧に戻る</a></li>
							<li><a href="specialist_profile.php?id=<?php echo $this->_tpl_vars['profile_id']; ?>
">登録した内容を更新</a></li>
						<?php else: ?>
							<li><a href="specialist_refer.php?id=<?php echo $this->_tpl_vars['spec_id']; ?>
">続けて新規登録する</a></li>
							<li><a href="specialist_profile.php?id=<?php echo $this->_tpl_vars['profile_id']; ?>
">登録した内容を更新</a></li>
						<?php endif; ?>
					</ul>
<?php endif; ?>
<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>
</body>
</html>