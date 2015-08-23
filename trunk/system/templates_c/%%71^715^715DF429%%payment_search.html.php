<?php /* Smarty version 2.6.26, created on 2013-03-24 23:43:55
         compiled from payment_search.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'payment_search.html', 58, false),)), $this); ?>
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

function setSpec(profile_id,profile_name, spec_id, spec_name){
	
	document.getElementById("spec_name").value=spec_name;
	document.getElementById("spec_id").value=spec_id;
}


function setPayAddVal(payment_id,content_temp,money_temp){
	window.location.href="payment_search.php?hist=2&&pay_flag='payment_add'&&content_temp="+content_temp+"&&money_temp="+money_temp+"&&payment_id="+payment_id;
}




</script>
</head>
<body>
<?php echo $this->_tpl_vars['logout']; ?>

<div id="container">
<?php echo $this->_tpl_vars['menu']; ?>

	<article id="article" class="load">
		<h2>支払デスク</h2>
		<nav>
			<ul>
				<li class="active"><a href="payment_search.php"><span>支払検索</span></a></li>
			</ul>
		</nav>
		<section id="content">
			<h3>支払検索</h3>
			<?php if ($this->_tpl_vars['auth'] == '1'): ?>
			<div id="search_form" class="nofix">
				<form name="fm" action="payment_search.php" method="post" >
				<input type="hidden" name="page" />
				<input type="hidden" name="search" value="1" />
				<input type="hidden" name="csv" />
					<dl>
						<dt>スペシャリスト名</dt>
						<dd>
							<input type="text" id="spec_name" name="spec_name" class="float-left" value="<?php echo $this->_tpl_vars['forms']['spec_name']; ?>
" />
							<a href="popup_specialist_select.php" class="popup btn float-left">選択</a>
							<input type="hidden" name="spec_id" id="spec_id" />
						</dd>
					</dl>
					<dl>
						<dt>支払年月</dt>
						<dd class="floats">
<?php echo smarty_function_html_options(array('name' => 'year','options' => $this->_tpl_vars['year'],'selected' => $this->_tpl_vars['forms']['year']), $this);?>
													
							<span>&nbsp;&nbsp;	&nbsp;</span>
<?php echo smarty_function_html_options(array('name' => 'month','options' => $this->_tpl_vars['month'],'selected' => $this->_tpl_vars['forms']['month']), $this);?>
						
						</dd>
					</dl>
					<p class="search_submit">
						<button type="submit" class="submit"><span>検索</span></button>
					</p>
					<input type="hidden" name="" />
				</form>
			</div>
			<?php endif; ?>
<?php if (is_numeric ( $this->_tpl_vars['page']['cnt'] )): ?>
	<?php if ($this->_tpl_vars['page']['cnt'] > 0): ?>
			<p class="message"><?php echo $this->_tpl_vars['page']['cnt']; ?>
件登録されています。</p>
			
			<table id="search_result" class="sortable">
				<thead>
					<tr>
						<th>スペシャリスト名</th>
						<th>支払年月</th>
						<th>操作</th>
						<th>結果</th>
					</tr>
				</thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['payment_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr>
						<td><?php echo $this->_tpl_vars['v']['spec_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['pay_time']; ?>
</td>
						<td class="update">
							<a href="payment_refer.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&pay_time=<?php echo $this->_tpl_vars['v']['pay_time']; ?>
&&pay_status=<?php echo $this->_tpl_vars['v']['pay_status']; ?>
">参照</a>
							<?php if ($this->_tpl_vars['auth'] == '1'): ?><a href="popup_payment_edit.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
" class="popup">追加</a><?php endif; ?>
						</td>
						<td>
						<?php $_from = $this->_tpl_vars['pay_status_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['vv']):
?>
							<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['v']['pay_status']): ?>
								<?php echo $this->_tpl_vars['vv']; ?>

							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?>
						</td>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
			</table>
			<p align="right" class="pageNav"><?php echo $this->_tpl_vars['pageing']; ?>
</p>
	<?php else: ?>
			<p class="message">条件にマッチする情報は見つかりませんでした。</p>
	<?php endif; ?>
<?php else: ?>
			<p class="message">ここに検索結果が表示されます。</p>
<?php endif; ?>	
		</section>
	</article>
</div>
<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>
</body>
</html>