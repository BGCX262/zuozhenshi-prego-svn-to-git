<?php /* Smarty version 2.6.26, created on 2013-03-19 11:29:47
         compiled from corporate_refer.html */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/default.css" rel="stylesheet" />
<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="./assets/scripts/import.js" type="text/javascript"></script>
<script src="./assets/scripts/plugin/jquery.datasort.js" type="text/javascript"></script>
<title>コントロールパネル</title>
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
				<li><a href="corporate_unregistered.php"><span>未登録一覧</span></a></li>
				<li class="active"><a href="corporate_search.php"><span>クライアント検索</span></a></li>
			<?php elseif ($this->_tpl_vars['auth'] == '2'): ?>
				<li class="active"><a href="corporate_refer.php"><span>クライアント情報</span></a></li>
			<?php endif; ?>
			</ul>
		</nav>
		<section id="content">
			<h3>クライアント情報 参照</h3>
			<?php if ($this->_tpl_vars['corporate_forms']['id']): ?>
			<form name="">
				<h4>基本情報</h4>

				<table class="formTable">
					<tbody>
						<tr>
							<th>ID</th>
							<td><?php echo $this->_tpl_vars['corporate_forms']['id']; ?>
</td>
						</tr>
						<tr>
							<th>登録日時</th>
							<td><?php echo $this->_tpl_vars['corporate_forms']['c_time']; ?>
</td>
						</tr>
						<tr>
							<th>更新日時</th>
							<td><?php echo $this->_tpl_vars['corporate_forms']['u_time']; ?>
</td>
						</tr>
						<tr>
							<th>アカウント名</th>
							<td><?php echo $this->_tpl_vars['account_name']; ?>
</td>
						</tr>
						<tr>
							<th>会社名</th>
							<td><?php echo $this->_tpl_vars['corporate_forms']['corporate_name']; ?>
</td>
						</tr>
						<tr>
							<th>フリガナ</th>
							<td><?php echo $this->_tpl_vars['corporate_forms']['another_name']; ?>
</td>
						</tr>
						<tr>
							<th>部署名</th>
							<td><?php echo $this->_tpl_vars['corporate_forms']['post_name']; ?>
</td>
						</tr>
						<tr>
							<th>郵便番号</th>
							<td>
							<?php if ($this->_tpl_vars['region'] != '' && $this->_tpl_vars['branch'] != ''): ?>
								<?php echo $this->_tpl_vars['corporate_forms']['post_code']; ?>

							<?php endif; ?>
							</td>
						</tr>
						<tr>
							<th>住所</th>
							<td><?php echo $this->_tpl_vars['corporate_forms']['address']; ?>
</td>
						</tr>
						<tr>
							<th>TEL</th>
							<td>
							<?php if ($this->_tpl_vars['area_code'] != '' && $this->_tpl_vars['office_number'] != '' && $this->_tpl_vars['called_number'] != ''): ?>
								<?php echo $this->_tpl_vars['corporate_forms']['tel']; ?>

							<?php endif; ?>
							</td>
						</tr>
						<tr>
							<th>代表者名</th>
							<td><?php echo $this->_tpl_vars['corporate_forms']['present']; ?>
</td>
						</tr>
						<tr>
							<th>URL</th>
							<td><?php echo $this->_tpl_vars['corporate_forms']['url']; ?>
</td>
						</tr>
						<?php if ($this->_tpl_vars['auth'] == '1'): ?>
							<tr>
								<th>備考</th>
								<td >
									<?php echo $this->_tpl_vars['corporate_forms']['memo']; ?>

								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>

				<h4>担当者</h4>

				<div id="charge" class="appendArea">
				<?php $_from = $this->_tpl_vars['corporate_tantou_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
					<table class="formTable">
						<tbody>
							<tr>
								<th>担当者</th>
								<td><?php echo $this->_tpl_vars['v']['tantou_name']; ?>
</td>
							</tr>
							<tr>
								<th>メールアドレス</th>
								<td><?php echo $this->_tpl_vars['v']['mail_address']; ?>
</td>
							</tr>
						</tbody>
					</table>
				<?php endforeach; endif; unset($_from); ?>
				</div>
				<p class="button">
					<button type="button" class="btn_update no" onclick="location.href='corporate_edit.php?id=<?php echo $this->_tpl_vars['forms']['id']; ?>
'"><span>更新</span></button>
				</p>
			</form>
			<?php else: ?>
			<br>該当クライアント情報は存在しません。
			<?php endif; ?>
		</section>
	</article>
</div>
<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>
</body>
</html>