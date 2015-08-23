<?php /* Smarty version 2.6.26, created on 2013-03-24 23:22:18
         compiled from bill_refer.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'bill_refer.html', 97, false),array('modifier', 'date_format', 'bill_refer.html', 98, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/default.css" rel="stylesheet" />
<link href="./assets/styles/refer.css" rel="stylesheet" />
<link href="./assets/styles/refer_print.css" rel="stylesheet" media="print" />

<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="./assets/scripts/import.js" type="text/javascript"></script>
<script src="./assets/scripts/plugin/jquery.datasort.js" type="text/javascript"></script>
<title>コントロールパネル</title>
<script type="text/javascript">
	$(function(){
		$('.btn_check').unbind('click').live('click',function(){
			var corporate_id = $("#corporate_id").val();
			var request_time = $("#request_time").val();
			var request_status = $("#request_status").val();
			var promise_id = $("#promise_id").val();
			var flag = "btn_chk";
			window.location.href="bill_search.php"+"?hist=2&&corporate_id="+corporate_id+"&&request_time="+request_time+"&&flag="+flag+"&&promise_id="+promise_id;
		});
		
		$('.btn_fix').unbind('click').live('click',function(){
			var corporate_id = $("#corporate_id").val();
			var request_time = $("#request_time").val();
			var request_status = $("#request_status").val();
			var promise_id = $("#promise_id").val();
			var flag = "btn_fix";
			window.location.href="bill_search.php"+"?hist=2&&corporate_id="+corporate_id+"&&request_time="+request_time+"&&flag="+flag+"&&promise_id="+promise_id;
		});
		
	});
	function GoToBillSearch(){
		window.location.href="bill_search.php?hist=2";
	}
</script>

</head>
<body>
<?php echo $this->_tpl_vars['logout']; ?>

<div id="container">
<?php echo $this->_tpl_vars['menu']; ?>

	<article id="article" class="load">
		<h2>請求デスク</h2>
		<nav>
			<ul>
				<li class="active"><a href="bill_search.php"><span>請求検索</span></a></li>
			</ul>
		</nav>
		<section id="content">
			<h3>請求参照</h3>
			
			<div id="view">
				<div id="refer_content">
					<div id="logo">
						<p><img src="./assets/images/common/logo.gif" alt="Prego" /></p>
					</div>
					<div id="firstRow">
						<p class="title">請求書</p>
						<p>日付：<?php echo $this->_tpl_vars['date']; ?>
</p>
					</div>
					<div id="secondRow">
						<p class="left">
						<?php $_from = $this->_tpl_vars['corporate_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
							<?php echo $this->_tpl_vars['v']['corporate_name']; ?>
<br />
							<?php echo $this->_tpl_vars['v']['post_name']; ?>
<br />
							<?php echo $this->_tpl_vars['v']['present']; ?>
 様
						<?php endforeach; endif; unset($_from); ?>
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
						<td align ="right">￥<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['servers_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
						<td align ="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['v']['doing_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
</td>
						<td></td></tr>
			<?php endforeach; endif; unset($_from); ?>
							</tbody>
						</table>
						<table class="table2">
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
		<?php if ($this->_tpl_vars['v']['other_fee'] != 0): ?>
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
							<?php $_from = $this->_tpl_vars['request_add_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
								<tr>
									<td><?php echo $this->_tpl_vars['v']['content']; ?>
</td>
									<td>支払日前倒し払い交通費</td>
									<td>￥<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['money'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
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
				<?php endif; ?>
					<div id="total">
						<dl>
							<dt>合計<?php echo $this->_tpl_vars['formsum']['ALL']; ?>
</dt>
							<dd>￥<?php echo ((is_array($_tmp=$this->_tpl_vars['all_num'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</dd>
						</dl>
					</div>
					<div id="lastRow">
						<p>支払条件：<?php echo $this->_tpl_vars['date_now_ym']; ?>
末日までに銀行振込</p>
						<ul>
							<li>振込先：</li>
							<li class="large">みずほ銀行　五反田支店　普通預金　2693160</li>
							<li class="large">口座名義　合同会社Prego</li>
							<li class="small">※振込手数料は御社のご負担でお願い致します</li>
						</ul>
					</div>
				</div>
			</div>
			<p class="button">
				<button type="button" class="btn_back" onclick="GoToBillSearch()"><span>戻る</span></button>
				<button type="button" class="btn_print" onclick="print()"><span>印刷</span></button>
				<?php if ($this->_tpl_vars['hidden_request_status'] != '1'): ?>
					<button type="button" class="btn_check"><span>OK</span></button>
				<?php endif; ?>
				<button type="button" class="btn_fix"><span>要修正</span></button>
			</p>
			<input type="hidden" id="corporate_id" value="<?php echo $this->_tpl_vars['hidden_corporate_id']; ?>
"/>
			<input type="hidden" id="request_time" value="<?php echo $this->_tpl_vars['hidden_request_time']; ?>
"/>
			<input type="hidden" id="request_status" value="<?php echo $this->_tpl_vars['hidden_request_status']; ?>
"/>
			<input type="hidden" id="promise_id" value="<?php echo $this->_tpl_vars['hidden_promise_id']; ?>
"/>
		</section>
	</article>
</div>
<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>

<div id="print"></div>

</body>
</html>