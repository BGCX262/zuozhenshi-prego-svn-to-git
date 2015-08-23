<?php /* Smarty version 2.6.26, created on 2013-03-24 23:07:37
         compiled from service_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'service_list.html', 62, false),)), $this); ?>
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
		<h2>サービスマスタ</h2>
		<nav>
			<ul>
				<li class="active"><a href="service_list.php"><span>一覧</span></a></li>
				<li><a href="service_edit.php"><span>登録</span></a></li>
				<li><a href="service_category.php"><span>カテゴリ</span></a></li>
			</ul>
		</nav>
		<section id="content">
			<form name="fm" action="service_list.php" method="post" >
				<input type="hidden" name="page" />
				<input type="hidden" name="csv" />
			</form>
			<h3>サービスマスタ一覧</h3>
<?php if (is_numeric ( $this->_tpl_vars['page']['cnt'] )): ?>
<?php if ($this->_tpl_vars['page']['cnt'] > 0): ?>
			<p class="message"><?php echo $this->_tpl_vars['page']['cnt']; ?>
件登録されています。</p>
			<p align="left" class="pageNav"><?php echo $this->_tpl_vars['pageing']; ?>
</p>
			<table id="search_result" class="sortable">
				<thead>
					<tr>
						<th>SKU</th>
						<th>サービスメニュー</th>
						<th>スペシャリストフィー</th>
						<th>サービスフィー</th>
						<th>キャプション</th>
						<th>メモ</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr>
						<td><?php echo $this->_tpl_vars['v']['sku']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['service_menu']; ?>
</td>
						<td>
						<?php if ($this->_tpl_vars['v']['service_fee'] == 0): ?>
						<?php else: ?>
							<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['spec_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円
						<?php endif; ?>
						</td>
						<td>
						<?php if ($this->_tpl_vars['v']['service_fee'] == 0): ?>
						<?php else: ?>
							<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['service_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円
						<?php endif; ?>
						</td>
						<td><?php echo $this->_tpl_vars['caption_arr'][$this->_tpl_vars['k']]; ?>
</td>
						<td><?php echo $this->_tpl_vars['memo_arr'][$this->_tpl_vars['k']]; ?>
</td>
						<td class="update"><a href="service_edit.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
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