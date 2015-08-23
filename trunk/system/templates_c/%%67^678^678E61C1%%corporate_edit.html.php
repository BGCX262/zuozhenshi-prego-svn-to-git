<?php /* Smarty version 2.6.26, created on 2013-03-25 16:26:09
         compiled from corporate_edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'corporate_edit.html', 65, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/default.css" rel="stylesheet" />
<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="./assets/scripts/import.js" type="text/javascript"></script>
<script src="./assets/scripts/plugin/jquery.datasort.js" type="text/javascript"></script>
<title>コントロールパネル</title>

<script type="text/javascript">
$(function() {	
	var html = '<table class="formTable"><tbody>';
	html += '<tr><th><a href="javascript:;" class="del_item">削除</a>担当者</th><td><input type="text" class="text" name="tantou_name[]" maxlength="100"/></td></tr>';
	html += '<tr><th>メールアドレス</th><td><input type="text" class="text" name="mail_address[]" maxlength="100"/></td></tr>';
	html += '<input type="hidden" name="tantou_id[]" value="" />';
	html += '</tbody></table>';
	setAppendCtrl("#charge",html);
});
/*
function GoToUnregistered(){
	window.location.href="corporate_unregistered.php";
}
*/
function GoToRefer(){
	var val = document.getElementById("id").value;
	window.location.href="corporate_refer.php?id="+val;
}

</script>

</head>
<body>
<?php echo $this->_tpl_vars['logout']; ?>

<div id="container">
<?php echo $this->_tpl_vars['menu']; ?>

	<article id="article" class="load">
		<h2>クライアント様デスク</h2>
		<nav>
			<ul>
				<?php if ($this->_tpl_vars['auth'] == '1'): ?>
					<li class="active"><a href="corporate_unregistered.php"><span>未登録一覧</span></a></li>
					<li ><a href="corporate_search.php"><span>クライアント検索</span></a></li>
				<?php elseif ($this->_tpl_vars['auth'] == '2'): ?>
					<li class="active"><a href="corporate_refer.php"><span>クライアント情報</span></a></li>
				<?php endif; ?>
			</ul>
		</nav>
		<section id="content">
			<h3>クライアント様情報<?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?> 更新<?php endif; ?><?php if ($this->_tpl_vars['phase'] == 'complete'): ?>完了<?php endif; ?></h3>
<?php if ($this->_tpl_vars['phase'] == 'input'): ?>
			<p class="message"><?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>更新<?php endif; ?>内容を確認し、<?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>更新<?php endif; ?>ボタンをクリックしてください。</p>
			<form name="fm" action="corporate_edit.php" method="post" >
				<h4>基本情報</h4>
						
				<table class="formTable">
					<tbody>
<?php if ($this->_tpl_vars['forms']['id'] != ''): ?>
						<tr>
							<th>ID</th>
							<td><?php echo $this->_tpl_vars['corporate_forms']['id']; ?>
