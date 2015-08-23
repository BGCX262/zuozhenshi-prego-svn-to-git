<?php /* Smarty version 2.6.26, created on 2013-03-24 22:41:15
         compiled from opportunity_refer.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'opportunity_refer.html', 183, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/default.css" rel="stylesheet" />
<link href="./assets/styles/page/opportunity_refer.css" rel="stylesheet" media="print" />
<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="./assets/scripts/import.js" type="text/javascript"></script>
<script src="./assets/scripts/plugin/jquery.datasort.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function(){
		var t1 = $('#table1');
		var t2 = $('#table2');
		
		$('#original1').clone().appendTo(t1);
		$('#original2').clone().appendTo(t2);
		
		var removeCell = function(){
			var t1 = $('#table1');
			$('.t1_client',t1).html("お取引先様名");
			var t2 = $('#table2');
			$('.re',t2).remove();
		}
		removeCell();
		$('.btn_help').unbind().click(function(){
			$('a',this).click();
		});
		
		<?php if ($this->_tpl_vars['thankanswer']): ?>
			alert("ご協力ありがとうございました");
		<?php endif; ?>
	});
	
	
var temp;
function setObj(obj){
	temp = $(obj).parent().prev().prev().prev();
}
function locaRefresh(){
	var myDate = new Date();
	var nowtime =  myDate.getTime();
	window.location.href="opportunity_refer.php?id=<?php echo $this->_tpl_vars['promise_forms']['id']; ?>
&tt=" + nowtime;
}
function SetContractHelp(){
	//var promise_id = document.getElementById("id").value;
	window.location.href="opportunity_refer.php?id=<?php echo $this->_tpl_vars['promise_forms']['id']; ?>
";
}
function setSpecAgree(){
	var promise_id = document.getElementById("id").value;
	window.location.href="opportunity_refer.php?id="+promise_id;
}

function setCommMemo(pro_spec_id,overtime_have,overtime_fee,traffic_fee_have,traffic_fee_master,traffic_fee,
		traffic_fee_detail,live_fee_have,live_fee,live_fee_detail,other_fee_have,other_fee,other_fee_name,other_fee_detail){
	var str = "&&pro_spec_id="+pro_spec_id+"&&overtime_have="+overtime_have+"&&overtime_fee="+overtime_fee+"&&traffic_fee_have="+traffic_fee_have+"&&traffic_fee_master="+traffic_fee_master;
	str += "&&traffic_fee="+traffic_fee+"&&traffic_fee_detail="+traffic_fee_detail+"&&live_fee_have="+live_fee_have+"&&live_fee="+live_fee;
	str += "&&live_fee_detail="+live_fee_detail+"&&other_fee_have="+other_fee_have+"&&other_fee="+other_fee+"&&other_fee_name="+other_fee_name+"&&other_fee_detail="+other_fee_detail;
	var promise_id = document.getElementById("id").value;
	window.location.href="opportunity_refer.php?id="+promise_id+str;
}

function SetCancelFee(){
	var promise_id = document.getElementById("id").value;
	window.location.href="opportunity_refer.php?id="+promise_id;
}

function SetConfirmCancel(){
	var promise_id = document.getElementById("id").value;
	window.location.href="opportunity_refer.php?id="+promise_id;
}

function SetSatisfy(count_id,satisfy_status){
	var promise_id = document.getElementById("id").value;
	window.location.href="opportunity_refer.php?id="+promise_id+"&&satisfy_status="+satisfy_status+"&&count_id="+count_id+"&enquete=yes";
}

function GoToSearch(){
	window.location.href="opportunity_search.php?hist=2";
}

</script>

<style type="text/css">
	#print {
		display:none;
	}
</style>

<title>コントロールパネル</title>
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
			<h3>案件情報参照</h3>
			<form name="fm" action="opportunity_edit.php" method="get">
				<input type="hidden" id="id" name="id" value="<?php echo $this->_tpl_vars['promise_forms']['id']; ?>
"/>
			
			<h4>基本情報</h4>
			<table class="formTable" id="original1">
				<tbody>
					<tr>
						<th>ID</th>
						<td><?php echo $this->_tpl_vars['promise_forms']['id']; ?>
</td>
					</tr>
					<tr>
						<th>登録日時</th>
						<td><?php echo $this->_tpl_vars['promise_forms']['u_time']; ?>
</td>
					</tr>
					<tr>
						<th>更新日時</th>
						<td><?php echo $this->_tpl_vars['promise_forms']['c_time']; ?>
</td>
					</tr>
					<tr>
						<th class="t1_client">クライアント</th>
						<td><?php echo $this->_tpl_vars['promise_forms']['corporate_name']; ?>
</td>
					</tr>
					<tr>
						<th>案件名</th>
						<td><?php echo $this->_tpl_vars['promise_forms']['promise_name']; ?>
</td>
					</tr>
				</tbody>
			</table>
			
			<h4>サービス情報</h4>
			<table id="search_result" class="sortable">
				<thead>
					<tr>
						<th width="3%">ID</th>
						<th width="20%">スペシャリスト</th>
						<th>サービス名</th>
						<th width="10%">実施日</th>
						<th width="12%">価格</th>
						<th class="btn_help" width="10%">約定状況<a href="popup_contract_help.php" class="popup">ヘルプ</a></th>
						<th width="5%">完了F</th>
						<th>CF</th>
						<th>操作ボタン</th>
						<th>処理履歴</th>
						<?php if ($this->_tpl_vars['auth'] != '3'): ?>
						<th>アンケート</th>
						<?php endif; ?>
					</tr>
				</thead>
				<tbody>
				<?php $_from = $this->_tpl_vars['promise_spec_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
					<tr>
						<td><?php echo $this->_tpl_vars['v']['id']; ?>
</td>
						<td class="td_name"><?php if ($this->_tpl_vars['v']['spec_name'] != ''): ?><?php echo $this->_tpl_vars['v']['spec_name']; ?>
<?php else: ?>-<?php endif; ?><br/>
							<a href="popup_specialist_profile1.php?id=<?php echo $this->_tpl_vars['v']['profile_id']; ?>
" class="popup">
								<?php $_from = $this->_tpl_vars['fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
									<?php if ($this->_tpl_vars['v']['profile_id'] == $this->_tpl_vars['vv']['profile_id'] && $this->_tpl_vars['v']['service_name'] == $this->_tpl_vars['vv']['service_name']): ?>
										<?php echo $this->_tpl_vars['vv']['profile_name']; ?>

									<?php endif; ?>
								<?php endforeach; endif; unset($_from); ?>
							</a>
						</td>
						<td><?php if ($this->_tpl_vars['v']['service_name'] != ''): ?><?php echo $this->_tpl_vars['v']['service_name']; ?>
<?php else: ?>-<?php endif; ?></td>
						<td>
							<?php if ($this->_tpl_vars['v']['doing_time'] != ''): ?>
								<?php echo $this->_tpl_vars['v']['dodate']; ?>
<br><?php echo $this->_tpl_vars['v']['dotime']; ?>

							<?php else: ?>
								-
							<?php endif; ?>
						</td>
						<td>
							<?php if ($this->_tpl_vars['v']['profile_id'] != ''): ?>
								<?php if ($this->_tpl_vars['fee'] != ''): ?>
									<?php $_from = $this->_tpl_vars['fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
										<?php if ($this->_tpl_vars['v']['profile_id'] == $this->_tpl_vars['vv']['profile_id'] && $this->_tpl_vars['v']['service_name'] == $this->_tpl_vars['vv']['service_name']): ?>
											<?php if ($this->_tpl_vars['auth'] == '2'): ?>
												<?php echo ((is_array($_tmp=$this->_tpl_vars['vv']['servers_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円
											<?php elseif ($this->_tpl_vars['auth'] == '3'): ?>
												<?php echo ((is_array($_tmp=$this->_tpl_vars['vv']['spec_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円
											<?php else: ?>
												<?php echo ((is_array($_tmp=$this->_tpl_vars['vv']['spec_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円/<?php echo ((is_array($_tmp=$this->_tpl_vars['vv']['servers_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円
											<?php endif; ?>
										<?php endif; ?>
									<?php endforeach; endif; unset($_from); ?>
								<?php else: ?>
									-
								<?php endif; ?>							
							<?php else: ?>
								-
							<?php endif; ?>
						</td>
						
						<!-- TODO -->
						<?php if ($this->_tpl_vars['v']['status'] == '0'): ?>
								<?php if ($this->_tpl_vars['auth'] == '2'): ?>
									<td>未発注</td>
									<td>-</td>
									<td>-</td>
									<td class="wide">
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&nm=popup_client_agreement" class="popup" >発注確定</a>
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&nm=popup_cancel_fee" class="popup">キャンセル</a>
									</td>
								<?php elseif ($this->_tpl_vars['auth'] == '3'): ?>
									<td>未発注</td>
									<td>-</td>
									<td>-</td>
									<td>-</td>
								<?php else: ?>
									<td>未発注</td>
									<td>-</td>
									<td>-</td>
									<td class="wide">
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&nm=popup_client_agreement" class="popup" >発注確定</a>
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&nm=popup_cancel_fee" class="popup">キャンセル</a>
									</td>
								<?php endif; ?>
						<?php elseif ($this->_tpl_vars['v']['status'] == '1'): ?>
								<?php if ($this->_tpl_vars['auth'] == '2'): ?>
									<td>発注確定</td>
									<td>-</td>
									<td>-</td>
									<td class="wide">
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&nm=popup_cancel_fee" class="popup">キャンセル</a>
									</td>
								<?php elseif ($this->_tpl_vars['auth'] == '3'): ?>
									<td>発注確定</td>
									<td>-</td>
									<td>-</td>
									<td class="wide">
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&nm=popup_specialist_agreement" class="popup" >受注確定</a>
									</td>
								<?php else: ?>
									<td>発注確定</td>
									<td>-</td>
									<td>-</td>
									<td class="wide">
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&nm=popup_specialist_agreement" class="popup" >受注確定</a>
									</td>
								<?php endif; ?>
						<?php elseif ($this->_tpl_vars['v']['status'] == '2'): ?>
								<?php if ($this->_tpl_vars['auth'] == '2'): ?>
									<td>約定確定</td>
									<td>-</td>
									<td>-</td>
									<td class="wide">
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&nm=popup_cancel_fee" class="popup">キャンセル</a>
									</td>
								<?php elseif ($this->_tpl_vars['auth'] == '3'): ?>
									<td>約定確定</td>
									<td>-</td>
									<td>-</td>
									<td class="wide">
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&nm=popup_communication_memo" class="popup" >業務完了</a>
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&nm=popup_confirm_cancel" class="popup">業務実施無し</a>
									</td>
								<?php else: ?>
									<td>約定確定</td>
									<td>-</td>
									<td>-</td>
									<td class="wide">
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&nm=popup_communication_memo" class="popup" >業務完了</a>
										<a href="popup_all_states.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&status=<?php echo $this->_tpl_vars['v']['status']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
&&nm=popup_confirm_cancel" class="popup">業務実施無し</a>
									</td>
								<?php endif; ?>
						<?php elseif ($this->_tpl_vars['v']['status'] == '3'): ?>
								<?php if ($this->_tpl_vars['auth'] == '2'): ?>
									<td>業務完了</td>
									<td>O</td>
									<td>-</td>
									<td>-</td>
								<?php elseif ($this->_tpl_vars['auth'] == '3'): ?>
									<td>業務完了</td>
									<td>O</td>
									<td>-</td>
									<td>-</td>
								<?php else: ?>
									<td>業務完了</td>
									<td>O</td>
									<td>-</td>
									<td>-</td>
								<?php endif; ?>
						<?php elseif ($this->_tpl_vars['v']['status'] == '4'): ?>
								<?php if ($this->_tpl_vars['auth'] == '2'): ?>
									<td>キャンセル済</td>
									<td>-</td>
									<td>O</td>
									<td>-</td>
								<?php elseif ($this->_tpl_vars['auth'] == '3'): ?>
									<td>キャンセル済</td>
									<td>-</td>
									<td>O</td>
									<td>-</td>
								<?php else: ?>
									<td>キャンセル済</td>
									<td>-</td>
									<td>O</td>
									<td>-</td>
								<?php endif; ?>
						<?php elseif ($this->_tpl_vars['v']['status'] == '5'): ?>
								<?php if ($this->_tpl_vars['auth'] == '2'): ?>
									<td>業務Ｓキャンセル</td>
									<td>-</td>
									<td>O</td>
									<td>-</td>
								<?php elseif ($this->_tpl_vars['auth'] == '3'): ?>
									<td>業務Ｓキャンセル</td>
									<td>-</td>
									<td>O</td>
									<td>-</td>
								<?php else: ?>
									<td>業務Ｓキャンセル</td>
									<td>-</td>
									<td>O</td>
									<td>-</td>
								<?php endif; ?>
						<?php endif; ?>
						<td class="update align-center"><a href="popup_process_history.php?promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&&promise_spec_id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
" class="popup">参照</a></td>
						<?php if ($this->_tpl_vars['auth'] != '3'): ?>
							<?php if ($this->_tpl_vars['v']['status'] == '3'): ?>
								<?php if ($this->_tpl_vars['v']['satisfy_status'] == '01'): ?>
									<td class="wide align-center">不満足</td>
								<?php elseif ($this->_tpl_vars['v']['satisfy_status'] == '02'): ?>
									<td class="wide align-center">満足した</td>
								<?php elseif ($this->_tpl_vars['v']['satisfy_status'] == '03'): ?>
									<td class="wide align-center">どちらでもない</td>
								<?php else: ?>
									<td class="wide align-center"><a href="popup_enquete.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&promise_id=<?php echo $this->_tpl_vars['v']['promise_id']; ?>
&promise_spec_id=<?php echo $this->_tpl_vars['v']['id']; ?>
&spec_id=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
&service_id=<?php echo $this->_tpl_vars['v']['service_id']; ?>
" class="popup">アンケート</a></td>
								<?php endif; ?>
							<?php else: ?>
								<td>-</td>
							<?php endif; ?>
						<?php endif; ?>
					</tr>
				<?php endforeach; endif; unset($_from); ?>
				</tbody>
			</table>
			<p class="button">
				<button type="button" class="btn_back" onclick="GoToSearch()"><span>戻る</span></button>
				<?php if ($this->_tpl_vars['auth'] == '1'): ?>
					<button type="submit" class="btn_update disp"><span>更新</span></button>
				<?php endif; ?>
				<button type="button" class="btn_print_wide" onclick="print();"><span>業務約定書を印刷する</span></button>
			</p>
			</form>
		</section>
	</article>
</div>
<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>

<div id="print">
	<p id="print_logo">
		<img src="./assets/images/common/logo.gif" alt="Prego" /><br />
	</p>
	<p id="print_text">
		合同会社プレゴ<br />
		〒145-0071<br />
		東京都大田区田園調布2-51-4 第一開発ビル2F
	</p>
	<div id="table1"></div>
	<div id="table2"></div>
	<ul id="print_list">
		<li><strong>未発注</strong>：約定がされていません。スペシャリストのスケジュール確保はこの状態では、確定できていません。</li>
		<li><strong>発注確定</strong>：クライアント様がプレゴに発注した状態です。スペシャリストのスケジュール確保はこの状態では、確定できていません。</li>
		<li><strong>約定確定</strong>：クライアント様がプレゴに発注し、スペシャリストが受託を確定しています。スペシャリストのスケジュール確保が決定しています。</li>
		<li><strong>キャンセル済</strong>：約定がキャンセルされた状態です。</li>
		<li><strong>業務完了</strong>：約定された業務が遂行完了された状態です。</li>
		<li><strong>業務Ｓキャンセル</strong>：天変地異、悪天候、突然の傷病などで業務が遂行されなかった状態です。</li>
	</ul>
	<p id="print_last">
		キャンセル等の委託条件については、委託規定をご参照ください。<br />
		プレゴへのお問い合わせ・ご利用を誠にありがとうございます。
	</p>
</div>

</body>
</html>