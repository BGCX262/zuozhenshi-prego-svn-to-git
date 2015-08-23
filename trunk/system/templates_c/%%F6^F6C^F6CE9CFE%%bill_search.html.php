<?php /* Smarty version 2.6.26, created on 2013-03-24 23:21:57
         compiled from bill_search.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'bill_search.html', 52, false),array('modifier', 'date_format', 'bill_search.html', 81, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/default.css" rel="stylesheet" />
<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="./assets/scripts/import.js" type="text/javascript"></script>
<script src="./assets/scripts/plugin/jquery.datasort.js"
type="text/javascript"></script>
<title>コントロールパネル</title>
<script type="text/javascript">
	function setS(corporate_id,corporate_name) {
		document.getElementById("corporate_name").value = corporate_name;
		document.getElementById("corporate_id").value = corporate_id;
	}
	function setRequestAddVal(request_id,content_temp,money_temp){
		window.location.href="bill_search.php?hist=2&&request_flag='request_add'&&content_temp="+content_temp+"&&money_temp="+money_temp+"&&request_id="+request_id;
	}
</script>
</head>
<body>
	<?php echo $this->_tpl_vars['logout']; ?>

	<div id="container">
		<?php echo $this->_tpl_vars['menu']; ?>

		<article id="article" class="load">
			<h2>請求デスク</h2>
			<nav>
				<ul>
					<li class="active"><a href="bill_search.php"><span>請求検索</span></a></li>
				</ul>
			</nav>
			<section id="content">
				<h3>請求検索</h3>
				<?php if ($this->_tpl_vars['auth'] == '1'): ?>
				<div id="search_form" class="nofix">
					<form name="fm" action="bill_search.php" method="post">
						<input type="hidden" name="page" />
						<input type="hidden" name="search" value="1" />
						<input type="hidden" name="csv" />
						<dl>
							<dt>クライアント名</dt>
							<dd>
								<input type="text" id="corporate_name" name="corporate_name"
									class="float-left" value="<?php echo $this->_tpl_vars['forms']['corporate_name']; ?>
" /> <a
									href="popup_client_select.php" class="popup btn float-left">選択</a>
								<input type="hidden" name="corporate_id" id="corporate_id" />
							</dd>
						</dl>
						<dl>
							<dt>支払年月</dt>
							<dd class="floats">
								<?php echo smarty_function_html_options(array('name' => 'year','options' => $this->_tpl_vars['year'],'selected' => $this->_tpl_vars['forms']['year']), $this);?>
 <span>&nbsp;&nbsp; &nbsp;</span> <?php echo smarty_function_html_options(array('name' => 'month','options' => $this->_tpl_vars['month'],'selected' => $this->_tpl_vars['forms']['month']), $this);?>

							</dd>
						</dl>
						<p class="search_submit">
							<button type="submit" class="submit">
								<span>検索</span>
							</button>

						</p>
						<input type="hidden" name="" />
					</form>
				</div>
				<?php endif; ?> <?php if (is_numeric ( $this->_tpl_vars['page']['cnt'] )): ?> <?php if ($this->_tpl_vars['page']['cnt'] > 0): ?>
				<p class="message"><?php echo $this->_tpl_vars['page']['cnt']; ?>
件登録されています。</p>
				<table id="search_result" class="sortable">
					<thead>
						<tr>
							<th>クライアント名</th>
							<th>支払年月</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php $_from = $this->_tpl_vars['request_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
							<?php $_from = $this->_tpl_vars['mutirow']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vv']):
?>
								<?php if ($this->_tpl_vars['v']['promise_id'] == $this->_tpl_vars['vv']['promise_id']): ?>
									<tr>
										<td><?php echo $this->_tpl_vars['v']['corporate_name']; ?>
</td>
										<td><?php echo ((is_array($_tmp=$this->_tpl_vars['v']['request_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m") : smarty_modifier_date_format($_tmp, "%Y/%m")); ?>
</td>
										<td class="update">
											<a href="bill_refer.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&corporate_id=<?php echo $this->_tpl_vars['v']['corporate_id']; ?>
&&request_time=<?php echo $this->_tpl_vars['v']['request_time']; ?>
&&request_status=<?php echo $this->_tpl_vars['v']['request_status']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
">参照</a>
											<?php if ($this->_tpl_vars['auth'] == '1'): ?><a href="popup_payment_edit.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&model='request_add'" class="popup">追加</a><?php endif; ?>
									</tr>
								<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?>
						<?php endforeach; endif; unset($_from); ?>
				</table>
				<p align="right" class="pageNav"><?php echo $this->_tpl_vars['pageing']; ?>
</p>
				<?php else: ?>
				<p class="message">条件にマッチする情報は見つかりませんでした。</p>
				<?php endif; ?> <?php else: ?>
				<p class="message">ここに検索結果が表示されます。</p>
				<?php endif; ?>
			</section>
		</article>
	</div>
	<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>
</body>
</html>