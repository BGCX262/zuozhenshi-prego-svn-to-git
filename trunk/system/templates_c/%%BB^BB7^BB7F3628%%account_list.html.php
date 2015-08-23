<?php /* Smarty version 2.6.26, created on 2013-03-25 12:20:27
         compiled from account_list.html */ ?>
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
		function toPage(thepage) {
			document.fm.page.value =  thepage;
			document.fm.csv.value="";
			document.fm.submit();
			
		}
	</script>
</head>
<body>
<?php echo $this->_tpl_vars['logout']; ?>

<div id="container">
<?php echo $this->_tpl_vars['menu']; ?>

	<article id="article" class="load">
		<h2>アカウントデスク</h2>
		<nav>
			<ul>
				<li class="active"><a href="account_list.php"><span>アカウント検索</span></a></li>
				<li><a href="account_edit.php"><span>アカウント登録</span></a></li>
			</ul>
		</nav>
		<section id="content">
			<h3>アカウント検索</h3>
			<div id="search_form">
				<form name="fm" action="account_list.php" method="post" >
				<input type="hidden" name="page" />
				<input type="hidden" name="search" value="1" />
				<input type="hidden" name="csv" />
					<dl>
						<dt>アカウント名</dt>
						<dd>
							<input type="text" name="user_name" id="user_name"  value="<?php echo $this->_tpl_vars['forms']['user_name']; ?>
" />
						</dd>
					</dl>
					<dl>
						<dt>種別</dt>
						<dd>
							<?php $_from = $this->_tpl_vars['sorts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
								<label><input type="checkbox" name="sorts[]" 
								<?php $_from = $this->_tpl_vars['forms']['sorts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vv']):
?>
									<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['vv']): ?>
										checked
									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
								 value="<?php echo $this->_tpl_vars['k']; ?>
"/><?php echo $this->_tpl_vars['v']; ?>
</label>
							<?php endforeach; endif; unset($_from); ?>
						</dd>
					</dl>
					<dl>
						<dt>状態</dt>
						<dd>
							<label>
								<input type="checkbox" name="login_flgs" value="1" <?php if ($this->_tpl_vars['forms']['login_flgs'] == '1'): ?>checked <?php endif; ?>/>
								ログイン不可</label>
						</dd>
					</dl>
					<p class="search_submit">
						<button type="submit" class="submit" id="btn-export" ><span>検索</span></button>
					</p>
					<input type="hidden" name="" />
				</form>
			</div>
	<?php if (is_numeric ( $this->_tpl_vars['page']['cnt'] )): ?>
	<?php if ($this->_tpl_vars['page']['cnt'] > 0): ?>
			<p class="message"><?php echo $this->_tpl_vars['page']['cnt']; ?>
件登録されています。</p>
			<p align="left" class="pageNav"><?php echo $this->_tpl_vars['pageing']; ?>
</p>
			<table id="search_result" class="sortable">
				<thead>
					<tr>
						<th>ID</th>
						<th>種別</th>
						<th>状態</th>
						<th>アカウント名</th>
						<th>更新日</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
						<tr>
							<td><?php echo $this->_tpl_vars['k']+1; ?>
</td>
							<td><?php echo $this->_tpl_vars['sorts'][$this->_tpl_vars['v']['sorts']]; ?>
</td>
							<td><?php echo $this->_tpl_vars['login_flgs'][$this->_tpl_vars['v']['login_flgs']]; ?>
</td>
							<td><?php echo $this->_tpl_vars['v']['user_name']; ?>
</td>
							<td><?php echo $this->_tpl_vars['v']['u_time']; ?>
</td>
							<td class="update"><a href="account_edit.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
">更新</a></td>
						</tr>
					<?php endforeach; endif; unset($_from); ?>
				</tbody>
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