</td>
						</tr>
						<tr>
							<th>登録日時</th>
							<td><?php echo ((is_array($_tmp=$this->_tpl_vars['corporate_forms']['c_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M")); ?>
<input type="hidden" name="c_time" value="<?php echo $this->_tpl_vars['corporate_forms']['c_time']; ?>
" /></td>
						</tr>
						<tr>
							<th>更新日時</th>
							<td><?php echo ((is_array($_tmp=$this->_tpl_vars['corporate_forms']['u_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y/%m/%d %H:%M")); ?>
<input type="hidden" name="u_time" value="<?php echo $this->_tpl_vars['corporate_forms']['u_time']; ?>
" />
							</td>
						</tr>
<?php endif; ?>
						<tr>
							<th class="must">会社名</th>
							<td><input type="text" class="text" name="corporate_name" value="<?php echo $this->_tpl_vars['corporate_forms']['corporate_name']; ?>
" maxlength="100"/><?php echo $this->_tpl_vars['err']['corporate_name']; ?>
</td>
						</tr>
						<tr>
							<th>フリガナ</th>
							<td><input type="text" class="text" name="another_name" value="<?php echo $this->_tpl_vars['corporate_forms']['another_name']; ?>
" maxlength="100"/><?php echo $this->_tpl_vars['err']['another_name']; ?>
</td>
						</tr>
						<tr>
							<th>部署名</th>
							<td><input type="text" class="text" name="post_name" value="<?php echo $this->_tpl_vars['corporate_forms']['post_name']; ?>
" maxlength="100"/><?php echo $this->_tpl_vars['err']['post_name']; ?>
</td>
						</tr>
						<tr>
							<th>郵便番号</th>
							<td class="floats">
								<input type="text" class="short post1" name="region" value="<?php echo $this->_tpl_vars['region']; ?>
" maxlength="3"/>
								<span> - </span>
								<input type="text" class="short post2" name="branch" value="<?php echo $this->_tpl_vars['branch']; ?>
" maxlength="4"/>
								<span class="btn_blank"><a href="javascript:;" style="position:relative;top:-2px;" class="searchAddress">住所検索</a></span>
								<?php echo $this->_tpl_vars['err']['post_code']; ?>

							</td>
						</tr>
						<tr>
							<th>住所</th>
							<td><input type="text" class="text resultAddress" name="address" value="<?php echo $this->_tpl_vars['corporate_forms']['address']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['address']; ?>
</td>
						</tr>
						<tr>
							<th class="must">TEL</th>
							<td>
								<input type="text" class="short" name="area_code" value="<?php echo $this->_tpl_vars['area_code']; ?>
" maxlength="5"/> - 
								<input type="text" class="short" name="office_number" value="<?php echo $this->_tpl_vars['office_number']; ?>
" maxlength="5"/> - 
								<input type="text" class="short" name="called_number" value="<?php echo $this->_tpl_vars['called_number']; ?>
" maxlength="4"/>
								<?php echo $this->_tpl_vars['err']['tel']; ?>

							</td>
						</tr>
						<tr>
							<th>代表者名</th>
							<td><input type="text" class="text" name="present" value="<?php echo $this->_tpl_vars['corporate_forms']['present']; ?>
" maxlength="50"/><?php echo $this->_tpl_vars['err']['present']; ?>
</td>
						</tr>
						<tr>
							<th>URL</th>
							<td><input type="text" class="text" name="url" value="<?php echo $this->_tpl_vars['corporate_forms']['url']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['url']; ?>
</td>
						</tr>
						<?php if ($this->_tpl_vars['auth'] == '1'): ?>
						<tr>
							<th>備考</th>
							<td><textarea name="memo" maxlength="1000" style="width:400px"><?php echo $this->_tpl_vars['corporate_forms']['memo']; ?>
</textarea><?php echo $this->_tpl_vars['err']['memo']; ?>
</td>
						</tr>
						<?php endif; ?>
					</tbody>
				</table>
				<h4>担当者</h4>
				
				<ul class="btns b10">
					<li class="btn left c"><a href="javascript:;">担当者を追加</a></li>
					<li class="btn right c"><a href="javascript:;">空の担当者を削除</a></li>
				</ul>
				<div id="charge" class="appendArea">
				
				<?php if ($this->_tpl_vars['tantou_forms'] != ''): ?>
					<?php $_from = $this->_tpl_vars['tantou_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['member'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['member']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
        $this->_foreach['member']['iteration']++;
?>
						<table class="formTable">
							<tbody>
								<tr>
									<th <?php if ($this->_tpl_vars['k'] == 0): ?>class="must"<?php endif; ?>>
									<?php if ($this->_tpl_vars['k'] != 0): ?>
										<a href="javascript:;" class="del_item">削除</a>
									<?php endif; ?>
										担当者
									</th>
									<td><input type="text" class="text" name="tantou_name[]" value="<?php echo $this->_tpl_vars['v']['tantou_name']; ?>
" maxlength="100"/><?php echo $this->_tpl_vars['err']['tantou_name'][($this->_foreach['member']['iteration']-1)]; ?>
</td>
								</tr>
								<tr>
									<th <?php if ($this->_tpl_vars['k'] == 0): ?>class="must"<?php endif; ?>>メールアドレス</th>
									<td><input type="text" class="text" name="mail_address[]" value="<?php echo $this->_tpl_vars['v']['mail_address']; ?>
" maxlength="100"/><?php echo $this->_tpl_vars['err']['mail_address'][($this->_foreach['member']['iteration']-1)]; ?>
</td>
								</tr>
								<input type="hidden" name="tantou_id[]" value="<?php echo $this->_tpl_vars['v']['id']; ?>
" />
							</tbody>
						</table>
					<?php endforeach; endif; unset($_from); ?>
				<?php else: ?>
					<table class="formTable">
						<tbody>
							<tr>
								<th class="must">担当者</th>
								<td><input type="text" class="text" name="tantou_name[]" maxlength="100"/></td>
							</tr>
							<tr>
								<th class="must">メールアドレス</th>
								<td><input type="text" class="text" name="mail_address[]" maxlength="100"/></td>
							</tr>
						<input type="hidden" name="tantou_id[]" value="" />
						</tbody>
					</table>
				<?php endif; ?>
				
				</div>
				
				<p class="button">

					<?php if ($this->_tpl_vars['forms']['id']): ?>
						<button type="button" class="btn_back" onclick="GoToRefer()"><span>戻る</span></button>
						<button type="submit" class="btn_update" class="submit"><span>更新</span></button>
					<?php else: ?>
						<!--  
						<button type="button" class="btn_back" onclick="GoToUnregistered()" ><span>戻る</span></button>
						-->
						<button type="button" class="btn_regist" class="submit"><span>登録</span></button>
					<?php endif; ?>
				</p>
				<input type="hidden" name="id" id="id" value="<?php echo $this->_tpl_vars['forms']['id']; ?>
" />
				<input type="hidden" name="mode" value="" />
				<input type="hidden" name="account_id" value="<?php echo $this->_tpl_vars['account_id']; ?>
"  />
				<input type="hidden" name="corporate_id" value="<?php echo $this->_tpl_vars['corporate_id']; ?>
"  />
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
							<?php if ($this->_tpl_vars['auth'] == '1'): ?>
							<li><a href="corporate_search.php?hist=2">一覧に戻る</a></li>
							<?php endif; ?>
							<li><a href="corporate_edit.php?id=<?php echo $this->_tpl_vars['corporate_id']; ?>
">登録した内容を更新</a></li>
						<?php else: ?>
							<li><a href="corporate_unregistered.php">続けて新規登録する</a></li>
							<li><a href="corporate_edit.php?id=<?php echo $this->_tpl_vars['corporate_id']; ?>
">登録した内容を更新</a></li>
						<?php endif; ?>
							
					</ul>
<?php endif; ?>

<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>
</body>
</html>