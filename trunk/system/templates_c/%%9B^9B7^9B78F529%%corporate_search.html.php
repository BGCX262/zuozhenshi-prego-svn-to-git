<?php /* Smarty version 2.6.26, created on 2013-03-25 13:44:30
         compiled from corporate_search.html */ ?>
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
		<h2>クライアント様デスク</h2>
		<nav>
			<ul>
				<li><a href="corporate_unregistered.php"><span>未登録一覧</span></a></li>
				<li class="active"><a href="corporate_search.php"><span>クライアント検索</span></a></li>
			</ul>
		</nav>
		<section id="content">
			<h3>クライアント情報検索</h3>
			<?php if ($this->_tpl_vars['auth'] == '1'): ?>
			<div id="search_form" class="fw">
				<form name="fm" action="corporate_search.php" method="post">
				<input type="hidden" name="page" />
				<input type="hidden" name="search" value="1" />
				<input type="hidden" name="csv" />
				
					<dl>
						<dt>フリーワード</dt>
						<dd>
							<input type="text" class="long" name="condition" value="<?php echo $this->_tpl_vars['forms']['condition']; ?>
"/><br />
							アカウント名/会社名/フリガナ/住所/TEL/代表者/担当者で検索可能
						</dd>
					</dl>
					<p class="search_submit">
						<button type="submit" class="submit" id="btn-export"><span>検索</span></button>
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
						<th width="3%">ID</th>
						<th width="15%">アカウント名</th>
						<th width="22%">会社名</th>
						<th width="28%">住所</th>
						<th width="10%">TEL</th>
						<th width="10%">代表者</th>
						<th width="6%">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
						<tr>
						<td><?php echo $this->_tpl_vars['v']['id']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['user_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['corporate_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['address']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['tel']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['present']; ?>
</td>
						<td class="update"><a href="corporate_refer.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
">参照</a></td>
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