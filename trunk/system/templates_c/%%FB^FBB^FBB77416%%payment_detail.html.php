<?php /* Smarty version 2.6.26, created on 2013-03-26 10:02:58
         compiled from smp/payment_detail.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'smp/payment_detail.html', 89, false),array('modifier', 'date_format', 'smp/payment_detail.html', 90, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="../assets/styles/default.css" rel="stylesheet" />
<link href="../assets/styles/refer.css" rel="stylesheet" />
<link href="../assets/styles/refer_print.css" rel="stylesheet" media="print" />
<script src="../assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="../assets/scripts/import.js" type="text/javascript"></script>
<script src="../assets/scripts/plugin/jquery.datasort.js" type="text/javascript"></script>
<title>コントロールパネル</title>
<script type="text/javascript">
	$(function(){
		$('.btn_check').unbind('click').live('click',function(){
			var spec_id = $("#spec_id").val();
			var pay_time = $("#pay_time").val();
			var pay_status = $("#pay_status").val();
			var promise_spec_id = $("#promise_spec_id").val();
			var flag = "btn_chk";
			window.location.href="payment_search.php"+"?hist=2&&spec_id="+spec_id+"&&pay_time="+pay_time+"&&flag="+flag+"&&promise_spec_id="+promise_spec_id;
		});

		$('.btn_fix').unbind('click').live('click',function(){
			var spec_id = $("#spec_id").val();
			var pay_time = $("#pay_time").val();
			var pay_status = $("#pay_status").val();
			var promise_spec_id = $("#promise_spec_id").val();
			var flag = "btn_fix";
			window.location.href="payment_search.php"+"?hist=2&&spec_id="+spec_id+"&&pay_time="+pay_time+"&&flag="+flag+"&&promise_spec_id="+promise_spec_id;
		});

	});
	function GoToPaymentRefer(){
		window.location.href="payment_search.php?hist=2";
	}


</script>
</head>
<body id="login">

<header id="dashboard_header">
	<h1>
    	<a href="index.php">コントロールパネル</a>
    </h1>
</header>
	<article id="article" class="load">
		<section id="content">
			<h3>支払参照</h3>
			<div id="view">
				<div id="refer_content">
					<div id="logo">
						<p><img src="../assets/images/common/logo.gif" alt="Prego" /></p>
					</div>
					<div id="firstRow">
						<p class="title">業務委託支払明細書</p>
						<p>日付：<?php echo $this->_tpl_vars['date']; ?>
</p>
					</div>
					<div id="secondRow">
						<p class="left">
							<?php echo $this->_tpl_vars['spec_data']['spec_name']; ?>
 様
						</p>
						<p class="right">
							合同会社Prego<br />
							〒145-0071<br />
							東京都大田区田園調布2-51-4<br />
							第一開発ビル2F<br />
							TEL：03-6459-7355
						</p>
					</div>
					<div id="listTable">
						<h2>業務委託</h2>
		<table class="table1">
			<thead>
				<tr>
					<th>案件名</th>
					<th>サービス名</th>
					<th>スペシャリスト</th>
					<th>金額</th>
					<th>実施日</th>
					<th>備考</th>
				</tr>
			</thead>
			<tbody>
			<?php $_from = $this->_tpl_vars['promise_rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr><td><?php echo $this->_tpl_vars['v']['promise_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['service_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['spec_name']; ?>
</td>
						<td align ="right">￥<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['spec_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
						<td align ="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['v']['doing_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
</td>
						<td></td></tr>
			<?php endforeach; endif; unset($_from); ?>
							</tbody>
						</table>
				<table class="table2">
				<?php if ($this->_tpl_vars['spec_data']['person_choose'] == '0'): ?>
					<tr>
						<th>小計 ： </th>
						<td>￥<?php echo ((is_array($_tmp=$this->_tpl_vars['before_tax'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
					</tr>
					<tr>
						<th>消費税 ： </th>
						<td>￥<?php echo ((is_array($_tmp=$this->_tpl_vars['tax'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
					</tr>
				<?php endif; ?>
					<tr>
						<th class="bold">合計<?php echo $this->_tpl_vars['formsum']['A']; ?>
 ： </th>
						<td class="bold">￥<?php echo ((is_array($_tmp=$this->_tpl_vars['after_tax'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
					</tr>
				</table>
					</div>
<?php if ($this->_tpl_vars['traffic_fee'] > 0): ?>
					<div id="listTable">
						<h2>交通費/経費/材料費</h2>
						<table class="table1">
							<thead>
								<tr>
									<th>案件名</th>
									<th>サービス名</th>
									<th>分類</th>
									<th>金額</th>
									<th>実施日</th>
									<th>備考</th>
								</tr>
							</thead>
							<tbody>
<?php $_from = $this->_tpl_vars['promise_rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
		<?php if ($this->_tpl_vars['v']['overtime_fee'] != 0): ?>
					<tr>
						<td><?php echo $this->_tpl_vars['v']['promise_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['service_name']; ?>
</td>
						<td>残業費</td>
						<td align = "right">￥<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['overtime_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
						<td align ="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['v']['doing_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
</td>
						<td></td>
					</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['v']['traffic_fee'] != 0): ?>
					<tr>
						<td><?php echo $this->_tpl_vars['v']['promise_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['service_name']; ?>
</td>
						<td>交通費</td>
						<td align = "right">￥<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['traffic_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
						<td align ="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['v']['doing_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['traffic_fee_detail']; ?>
</td>
					</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['v']['live_fee'] != 0): ?>
					<tr>
						<td><?php echo $this->_tpl_vars['v']['promise_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['service_name']; ?>
</td>
						<td>宿泊費</td>
						<td align = "right">￥<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['live_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
						<td align ="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['v']['doing_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['live_fee_detail']; ?>
</td>
					</tr>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['v']['overtime_fee'] != 0): ?>
					<tr>
						<td><?php echo $this->_tpl_vars['v']['promise_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['service_name']; ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['other_fee_name']; ?>
</td>
						<td align = "right">￥<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['other_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
						<td align ="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['v']['doing_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
</td>
						<td><?php echo $this->_tpl_vars['v']['other_fee_detail']; ?>
</td>
					</tr>
		<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
							</tbody>
						</table>
						<table class="table2">
							<tr>
								<th class="bold">合計B ： </th>
								<td class="bold">￥<?php echo ((is_array($_tmp=$this->_tpl_vars['traffic_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
							</tr>
						</table>
					</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['other_num'] > 0): ?>
					<div id="listTable">
						<h2>その他</h2>
						<table class="table1">
							<thead>
								<tr>
									<th>内容</th>
									<th>分類</th>
									<th>金額</th>
								</tr>
							</thead>
							<tbody>
							<?php $_from = $this->_tpl_vars['payment_add_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
								<tr>
									<td><?php echo $this->_tpl_vars['v']['content']; ?>
</td>
									<td>支払日前倒し払い交通費</td>
									<td align = "right">￥<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['money'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
								</tr>
							<?php endforeach; endif; unset($_from); ?>
							</tbody>
						</table>
						<table class="table2">
							<tr>
								<th class="bold">合計C ： </th>
								<td class="bold">￥<?php echo ((is_array($_tmp=$this->_tpl_vars['other_num'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
							</tr>
						</table>

					</div>
					<div id="total">
						<dl>
							<dt>合計<?php echo $this->_tpl_vars['formsum']['ALL']; ?>
</dt>
							<dd>￥<?php echo ((is_array($_tmp=$this->_tpl_vars['all_num'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</dd>
						</dl>
					</div>
<?php endif; ?>
					<div id="lastRow">
						<p>支払予定日：<?php echo $this->_tpl_vars['date_now_ym']; ?>
末日</p>
						<ul>
							<li>振込先：</li>
							<li class="large"><?php echo $this->_tpl_vars['spec_data']['bank_name']; ?>
　<?php echo $this->_tpl_vars['spec_data']['shop_name']; ?>
　
							<?php $_from = $this->_tpl_vars['prego_account_kinds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
								<?php if ($this->_tpl_vars['k'] == $this->_tpl_vars['spec_data']['account_kinds']): ?>
									<?php echo $this->_tpl_vars['v']; ?>

								<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?>預金　<?php echo $this->_tpl_vars['spec_data']['account_code']; ?>
</li>
							<li class="large"><?php echo $this->_tpl_vars['spec_data']['account_titular']; ?>
　<?php echo $this->_tpl_vars['spec_data']['account_titular_name']; ?>
</li>
							<li class="small">
								出勤表送付先:　合同会社PREGO　　〒145-0071 東京都大田区田園調布2－51－4　第一開発ビル2F	<br />
								〇内容をご確認いただき、来月3日までにご不明点等ございましたら、プレゴにご連絡下さい。<br />
								〇業務委託支払明細書をプレゴに郵送いただく必要は、ございません。<br />
								〇4日以降のご連絡については、受付できませんので、ご理解のほど、よろしく御願いします。<br />
								出勤表は、月初3日までにプレゴにご郵送いただくよう、よろしくお願い致します。<br />
								尚、出勤表が3日中未着の場合は支払が一カ月遅れる可能性があります。
							</li>
						</ul>
					</div>
				</div>
			</div>

			<input type="hidden" id="spec_id" value="<?php echo $this->_tpl_vars['hidden_spec_id']; ?>
"/>
			<input type="hidden" id="pay_time" value="<?php echo $this->_tpl_vars['hidden_pay_time']; ?>
"/>
			<input type="hidden" id="pay_status" value="<?php echo $this->_tpl_vars['hidden_pay_status']; ?>
"/>
			<input type="hidden" id="promise_spec_id" value="<?php echo $this->_tpl_vars['hidden_promise_spec_id']; ?>
"/>

		</section>
	</article>
<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>

</body>
</html>