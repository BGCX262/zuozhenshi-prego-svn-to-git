<?php /* Smarty version 2.6.26, created on 2013-03-24 23:06:12
         compiled from specialist_unregistered.html */ ?>
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
		<h2>スペシャリストデスク</h2>
		<nav>
			<ul>
			<?php if ($this->_tpl_vars['auth'] == '1'): ?>
				<li class="active"><a href="specialist_unregistered.php"><span>未登録一覧</span></a></li>
				<li><a href="specialist_search.php"><span>スペシャリスト検索</span></a></li>
			<?php elseif ($this->_tpl_vars['auth'] == '3'): ?>
				<li class="active"><a href="specialist_edit.php"><span>スペシャリスト情報</span></a></li>
			<?php endif; ?>
			</ul>
		</nav>
		<section id="content">
			<form name="fm" action="specialist_unregistered.php" method="post" >
				<input type="hidden" name="page" />
				<input type="hidden" name="csv" />
			</form>
			<h3>スペシャリスト未登録一覧</h3>
<?php if (is_numeric ( $this->_tpl_vars['page']['cnt'] )): ?>
<?php if ($this->_tpl_vars['page']['cnt'] > 0): ?>
			<p class="message"><?php echo $this->_tpl_vars['page']['cnt']; ?>
件の未登録があります。</p>
			<p align="left" class="pageNav"><?php echo $this->_tpl_vars['pageing']; ?>
</p>
			<table id="search_result" class="sortable">
				<thead>
					<tr>
						<th>ID</th>
						<th>アカウント名</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
					<tr>
						<td><?php echo $this->_tpl_vars['v']['login_id']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['user_name']; ?>
</td>
						<td class="update"><a href="specialist_edit.php?account_id=<?php echo $this->_tpl_vars['v']['id']; ?>
">登録</a></td>
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