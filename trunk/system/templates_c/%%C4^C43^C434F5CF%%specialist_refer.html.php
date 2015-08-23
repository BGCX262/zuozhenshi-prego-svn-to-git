<?php /* Smarty version 2.6.26, created on 2013-04-23 21:42:37
         compiled from specialist_refer.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'specialist_refer.html', 234, false),)), $this); ?>
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
		<h2>スペシャリストデスク</h2>
		<nav>
			<ul>
			<?php if ($this->_tpl_vars['auth'] == '1'): ?>
				<li class="active"><a href="specialist_unregistered.php"><span>未登録一覧</span></a></li>
				<li><a href="specialist_search.php"><span>スペシャリスト検索</span></a></li>
			<?php elseif ($this->_tpl_vars['auth'] == '3'): ?>
				<li class="active"><a href="specialist_refer.php"><span>スペシャリスト情報</span></a></li>
			<?php endif; ?>
			</ul>
		</nav>
		<section id="content">
			<h3>スペシャリスト情報 参照</h3>
			<form name="">
				<h4>基本情報</h4>
				<table class="formTable">
					<tbody>
						<tr>
							<th>会員ID</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['id']; ?>
</td>
						</tr>
						<tr>
							<th>登録日時</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['c_time']; ?>
</td>
						</tr>
						<tr>
							<th>更新日時</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['u_time']; ?>
</td>
						</tr>
						<tr>
							<th>アカウント名</th>
							<td><?php echo $this->_tpl_vars['account_name']; ?>
</td>
						</tr>
						
						<tr>
							<th>氏名</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['spec_name']; ?>
</td>
						</tr>
						<tr>
							<th>アルファベット</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['interlingua']; ?>
</td>
						</tr>
						<tr>
							<th>メールアドレス1</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['mail_address1']; ?>
</td>
						</tr>
						<tr>
							<th>メールアドレス2</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['mail_address2']; ?>
</td>
						</tr>
						<tr>
							<th>スペシャリスト分野</th>
							<td>
							<?php if ($this->_tpl_vars['spec_forms']['spec_area_a'] == '1'): ?>分野A<?php endif; ?>
							<?php if ($this->_tpl_vars['spec_forms']['spec_area_b'] == '1'): ?>分野B<?php endif; ?>
							<?php if ($this->_tpl_vars['spec_forms']['spec_area_c'] == '1'): ?>分野C<?php endif; ?>
							<?php if ($this->_tpl_vars['spec_forms']['spec_area_d'] == '1'): ?><?php echo $this->_tpl_vars['spec_forms']['spec_area_else']; ?>
<?php endif; ?>
							</td>
						</tr>
						<tr>
							<th>会社名 OR 商号</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['corporate_name']; ?>
</td>
						</tr>
						<tr>
							<th>郵便番号</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['post_code']; ?>
</td>
						</tr>
						<tr>
							<th>住所</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['address']; ?>
</td>
						</tr>
						<tr>
							<th>TEL</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['tel']; ?>
</td>
						</tr>
						<tr>
							<th>携帯TEL</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['phone']; ?>
</td>
						</tr>
						<tr>
							<th>FAX</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['fax']; ?>
</td>
						</tr>
						<tr>
							<th>生年月日</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['birthday']; ?>
</td>
						</tr>
<?php if ($this->_tpl_vars['auth'] == '1'): ?>
						<tr>
							<th>紹介者</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['introducer']; ?>
</td>
						</tr>
						<tr>
							<th>紹介者への支払い有無</th>
							<td>
								<?php $_from = $this->_tpl_vars['introducer_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
									<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['spec_forms']['introducer_fee'] && $this->_tpl_vars['spec_forms']['introducer_fee'] != ''): ?>
										<?php echo $this->_tpl_vars['v']; ?>

									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<tr>
							<th>紹介者支払い状況</th>
							<td>
								<?php $_from = $this->_tpl_vars['introducer_fee_status']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
									<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['spec_forms']['introducer_fee_status'] && $this->_tpl_vars['spec_forms']['introducer_fee_status'] != ''): ?>
										<?php echo $this->_tpl_vars['v']; ?>

									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<tr>
							<th>契約日</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['agreement_day']; ?>
</td>
						</tr>
						<tr>
							<th>契約条件</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['agreement_condition']; ?>
</td>
						</tr>
						<tr>
							<th>登録料の支払有無</th>
							<td>
								<?php $_from = $this->_tpl_vars['login_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
									<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['spec_forms']['login_fee'] && $this->_tpl_vars['spec_forms']['login_fee'] != ''): ?>
										<?php echo $this->_tpl_vars['v']; ?>

									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<tr>
							<th>更新料の支払有無</th>
							<td>
								<?php $_from = $this->_tpl_vars['update_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
									<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['spec_forms']['update_fee'] && $this->_tpl_vars['spec_forms']['update_fee'] != ''): ?>
										<?php echo $this->_tpl_vars['v']; ?>

									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<tr>
							<th>更新料支払い開始年月日</th>
							<td class="floats"><?php echo $this->_tpl_vars['spec_forms']['update_fee_start_time']; ?>
</td>
						</tr>
						<tr>
							<th>契約終了日</th>
							<td class="floats"><?php echo $this->_tpl_vars['spec_forms']['agreement_end_day']; ?>
</td>
						</tr>
						<tr>
							<th>HP掲載可能</th>
							<td>
								<?php $_from = $this->_tpl_vars['hp_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
									<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['spec_forms']['hp'] && $this->_tpl_vars['spec_forms']['hp'] != ''): ?>
										<?php echo $this->_tpl_vars['v']; ?>

									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<tr>
							<th>銀行名</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['bank_name']; ?>
</td>
						</tr>
						<tr>
							<th>支店名</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['shop_name']; ?>
</td>
						</tr>
						<tr>
							<th>口座種類</th>
							<td>
								<?php $_from = $this->_tpl_vars['account_kinds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
									<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['spec_forms']['account_kinds'] && $this->_tpl_vars['spec_forms']['account_kinds'] != ''): ?>
										<?php echo $this->_tpl_vars['v']; ?>

									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
						<tr>
							<th>口座番号</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['account_code']; ?>
</td>
						</tr>
						<tr>
							<th>口座名義</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['account_titular']; ?>
</td>
						</tr>
						<tr>
							<th>口座名義フリガナ</th>
							<td><?php echo $this->_tpl_vars['spec_forms']['account_titular_name']; ?>
</td>
						</tr>
						<tr>
							<th>法人 OR 個人選択</th>
							<td>
								<?php $_from = $this->_tpl_vars['person_choose']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
									<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['spec_forms']['person_choose'] && $this->_tpl_vars['spec_forms']['person_choose'] != ''): ?>
										<?php echo $this->_tpl_vars['v']; ?>

									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</td>
						</tr>
<?php endif; ?>
					</tbody>
				</table>

				<h5 style="text-align:left;">交通費情報</h5>

				<table class="formTable" id="table_traffic">
					<thead>
						<tr>
							<th>交通費名称</th>
							<th>交通費</th>
							<th>備考</th>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['spec_traffic_fee_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
						<tr>
							<td><?php echo $this->_tpl_vars['v']['traffic_name']; ?>
</td>
							<td>
							<?php if ($this->_tpl_vars['v']['traffic_fee'] != ''): ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['traffic_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円
							<?php endif; ?>
							</td>
							<td><?php echo $this->_tpl_vars['v']['traffic_memo']; ?>
</td>
						</tr>
					<?php endforeach; endif; unset($_from); ?> 
					</tbody>
				</table>

				<h5 style="text-align:left;">フィー情報</h5>

				<table class="formTable" id="table_fee">
					<thead>
						<tr>
							<th>サービスメニュー</th>
							<th>スペシャリストフィー</th>
							<?php if ($this->_tpl_vars['auth'] == '1'): ?>
							<th>サービスフィー</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['spec_fee_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
						<tr>
							<td><?php echo $this->_tpl_vars['v']['servers_menu']; ?>
</td>
							<td>
							<?php if ($this->_tpl_vars['v']['spec_fee'] != ''): ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['spec_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円
							<?php endif; ?>
							</td>
							<?php if ($this->_tpl_vars['auth'] == '1'): ?>
								<td>
								<?php if ($this->_tpl_vars['v']['servers_fee'] != ''): ?>
									<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['servers_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円
								<?php endif; ?>
								</td>
							<?php endif; ?>
						</tr>
					<?php endforeach; endif; unset($_from); ?>
					</tbody>
				</table>
				<p class="button" style="padding-bottom:20px !important;">
				<button type="button" class="btn_back" onclick="location.href='specialist_search.php?hist=2'" ><span>戻る</span></button>
				<?php if ($this->_tpl_vars['auth'] == '1'): ?>
					<button type="button" class="btn_update no disp" onclick="location.href='specialist_edit.php?id=<?php echo $this->_tpl_vars['forms']['id']; ?>
'"><span>更新</span></button>
				<?php endif; ?>
				</p>
				<h4 class="clear">プロフィール情報</h4>

				<ul class="btns b10">
					<?php if ($this->_tpl_vars['auth'] == '1'): ?>
						<li class="btn left c"><a href="specialist_profile.php?spec_id=<?php echo $this->_tpl_vars['forms']['id']; ?>
">追加</a></li>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['auth'] == '3'): ?>
						<?php if ($this->_tpl_vars['spec_forms'] != ''): ?>
							<li class="btn right c"><a href="mailto:">変更依頼</a></li>
						<?php endif; ?>
					<?php endif; ?>
				</ul>

				<table class="formTable" id="table_fee">
					<thead>
						<tr>
							<th>プロフィール名</th>
							<th>登録日</th>
							<th>更新日</th>
							<?php if ($this->_tpl_vars['auth'] == '1'): ?>
							<th>操作</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['spec_profile_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
						<tr>
							<td class="td_name"><a href="popup_specialist_profile1.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
" class="popup"><?php echo $this->_tpl_vars['v']['profile_name']; ?>
</a></td>
							<td><?php echo $this->_tpl_vars['v']['c_time']; ?>
</td>
							<td><?php echo $this->_tpl_vars['v']['u_time']; ?>
</td>
							
							<?php if ($this->_tpl_vars['auth'] == '1'): ?>
							<td style="width:70px;">
							
							<span class="btn_blank"><a class="blank" href="specialist_profile.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
">更新</a></span></td>
							<?php endif; ?>
						</tr>
					<?php endforeach; endif; unset($_from); ?>
					</tbody>
				</table>
				<!--
				<p class="button">
					<button type="button" class="btn_back" onclick="location.href="";"><span>戻る</span></button>
					<button type="button" class="btn_regist"><span>登録</span></button>
				</p>
				 -->
			</form>
		</section>
	</article>
</div>
<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>
</body>
</html>