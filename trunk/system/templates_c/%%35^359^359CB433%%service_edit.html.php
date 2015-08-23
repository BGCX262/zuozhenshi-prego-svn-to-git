<?php /* Smarty version 2.6.26, created on 2013-03-24 23:07:40
         compiled from service_edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'service_edit.html', 47, false),)), $this); ?>
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
function setS( id, val ) {
document.getElementById("category_id").value=id;
document.getElementById("kinds").value=val;
}
</script>
</head>
<body>
<?php echo $this->_tpl_vars['logout']; ?>

<div id="container">
<?php echo $this->_tpl_vars['menu']; ?>

<article id="article" class="load">
		<h2>サービスマスタ</h2>
		<nav>
			<ul>
				<li><a href="service_list.php"><span>一覧</span></a></li>
				<li class="active"><a href="service_edit.php"><span>登録</span></a></li>
				<li><a href="service_category.php"><span>カテゴリ</span></a></li>
			</ul>
		</nav>
		<section id="content">
			<h3>サービスマスタ<?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>更新<?php endif; ?><?php if ($this->_tpl_vars['phase'] == 'complete'): ?>完了<?php endif; ?></h3>
<?php if ($this->_tpl_vars['phase'] == 'input'): ?>
			<p class="message"><?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>更新<?php endif; ?>内容を確認し、<?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>更新<?php endif; ?>ボタンをクリックしてください。</p>
			<form name="fm" action="service_edit.php" method="post">
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
							<th class="must">SKU</th>
							<td><input type="text" class="short" name="sku" value="<?php echo $this->_tpl_vars['forms']['sku']; ?>
" maxlength="100"/><?php echo $this->_tpl_vars['err']['sku']; ?>
</td>
						</tr>
						<tr>
							<th>サービスメニュー</th>
							<td><input type="text" name="service_menu" value="<?php echo $this->_tpl_vars['forms']['service_menu']; ?>
" maxlength="100"/><?php echo $this->_tpl_vars['err']['service_menu']; ?>
</td>
						</tr>
						<tr>
							<th>サービスフィー</th>
							<td><input type="text" name="service_fee" 
							<?php if ($this->_tpl_vars['forms']['service_fee'] == 0): ?>
								value = ""
							<?php else: ?>
								value="<?php echo $this->_tpl_vars['forms']['service_fee']; ?>
"
							<?php endif; ?>
							 maxlength="10"/>円<?php echo $this->_tpl_vars['err']['service_fee']; ?>
</td>
						</tr>
						<tr>
							<th>スペシャリストフィー</th>
							<td><input type="text" name="spec_fee" 
							<?php if ($this->_tpl_vars['forms']['spec_fee'] == 0): ?>
								value = ""
							<?php else: ?>
								value="<?php echo $this->_tpl_vars['forms']['spec_fee']; ?>
" 
							<?php endif; ?>
							maxlength="10"/>円<?php echo $this->_tpl_vars['err']['spec_fee']; ?>
</td>
						</tr>
						<tr>
							<th>キャプション</th>
							<td><textarea name="caption" maxlength="1000"><?php echo $this->_tpl_vars['forms']['caption']; ?>
</textarea><?php echo $this->_tpl_vars['err']['caption']; ?>
</td>
						</tr>
						<tr>
							<th>メモ</th>
							<td><textarea name="memo" maxlength="1000"><?php echo $this->_tpl_vars['forms']['memo']; ?>
</textarea><?php echo $this->_tpl_vars['err']['memo']; ?>
</td>
						</tr>
						<tr>
							<th class="must">カテゴリ</th>
							<td>
								<a href="popup_category_select.php" class="popup btn" >カテゴリ選択</a>
								<input type="hidden" name="category_id" id="category_id" value="<?php echo $this->_tpl_vars['forms']['category_id']; ?>
" />
								<input type="text" name="kinds" id="kinds" value="<?php echo $this->_tpl_vars['forms']['kinds']; ?>
" maxlength="100" readOnly="readOnly" /><?php echo $this->_tpl_vars['err']['kinds']; ?>

							</td>
							
						</tr>
					</tbody>
				</table>
				
				<p class="button">
				<?php if ($this->_tpl_vars['forms']['id']): ?>
					<button type="button" class="btn_update"><span>更新</span></button>
				<?php else: ?>
					<button type="button" class="btn_regist"><span>登録</span></button>
				<?php endif; ?>
				</p>
				<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['forms']['id']; ?>
" />
				<input type="hidden" name="mode" value="" />
			</form>
		</section>
	</article>
</div>

<div id="dialog" >
</div>

<?php endif; ?>
<?php if ($this->_tpl_vars['phase'] == 'complete'): ?>
<p class="message"><?php echo $this->_tpl_vars['message']; ?>
</p>
	<ul class="result_btn">
	<li><a href="service_list.php">一覧に戻る</a></li>
	<?php if ($this->_tpl_vars['forms']['id'] == ''): ?>
	<li><a href="service_edit.php">続けて新規登録する</a></li>
	<?php else: ?>
	<li><a href="service_edit.php?id=<?php echo $this->_tpl_vars['forms']['id']; ?>
">登録した内容を更新</a></li>
	<?php endif; ?>
	</ul>
<?php endif; ?>

<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>
</body>
</html>