<?php /* Smarty version 2.6.26, created on 2013-03-25 16:38:02
         compiled from popup_communication_memo.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'popup_communication_memo.html', 271, false),array('function', 'html_options', 'popup_communication_memo.html', 303, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/popup.css" rel="stylesheet" />

<script src="./assets/scripts/popup.js" type="text/javascript"></script>
<title>コントロールパネル</title>

<script type="text/javascript">
function check_num( idnm ){
	var val = $('#' + idnm).val();
	var pid = '#e_' + idnm;
	var tr = $(pid).closest('tr');

	if  ( (val != null) && (val != "") ) {
		if (isNaN(val)) {
			var errmsg = '数字を入力してください';
			$(pid).addClass("error")
			$(pid).html(errmsg);
			tr.addClass("required");
			return false;
		}
	}
	$(pid).html("");
	tr.removeClass("required");
	$(pid).removeClass("error");
	return true;
}
var g_control = 0;
	$(function(){
		setRadioAndCheckbox();
		$("select, input:file").uniform();
		$('table tbody tr:odd').addClass('odd');

		$('#communication_memo .btn_check').unbind('click').live('click',function(e){
			var e_cancel = false;
			if (!check_num( "traffic_fee" )){
				e_cancel = true;
			}
			if (!check_num( "overtime_fee" )){
				e_cancel = true;
			}
			if (!check_num( "live_fee" )){
				e_cancel = true;
			}
			if (!check_num( "other_fee" )){
				e_cancel = true;
			}
			if (e_cancel){
				e.cancel();
			}

			var myDate = new Date();
			var nowtime =  myDate.getTime();
			var deliveCnt = 0;
			if ( g_control == 0){
				g_control = 1;

			$.get("<?php echo $this->_tpl_vars['forms']['nm']; ?>
.php",{ id: <?php echo $this->_tpl_vars['forms']['id']; ?>
,promise_id:<?php echo $this->_tpl_vars['forms']['promise_id']; ?>
  ,spec_id:<?php echo $this->_tpl_vars['forms']['spec_id']; ?>
, service_id:<?php echo $this->_tpl_vars['forms']['service_id']; ?>
,status:<?php echo $this->_tpl_vars['forms']['status']; ?>
 ,spec_id:<?php echo $this->_tpl_vars['forms']['spec_id']; ?>
 ,t:nowtime }, function(data){
				deliveCnt = 1 * data;
				 if ( (deliveCnt * 1) > 0 ) {
						//alert('約定が確定されました。確定メールをお送りします');
						doSave();
				 } else {
					 alert('操作失敗しました、再ログインしてやってみてください');
					 parent.$.colorbox.close();
				 }
			});
			}
		});

	});
	function doSave(){
		var overtime_have = '';
		var overtime_fee = '';
		var traffic_fee_have = '';
		var traffic_fee_master = '';
		var traffic_fee = '';
		var traffic_fee_detail = '';
		var live_fee_have = '';
		var live_fee = '';
		var live_fee_detail = '';
		var other_fee_have = '';
		var other_fee = '';
		var other_fee_name = '';
		var other_fee_detail = '';

		// get overtime_have
		var obj = document.getElementsByName('overtime_have');
		for(var i = 0; i < obj.length; i++){
			if(obj[i].checked == true){
				overtime_have = i;
			}
		}

		// get overtime_fee
		overtime_fee = document.getElementById("overtime_fee").value;
		// get traffic_fee_have
		var obj = document.getElementsByName('traffic_fee_have');
		for(var i = 0; i < obj.length; i++){
			if(obj[i].checked == true){
				traffic_fee_have = i;
			}
		}

		// get traffic_fee_master
		var obj = document.getElementById('traffic_fee_master');
		for(var i = 0; i < obj.length; i++){
			if(obj[i].selected == true){
				traffic_fee_master = i;
			}
		}

		// get traffic_fee
		traffic_fee = document.getElementById("traffic_fee").value;
		// get traffic_fee_detail
		traffic_fee_detail = document.getElementById("traffic_fee_detail").value;

		// get live_fee_have
		var obj = document.getElementsByName('live_fee_have');
		for(var i = 0; i < obj.length; i++){
			if(obj[i].checked == true){
				live_fee_have = i;
			}
		}
		// get live_fee
		live_fee = document.getElementById("live_fee").value;
		// get live_fee_detail
		live_fee_detail = document.getElementById("live_fee_detail").value;
		// get other_fee_have
		var obj = document.getElementsByName('other_fee_have');
		for(var i = 0; i < obj.length; i++){
			if(obj[i].checked == true){
				other_fee_have = i;
			}
		}
		// get other_fee
		other_fee = document.getElementById('other_fee').value;
		// get other_fee_name
		other_fee_name = document.getElementById('other_fee_name').value;
		// get other_fee_detail
		other_fee_detail = document.getElementById('other_fee_detail').value;

		var pro_spec_id = document.getElementById('pro_spec_id').value;

		setCommMemo(pro_spec_id,overtime_have,overtime_fee,traffic_fee_have,traffic_fee_master,traffic_fee,
				traffic_fee_detail,live_fee_have,live_fee,live_fee_detail,other_fee_have,other_fee,other_fee_name,other_fee_detail);
		//parent.$.colorbox.close();
	}
	function showVal(obj){
		if(obj.value == ""){
			document.getElementById("traffic_fee").value = '';
			document.getElementById("traffic_fee_detail").value = '';
			document.getElementById("traffic_fee").setAttribute("disabled","true");
			document.getElementById("traffic_fee_detail").setAttribute("disabled","true");
			return;
		}else{
			document.getElementById("traffic_fee").removeAttribute("disabled");
			document.getElementById("traffic_fee_detail").removeAttribute("disabled");
		}
		var traffic_fee = document.getElementsByName('spec_traffic_fee');
		var traffic_memo = document.getElementsByName('traffic_memo');
		var traffic_name = document.getElementById('traffic_fee_master');
		for(var i = 0; i < traffic_name.length; i++){
			if(i == obj.value){
				document.getElementById("traffic_fee").value =traffic_fee[i].value;
				document.getElementById("traffic_fee_detail").value = traffic_memo[i].value;
			}
		}
	}

	function controlOvertime(){

		var overtime_value;
		var radioObj = document.getElementsByName('overtime_have');
		for(var i=0; i<radioObj.length;i++){
			if(radioObj[i].checked == true){
				overtime_value = i;
			}
		}
		if(overtime_value == '0'){
			document.getElementById("overtime_fee").value="";
			document.getElementById("overtime_fee").setAttribute("disabled","true");
		}else{
			document.getElementById("overtime_fee").removeAttribute("disabled");
		}
	}

	function controlTraFee(){
		var tra_fee_value;
		var radioObj = document.getElementsByName('traffic_fee_have');
		for(var i=0; i<radioObj.length;i++){
			if(radioObj[i].checked == true){
				tra_fee_value = i;
			}
		}

		if(tra_fee_value == '0'){
			document.getElementById("traffic_fee").value="";
			document.getElementById("traffic_fee_detail").value="";
			document.getElementById("traffic_fee").setAttribute("disabled","true");
			document.getElementById("traffic_fee_detail").setAttribute("disabled","true");
			document.getElementById("traffic_fee_master").setAttribute("disabled","true");
		}else{
			document.getElementById("traffic_fee").removeAttribute("disabled");
			document.getElementById("traffic_fee_detail").removeAttribute("disabled");
			document.getElementById("traffic_fee_master").removeAttribute("disabled");
		}


	}

	function controlLiveFee(){
		var livefee_value;
		var radioObj = document.getElementsByName('live_fee_have');
		for(var i=0; i<radioObj.length;i++){
			if(radioObj[i].checked == true){
				livefee_value = i;
			}
		}
		if(livefee_value == '0'){
			document.getElementById("live_fee").value="";
			document.getElementById("live_fee_detail").value="";
			document.getElementById("live_fee").setAttribute("disabled","true");
			document.getElementById("live_fee_detail").setAttribute("disabled","true");
		}else{
			document.getElementById("live_fee").removeAttribute("disabled");
			document.getElementById("live_fee_detail").removeAttribute("disabled");
		}
	}

	function controlOtherFee(){
		var otherfee_value;
		var radioObj = document.getElementsByName('other_fee_have');
		for(var i=0; i<radioObj.length;i++){
			if(radioObj[i].checked == true){
				otherfee_value = i;
			}
		}
		if(otherfee_value == '0'){
			document.getElementById("other_fee").value="";
			document.getElementById("other_fee_name").value="";
			document.getElementById("other_fee_detail").value="";
			document.getElementById("other_fee").setAttribute("disabled","true");
			document.getElementById("other_fee_name").setAttribute("disabled","true");
			document.getElementById("other_fee_detail").setAttribute("disabled","true");
		}else{
			document.getElementById("other_fee").removeAttribute("disabled");
			document.getElementById("other_fee_name").removeAttribute("disabled");
			document.getElementById("other_fee_detail").removeAttribute("disabled");
		}
	}
</script>

</head>
<body>
<div class="thisPopup" id="communication_memo">

<header>
	<h1><span>&nbsp;</span>連絡事項</h1>
</header>

<section id="content">
	<table class="formTable">
		<tbody>
			<tr>
				<th>残業費</th>
				<td>
				<?php if ($this->_tpl_vars['promise_spec_data']['overtime_fee'] == 0): ?>
<?php echo smarty_function_html_radios(array('id' => 'overtime_have','name' => 'overtime_have','onclick' => "controlOvertime()",'options' => $this->_tpl_vars['overtime_have'],'checked' => '0'), $this);?>

				<?php else: ?>
<?php echo smarty_function_html_radios(array('id' => 'overtime_have','name' => 'overtime_have','onclick' => "controlOvertime()",'options' => $this->_tpl_vars['overtime_have'],'checked' => '1'), $this);?>

				<?php endif; ?>
					<input type="text"
					<?php if ($this->_tpl_vars['promise_spec_data']['overtime_fee'] == 0): ?>
						value=""
					<?php else: ?>
						value="<?php echo $this->_tpl_vars['promise_spec_data']['overtime_fee']; ?>
"
					<?php endif; ?>
					id="overtime_fee" name="overtime_fee" class="short" maxlength="10"
					<?php if ($this->_tpl_vars['promise_spec_data']['overtime_fee'] == 0): ?>
						disabled = "true"
					<?php endif; ?>
					/>円
					<p id="e_overtime_fee"></p></td>

			</tr>
			<tr>
				<th>交通費</th>
				<td>
				<?php if ($this->_tpl_vars['promise_spec_data']['traffic_fee'] == 0): ?>
<?php echo smarty_function_html_radios(array('id' => 'traffic_fee_have','name' => 'traffic_fee_have','onclick' => "controlTraFee()",'options' => $this->_tpl_vars['traffic_fee_have'],'checked' => '0'), $this);?>

				<?php else: ?>
<?php echo smarty_function_html_radios(array('id' => 'traffic_fee_have','name' => 'traffic_fee_have','onclick' => "controlTraFee()",'options' => $this->_tpl_vars['traffic_fee_have'],'checked' => '1'), $this);?>

				<?php endif; ?>
					<table>
						<tbody>
							<tr>
								<th>交通費マスタ</th>
								<td>
								<?php if ($this->_tpl_vars['promise_spec_data']['traffic_fee'] == 0): ?>
<?php echo smarty_function_html_options(array('id' => 'traffic_fee_master','name' => 'traffic_fee_master','options' => $this->_tpl_vars['traffic_name'],'onchange' => "showVal(this)",'disabled' => 'true'), $this);?>

								<?php else: ?>
<?php echo smarty_function_html_options(array('id' => 'traffic_fee_master','name' => 'traffic_fee_master','options' => $this->_tpl_vars['traffic_name'],'onchange' => "showVal(this)"), $this);?>

								<?php endif; ?>
								</td>
							</tr>
							<tr>
								<th>金額</th>
								<td>
									<input type="text"

									<?php if ($this->_tpl_vars['promise_spec_data']['traffic_fee'] == 0): ?>
										value=""
									<?php else: ?>
										value="<?php echo $this->_tpl_vars['promise_spec_data']['traffic_fee']; ?>
"
									<?php endif; ?>
									id="traffic_fee" name="traffic_fee" class="short" maxlength="10"
									<?php if ($this->_tpl_vars['promise_spec_data']['traffic_fee'] == 0): ?>
										disabled = "true"
									<?php endif; ?>
									/>円
									<p id="e_traffic_fee"></p>
								</td>
							</tr>
							<tr>
								<th>詳細</th>
								<td>
									<textarea id="traffic_fee_detail" name="traffic_fee_detail" maxlength="1000"
									<?php if ($this->_tpl_vars['promise_spec_data']['traffic_fee'] == 0): ?>
										disabled = "true"
									<?php endif; ?>
									><?php echo $this->_tpl_vars['promise_spec_data']['traffic_fee_detail']; ?>
</textarea>
								</td>
							</tr>
						</tbody>
					</table>
					<p style="color:red;">領収書はプレゴに速やかに郵送ください</p>
				</td>
			</tr>
			<tr>
				<th>宿泊費</th>
				<td>
				<?php if ($this->_tpl_vars['promise_spec_data']['live_fee'] == 0): ?>
<?php echo smarty_function_html_radios(array('id' => 'live_fee_have','name' => 'live_fee_have','onclick' => "controlLiveFee()",'options' => $this->_tpl_vars['live_fee_have'],'checked' => '0'), $this);?>

				<?php else: ?>
<?php echo smarty_function_html_radios(array('id' => 'live_fee_have','name' => 'live_fee_have','onclick' => "controlLiveFee()",'options' => $this->_tpl_vars['live_fee_have'],'checked' => '1'), $this);?>

				<?php endif; ?>
					<input type="text"

					<?php if ($this->_tpl_vars['promise_spec_data']['live_fee'] == 0): ?>
						value = ""
					<?php else: ?>
						value="<?php echo $this->_tpl_vars['promise_spec_data']['live_fee']; ?>
"
					<?php endif; ?>
					 id="live_fee" name="live_fee" class="short" maxlength="10"
					<?php if ($this->_tpl_vars['promise_spec_data']['live_fee'] == 0): ?>
						disabled = "true"
					<?php endif; ?>
					/>円
					<p id="e_live_fee"></p>
				</td>
			</tr>
			<tr>
				<th>詳細</th>
				<td>
					<textarea name="live_fee_detail" id="live_fee_detail" maxlength="1000"
					<?php if ($this->_tpl_vars['promise_spec_data']['live_fee'] == 0): ?>
						disabled = "true"
					<?php endif; ?>
					><?php echo $this->_tpl_vars['promise_spec_data']['live_fee_detail']; ?>
</textarea>
				</td>
			</tr>
			<tr>
				<th>その他</th>
				<td>
				<?php if ($this->_tpl_vars['promise_spec_data']['other_fee'] == 0): ?>
<?php echo smarty_function_html_radios(array('id' => 'other_fee_have','name' => 'other_fee_have','onclick' => "controlOtherFee()",'options' => $this->_tpl_vars['other_fee_have'],'checked' => '0'), $this);?>

				<?php else: ?>
<?php echo smarty_function_html_radios(array('id' => 'other_fee_have','name' => 'other_fee_have','onclick' => "controlOtherFee()",'options' => $this->_tpl_vars['other_fee_have'],'checked' => '1'), $this);?>

				<?php endif; ?>
					<input type="text"
					<?php if ($this->_tpl_vars['promise_spec_data']['other_fee'] == 0): ?>
						value=""
					<?php else: ?>
						value="<?php echo $this->_tpl_vars['promise_spec_data']['other_fee']; ?>
"
					<?php endif; ?>
					 id="other_fee" name="other_fee" class="short" maxlength="10"
					<?php if ($this->_tpl_vars['promise_spec_data']['other_fee'] == 0): ?>
						disabled = "true"
					<?php endif; ?>
					/>円
					<p id="e_other_fee"></p>
				</td>
			</tr>
			<tr>
				<th>名目</th>
				<td><input type="text" name="other_fee_name" id="other_fee_name" value="<?php echo $this->_tpl_vars['promise_spec_data']['other_fee_name']; ?>
" maxlength="100"
					<?php if ($this->_tpl_vars['promise_spec_data']['other_fee'] == 0): ?>
						disabled = "true"
					<?php endif; ?>
				 /></td>
			</tr>
			<tr>
				<th>詳細</th>
				<td><textarea name="other_fee_detail" id="other_fee_detail" maxlength="1000"
					<?php if ($this->_tpl_vars['promise_spec_data']['other_fee'] == 0): ?>
						disabled = "true"
					<?php endif; ?>
				><?php echo $this->_tpl_vars['promise_spec_data']['other_fee_detail']; ?>
</textarea></td>
			</tr>
		</tbody>
		<input type="hidden" name="pro_spec_id" id="pro_spec_id" value="<?php echo $this->_tpl_vars['pro_spec_id']; ?>
" />
		<?php $_from = $this->_tpl_vars['traffic_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
			<input type="hidden" name="spec_traffic_fee" value="<?php echo $this->_tpl_vars['v']; ?>
"/>
		<?php endforeach; endif; unset($_from); ?>
		<?php $_from = $this->_tpl_vars['traffic_memo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
			<input type="hidden" name="traffic_memo" value="<?php echo $this->_tpl_vars['v']; ?>
"/>
		<?php endforeach; endif; unset($_from); ?>

	</table>
</section>

<section id="btn">
	<p>
		<button type="button" class="btn_check"><span>完了報告</span></button>
	</p>
</section>
</div>
</body>
</html>