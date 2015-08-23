<?php /* Smarty version 2.6.26, created on 2013-04-23 21:42:28
         compiled from specialist_search.html */ ?>
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
				<li><a href="specialist_unregistered.php"><span>未登録一覧</span></a></li>
				<li class="active"><a href="specialist_search.php"><span>スペシャリスト検索</span></a></li>
			</ul>
		</nav>
		<section id="content">
			<h3>検索</h3>
			<?php if ($this->_tpl_vars['auth'] == '1'): ?>
			<div id="search_form">
				<form name="fm" action="specialist_search.php" method="post" >
				<input type="hidden" name="page" />
				<input type="hidden" name="search" value="1" />
				<input type="hidden" name="csv" />
					<dl class="noCmp">
						<dt>フリーワード</dt>
						<dd>
							<input type="text" class="long" name="condition" value="<?php echo $this->_tpl_vars['forms']['condition']; ?>
"/>&nbsp;アカウント名、氏名、住所、電話で検索可能
						</dd>
					</dl>
					<dl class="clear">
						<dt>紹介者への支払有無</dt>
						<dd>
						<?php $_from = $this->_tpl_vars['introducer_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
							<label>
								<input type="checkbox" name="introducer_fee[]" 
								<?php $_from = $this->_tpl_vars['forms']['introducer_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
						<dt>紹介料支払状況</dt>
						<dd>
						<?php $_from = $this->_tpl_vars['introducer_fee_status']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
							<label>
								<input type="checkbox" name="introducer_fee_status[]" 
								<?php $_from = $this->_tpl_vars['forms']['introducer_fee_status']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
						<dt>契約日</dt>
						<dd>
							<input type="text" class="text_date" name="agreement_day_from" value="<?php echo $this->_tpl_vars['forms']['agreement_day_from']; ?>
" />
							～
							<input type="text"  class="text_date" name="agreement_day_to" value="<?php echo $this->_tpl_vars['forms']['agreement_day_to']; ?>
"/>
						</dd>
					</dl>
					<dl>
						<dt>登録料の支払有無</dt>
						<dd>
						<?php $_from = $this->_tpl_vars['login_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
							<label>
								<input type="checkbox" name="login_fee[]" 
								<?php $_from = $this->_tpl_vars['forms']['login_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
						<dt>更新料支払開始年月日</dt>
						<dd>
							<input type="text" class="text_date" name="update_fee_start_time_from" value="<?php echo $this->_tpl_vars['forms']['update_fee_start_time_from']; ?>
"/>
							～
							<input type="text"  class="text_date" name="update_fee_start_time_to" value="<?php echo $this->_tpl_vars['forms']['update_fee_start_time_to']; ?>
"/>
						</dd>
					</dl>
					<dl>
						<dt>契約終了日</dt>
						<dd>
							<input type="text" class="text_date" name="agreement_end_day_from" value="<?php echo $this->_tpl_vars['forms']['agreement_end_day_from']; ?>
"/>
							～
							<input type="text"  class="text_date" name="agreement_end_day_to" value="<?php echo $this->_tpl_vars['forms']['agreement_end_day_to']; ?>
"/>
						</dd>
					</dl>
					<dl>
						<dt>HP掲載可能</dt>
						<dd>
						<?php $_from = $this->_tpl_vars['hp_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
							<label>
								<input type="checkbox" name="hp[]" 
								<?php $_from = $this->_tpl_vars['forms']['hp']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
						<dt>スペシャリスト分野</dt>
						<dd>
							<label><input type="checkbox" name="spec_area_a" <?php if ($this->_tpl_vars['forms']['spec_area_a'] == '1'): ?>checked<?php endif; ?> value="1"/>分野A</label>
							<label><input type="checkbox" name="spec_area_b" <?php if ($this->_tpl_vars['forms']['spec_area_b'] == '1'): ?>checked<?php endif; ?> value="1"/>分野B</label>
							<label><input type="checkbox" name="spec_area_c" <?php if ($this->_tpl_vars['forms']['spec_area_c'] == '1'): ?>checked<?php endif; ?> value="1"/>分野C</label>
							<label><input type="checkbox" name="spec_area_d" <?php if ($this->_tpl_vars['forms']['spec_area_d'] == '1'): ?>checked<?php endif; ?> value="1"/>その他</label>
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
						<th>会員ID</th>
						<th>アカウント名</th>
						<th>氏名</th>
						<th>スペシャリスト分野</th>
						<th>会社名 OR 称号</th>
						<th>住所</th>
						<th>TEL</th>
						<th>携帯TEL</th>
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
						<td><?php echo $this->_tpl_vars['v']['user_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['spec_name']; ?>
</td>
						<td>
							<?php if ($this->_tpl_vars['v']['spec_area_a'] == '1'): ?>分野A<?php endif; ?>
							<?php if ($this->_tpl_vars['v']['spec_area_b'] == '1'): ?>分野B<?php endif; ?>
							<?php if ($this->_tpl_vars['v']['spec_area_c'] == '1'): ?>分野C<?php endif; ?>
							<?php if ($this->_tpl_vars['v']['spec_area_d'] == '1'): ?><?php echo $this->_tpl_vars['v']['spec_area_else']; ?>
<?php endif; ?>
							<?php if ($this->_tpl_vars['v']['spec_area_a'] == '' && $this->_tpl_vars['v']['spec_area_b'] == '' && $this->_tpl_vars['v']['spec_area_c'] == '' && $this->_tpl_vars['v']['spec_area_d'] == ''): ?>
								-
							<?php endif; ?>
						
						</td>
						<td>
						<?php if ($this->_tpl_vars['v']['corporate_name'] == ''): ?>
							-
						<?php else: ?>
							<?php echo $this->_tpl_vars['v']['corporate_name']; ?>
	
						<?php endif; ?>
						</td>
						<td>
						<?php if ($this->_tpl_vars['v']['address'] == ''): ?>
							-
						<?php else: ?>
							<?php echo $this->_tpl_vars['v']['address']; ?>
	
						<?php endif; ?>
						</td>
						<td>
						<?php if ($this->_tpl_vars['v']['tel'] == ''): ?>
							-
						<?php else: ?>
							<?php echo $this->_tpl_vars['v']['tel']; ?>

						<?php endif; ?>
						</td>
						<td>
						<?php if ($this->_tpl_vars['v']['phone'] == ''): ?>
							-
						<?php else: ?>
							<?php echo $this->_tpl_vars['v']['phone']; ?>

						<?php endif; ?>
						</td>
						<td class="update"><a href="specialist_refer.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
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