<?php /* Smarty version 2.6.26, created on 2013-03-24 22:40:55
         compiled from opportunity_search.html */ ?>
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
		<h2>約定デスク</h2>
		<nav>
			<ul>
				<li class="active"><a href="opportunity_search.php"><span><?php if ($this->_tpl_vars['auth'] == '1'): ?>案件検索<?php else: ?>案件情報<?php endif; ?></span></a></li>
				<?php if ($this->_tpl_vars['auth'] == '1'): ?>
					<li><a href="opportunity_edit.php"><span>案件登録</span></a></li>
				<?php endif; ?>
			</ul>
		</nav>
		<section id="content">
			<h3><?php if ($this->_tpl_vars['auth'] == '1'): ?>案件検索<?php else: ?>案件情報<?php endif; ?></h3>
			<?php if ($this->_tpl_vars['auth'] == '1'): ?>
			<div id="search_form" class="noFix fw">
				<form name="fm" action="opportunity_search.php" method="post" >
					<input type="hidden" name="page" />
					<input type="hidden" name="search" value="1" />
					<input type="hidden" name="csv" />
					<dl>
						<dt>フリーワード</dt>
						<dd>
							<input type="text" class="long" name="free_word" value="<?php echo $this->_tpl_vars['forms']['free_word']; ?>
"/>
						</dd>
					</dl>
					<dl>
						<dt>実施日</dt>
						<dd>
							<input type="text" class="text_date" name="doing_time" value="<?php echo $this->_tpl_vars['forms']['doing_time']; ?>
" />
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
件見つかりました。</p>
			<p align="left" class="pageNav"><?php echo $this->_tpl_vars['pageing']; ?>
</p>
			<table id="search_result" class="sortable">
				<thead>
					<tr>
						<th>ID</th>
						<th>案件名</th>
						<th>クライアント</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr>
						<td><?php echo $this->_tpl_vars['v']['id']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['promise_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['corporate_name']; ?>
</td>
						<?php if ($this->_tpl_vars['doing_time'] != ''): ?>
							<td class="update"><a href="opportunity_refer.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
">参照</a></td>
							<!-- &&doing_time=<?php echo $this->_tpl_vars['doing_time']; ?>
 -->
						<?php else: ?>
							<td class="update"><a href="opportunity_refer.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
">参照</a></td>
						<?php endif; ?>
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