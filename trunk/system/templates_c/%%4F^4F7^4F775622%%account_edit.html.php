<?php /* Smarty version 2.6.26, created on 2013-03-25 06:31:44
         compiled from account_edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'account_edit.html', 42, false),array('function', 'html_radios', 'account_edit.html', 55, false),)), $this); ?>
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
		<h2>アカウントデスク</h2>
		<nav>
			<ul>
				<li><a href="account_list.php"><span>アカウント検索</span></a></li>
				<li class="active"><a href="account_edit.php"><span>アカウント登録</span></a></li>
			</ul>
		</nav>
		<section id="content">
			<h3>アカウント<?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>情報変更<?php endif; ?><?php if ($this->_tpl_vars['phase'] == 'complete'): ?>完了<?php endif; ?></h3>
<?php if ($this->_tpl_vars['phase'] == 'input'): ?>
			<p class="message"><?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>情報変更<?php endif; ?>内容を確認し、<?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>情報変更<?php endif; ?>ボタンをクリックしてください。</p>
			<form name="fm" action="account_edit.php" method="post" >
				<h4>基本情報</h4>

				<table class="formTable">
					<tbody>
<?php if ($this->_tpl_vars['forms']['id'] != ''): ?>
						<tr>
							<th>ID</th>
							<td>
								<?php echo $this->_tpl_vars['forms']['id']; ?>

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
							<th class="must">種別</th>
							<td>
<?php echo smarty_function_html_radios(array('id' => 'sorts','name' => 'sorts','options' => $this->_tpl_vars['sorts'],'selected' => $this->_tpl_vars['forms']['sorts']), $this);?>
<?php echo $this->_tpl_vars['err']['sorts']; ?>

							</td>
						</tr>
						<tr>
							<th class="must">ログインID</th>
							<td><input type="text" name="login_id" value="<?php echo $this->_tpl_vars['forms']['login_id']; ?>
" maxlength="20"/><?php echo $this->_tpl_vars['err']['login_id']; ?>
</td>
						</tr>
						<tr>
							<th class="must">パスワード</th>
							<td><input type="password" name="login_pwd" value="<?php echo $this->_tpl_vars['forms']['login_pwd']; ?>
" maxlength="50"/><?php echo $this->_tpl_vars['err']['login_pwd']; ?>
</td>
						</tr>
						<tr>
							<th class="must">アカウント名</th>
							<td><input type="text" name="user_name" value="<?php echo $this->_tpl_vars['forms']['user_name']; ?>
" maxlength="100"/><?php echo $this->_tpl_vars['err']['user_name']; ?>
</td>
						</tr>
						<tr>
							<th>状態</th>
							<td><label>
										<input type="checkbox" name="login_flgs"  <?php if ($this->_tpl_vars['forms']['login_flgs'] == '1'): ?> checked="checked" <?php endif; ?> value="1" />
									ログイン不可
								</label>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="button">
					<?php if ($this->_tpl_vars['forms']['id']): ?>
						<button type="submit" class="btn_update" class="submit"><span>情報を変更</span></button>
					<?php else: ?>
						<button type="button" class="btn_regist" class="submit"><span>登録</span></button>
					<?php endif; ?>
				</p>
				<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['forms']['id']; ?>
" />
				<input type="hidden" name="other_id" value="<?php echo $this->_tpl_vars['forms']['other_id']; ?>
" />
				<input type="hidden" name="mode" value="" />
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
							<li><a href="account_list.php?hist=2">一覧に戻る</a></li>
							<li><a href="account_edit.php?id=<?php echo $this->_tpl_vars['forms']['id']; ?>
">登録した内容を更新</a></li>
						<?php else: ?>
							<li><a href="account_edit.php">続けて新規登録する</a></li>
							<li><a href="account_edit.php?id=<?php echo $this->_tpl_vars['forms']['flag']; ?>
">登録した内容を更新</a></li>
						<?php endif; ?>
					</ul>
<?php endif; ?>

<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>
</body>
</html>