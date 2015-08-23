<?php /* Smarty version 2.6.26, created on 2013-03-25 16:25:25
         compiled from opportunity_edit.html */ ?>
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
$(function() {

	$("#btn_regist").hide();


	$('.text_date').live('click',function(){

		if(!$(this).hasClass("hasDatepicker")){
			$(this).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: 'yy-mm-dd'
			});
			$(this).blur();
			$(this).focus();
		}
	});


	$('.del_item').live("click",function(){
		var deleteItem = function(){
			that.closest("table").remove();
		}
		var that = $(this);
		var v = $('input[type=text]',$(this).closest('tr')).val();
		if(v != ""){
			customConfirm('削除しますか？',"",$(this),function(){
				deleteItem();
			});
		}else {
			deleteItem();
		}
	});

	/*
	$(".smartspinner").live('click',function(){
		if(!$(this).hasClass('onSpin')){
			$(this).spinit({ width:54, height: 20});
			$(this).blur();
			$(this).focus();
		}
	});
	*/



	$('.single').click(function(){
		//$("#specialist").append(html);
	});

	$('.btn_copy').unbind().click(function(e){
		$("#id").val("");
		$(".text_date").each(function(){
			$(this).val(null);
		});
		$(".spin_time").each(function(){
			$(this).val(null);
		});
		$(".spin_minute").each(function(){
			$(this).val(null);
		});
		$(".btn_update").hide();
		$(".btn_copy").hide();
		$(".btn_regist").show();
		$(".btn_back").hide();
	});

	var radio_id;
	var radio_id_flag;
	var input_id_flag;
	var overtime_fee_id;
	$(".overtime_have").click(function(obj){
		radio_id = $(this).attr("id");
		radio_id_flag = radio_id.substr(15);
		input_id_flag = radio_id.substr(13,1);
		overtime_fee_id = "overtime_fee_"+input_id_flag;

		if(radio_id_flag == '0'){
			$("#"+overtime_fee_id).val("");
			$("#"+overtime_fee_id).attr("disabled","true");
		}else{
			$("#"+overtime_fee_id).removeAttr("disabled");
		}
	});

	var traffic_fee_have_id;
	var traffic_fee_have_id_flag;
	var traffic_fee_flag;
	var traffic_fee_detail_flag;
	var traffic_fee_id;
	var traffic_fee_detail_id;
	$(".traffic_fee_have").click(function(obj){
		traffic_fee_have_id = $(this).attr("id");
		traffic_fee_have_id_flag = traffic_fee_have_id.substr(18);
		traffic_fee_flag = traffic_fee_have_id.substr(16,1);
		traffic_fee_id = "traffic_fee_"+traffic_fee_flag;
		traffic_fee_detail_id = "traffic_fee_detail_"+traffic_fee_flag;

		if(traffic_fee_have_id_flag == '0'){
			$("#"+traffic_fee_id).val("");
			$("#"+traffic_fee_detail_id).val("");
			$("#"+traffic_fee_id).attr("disabled","true");
			$("#"+traffic_fee_detail_id).attr("disabled","true");
		}else{
			$("#"+traffic_fee_id).removeAttr("disabled");
			$("#"+traffic_fee_detail_id).removeAttr("disabled");
		}

	});

	var live_fee_have_id;
	var live_fee_have_id_flag;
	var live_fee_flag;
	var live_fee_id;
	var live_fee_detail_id;
	$(".live_fee_have").click(function(obj){
		live_fee_have_id = $(this).attr("id");
		live_fee_have_id_flag = live_fee_have_id.substr(15);
		live_fee_flag = live_fee_have_id.substr(13,1);
		live_fee_id = "live_fee_"+live_fee_flag;
		live_fee_detail_id = "live_fee_detail_"+live_fee_flag;

		if(live_fee_have_id_flag == '0'){
			$("#"+live_fee_id).val("");
			$("#"+live_fee_detail_id).val("");
			$("#"+live_fee_id).attr("disabled","true");
			$("#"+live_fee_detail_id).attr("disabled","true");
		}else{
			$("#"+live_fee_id).removeAttr("disabled");
			$("#"+live_fee_detail_id).removeAttr("disabled");
		}

	});

	var other_fee_have_id;
	var other_fee_have_id_flag;
	var other_fee_flag;
	var other_fee_id;
	var other_fee_name_id;
	var other_fee_detail_id;
	$(".other_fee_have").click(function(obj){
		other_fee_have_id = $(this).attr("id");
		other_fee_have_id_flag = other_fee_have_id.substr(16);
		other_fee_flag = other_fee_have_id.substr(14,1);
		other_fee_id = "other_fee_"+other_fee_flag;
		other_fee_name_id = "other_fee_name_"+other_fee_flag;
		other_fee_detail_id = "other_fee_detail_"+other_fee_flag;

		if(other_fee_have_id_flag == '0'){
			$("#"+other_fee_id).val("");
			$("#"+other_fee_name_id).val("");
			$("#"+other_fee_detail_id).val("");
			$("#"+other_fee_id).attr("disabled","true");
			$("#"+other_fee_name_id).attr("disabled","true");
			$("#"+other_fee_detail_id).attr("disabled","true");
		}else{
			$("#"+other_fee_id).removeAttr("disabled");
			$("#"+other_fee_name_id).removeAttr("disabled");
			$("#"+other_fee_detail_id).removeAttr("disabled");
		}

	});
/*
	$('#service_master #content table tbody tr .preview a').live('click',function(){
		var tr = $(this).closest("tr");
		var sku = tr.children().html();
		var service_menu = tr.children().next().html();
		//var spec_fee = tr.children().next().next().html();
		//var service_fee = tr.children().next().next().next().html();
		var caption = tr.children().next().next().next().next().html();
		var memo = tr.children().next().next().next().next().next().html();
		//var service_id = tr.children().next().next().next().next().next().next().children().val();
		var id =  tr.attr("id") ;
		var service_id = id.split("_")[1];
		var refarr =  tr.attr("ref").split("_") ;
		var spec_fee = refarr[0];
		var service_fee = refarr[1];
		var model = $("#model").val();

		if (model == 'specl'){
			if (setSpec(service_id,service_menu,spec_fee,service_fee)){
				parent.$.colorbox.close();
			}else {
				return;
			}
		}else if( model != '' ){
			setSpec(service_id,service_menu,spec_fee,service_fee);

		}else{
			setService(service_menu,service_id);
		}
		parent.$.colorbox.close();

	});
	*/
});

function setServiceMaster(service_id, service_menu,spec_fee, service_fee ){
	setService(service_menu,service_id);
	/*
	var model = $("#model").val();
	if (model == 'specl'){
		if (setSpec(service_id,service_menu,spec_fee,service_fee)){
			parent.$.colorbox.close();
			return;
		}else {
			return;
		}
	}else if( model != '' ){
		setSpec(service_id,service_menu,spec_fee,service_fee);
	}else{
		setService(service_menu,service_id);
	}
	*/
	parent.$.colorbox.close();
}

function setS(corporate_id,corporate_name){

	document.getElementById("corporate_name").value = corporate_name;
	document.getElementById("corporate_id").value = corporate_id;
}

var table_num ;
function setSpec(profile_id,profile_name, spec_id, spec_name){
	var model = $("#model").val();
	table_num = $(".accordionTable").length;

	var html = '<table class="formTable accordionTable">';
	html += '<thead><tr><th colspan="2">スペシャリスト</th></tr></thead>';
	html += '<tbody>';
	html += '<tr><th><a href="javascript:;" class="del_item">削除</a> スペシャリスト</th><td><input type="text" class="text" id="spec_name"  value="' + spec_name + '" name="spec_name[]" maxlength="100" readOnly="readOnly"/><br />';
	html += '<input type="text" class="text" id="profile_name" name="profile_name[]" value="' + profile_name + '" readOnly="readOnly"/>';
	html += '<input type="hidden" name="profile_id[]" id="profile_id" value="' + profile_id + '" />';
	html += '<input type="hidden" id="spec_id" name="spec_id[]" value="' +spec_id + '" /></td></tr>';
	html += '<tr><th>サービス</th>	<td><a href="popup_service_master.php?sid=' +spec_id + '" onclick="show(this)" class="popup btn">選択する</a><input style="border:0;box-shadow:none;background-color:transparent" type="text" class="text" name="service_name[]" value="" maxlength="100" readOnly="readOnly"/><input type="hidden" class="text" name="service_id[]" value=""/></td></tr>';
	html += '<tr><th>実施日</th>	<td class="floats"><input type="text" class="text_date" name="day[]"/><input type="text" name="hour[]" value="" class="smartspinner spin_time" maxlength="2"/><span>時&nbsp;</span>	<input type="text" name="minute[]" value="" class="smartspinner spin_minute" maxlength="2" /><span>分</span></td></tr>';
	html += '<tr><th>前日メール不要</th><td><label><input type="checkbox" name="before_mail'+table_num+'" value="1"/></label></td></tr>';
	html += '</tbody>';
	html += '</table>';
	$("#specialist").append(html);

	/*
	document.getElementById("profile_id").value=profile_id;
	document.getElementById("profile_name").value=profile_name;
	document.getElementById("spec_id").value=spec_id;
	document.getElementById("spec_name").value=spec_name;

	document.getElementById("profile_id").setAttribute("id","");
	document.getElementById("profile_name").setAttribute("id","");
	document.getElementById("spec_id").setAttribute("id","");
	document.getElementById("spec_name").setAttribute("id","");
	*/
}

var temp;
var temp_next;
function show(obj){
	$(obj).colorbox({width:'800px',height:'600px'});
	temp=$(obj).next();
	temp_next = temp.next();
}

function setService(service_menu,service_id){
	temp.val(service_menu);
	temp_next.val(service_id);
}


function GoToRefer(){
	var val = document.getElementById("id").value;
	window.location.href="opportunity_refer.php?"+"id="+val;
}

</script>
</head>
<body>
<?php echo $this->_tpl_vars['logout']; ?>

<div id="container">
<?php echo $this->_tpl_vars['menu']; ?>

	<article id="article" class="load">
		<h2>約定デスク</h2>
		<nav>
			<ul>
				<li><a href="opportunity_search.php"><span>案件検索</span></a></li>
				<?php if ($this->_tpl_vars['auth'] == '1'): ?>
					<li class="active"><a href="opportunity_edit.php"><span>案件登録</span></a></li>
				<?php endif; ?>
			</ul>
		</nav>
		<section id="content">
			<h3>案件情報<?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>更新<?php endif; ?><?php if ($this->_tpl_vars['phase'] == 'complete'): ?>完了<?php endif; ?></h3>

<?php if ($this->_tpl_vars['phase'] == 'input'): ?>
			<p class="message"><?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>更新<?php endif; ?>内容を確認し、<?php if ($this->_tpl_vars['forms']['id'] == ''): ?>登録<?php else: ?>更新<?php endif; ?>ボタンをクリックしてください。</p>
			<form name="fm" action="opportunity_edit.php" method="post">
				<h4>基本情報</h4>
				<table class="formTable">
					<tbody>
						<tr>
							<th class="must">クライアント名</th>
							<td>
								<a href="popup_client_select.php" class="popup btn" >選択</a>
								<input style="border:0;box-shadow:none;background-color:transparent" type="text" class="text" id="corporate_name" name="corporate_name" value="<?php echo $this->_tpl_vars['promise_forms']['corporate_name']; ?>
" readOnly="readOnly"/><?php echo $this->_tpl_vars['err']['corporate_name']; ?>

								<input type="hidden" name="corporate_id" id="corporate_id" value="<?php echo $this->_tpl_vars['promise_forms']['corporate_id']; ?>
" />
							</td>
						</tr>
						<tr>
							<th class="must">案件名</th>
							<td>
								<input type="text" class="text" name="promise_name" value="<?php echo $this->_tpl_vars['promise_forms']['promise_name']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['promise_name']; ?>

							</td>
						</tr>
					</tbody>
				</table>

				<h4>スペシャリスト</h4>
				<table class="formTable">
					<tbody>
						<tr><td>
					<ul class="btns b10">
					<li class="btn single c"><a href="popup_specialist_select.php" class="popup">ｽﾍﾟｼｬﾘｽﾄを追加</a></li><?php echo $this->_tpl_vars['err']['spec_group']; ?>

				</ul></td></tr>
				</table>


				<div id="specialist" class="appendArea">
			<?php $_from = $this->_tpl_vars['promise_spec_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['member'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['member']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
        $this->_foreach['member']['iteration']++;
?>

				<table class="formTable accordionTable">
				<thead>
					<tr>
						<th colspan="2">スペシャリスト</th>
					</tr>
				</thead>
				<tbody>
				<tr>
				<th><a href="javascript:;" class="del_item">削除</a> スペシャリスト</th>
					<td>
						<input type="text" class="text"  name="spec_name[]" value="<?php echo $this->_tpl_vars['v']['spec_name']; ?>
" maxlength="100" readOnly="readOnly"/><?php echo $this->_tpl_vars['err']['spec_name'][($this->_foreach['member']['iteration']-1)]; ?>
<br />
						<input type="text" class="text"  name="profile_name[]" value="<?php echo $this->_tpl_vars['v']['profile_name']; ?>
" readOnly="readOnly"/><?php echo $this->_tpl_vars['err']['profile_name'][($this->_foreach['member']['iteration']-1)]; ?>

						<input type="hidden" name="profile_id[]"  value="<?php echo $this->_tpl_vars['v']['profile_id']; ?>
" />
						<input type="hidden" name="spec_id[]" value="<?php echo $this->_tpl_vars['v']['spec_id']; ?>
" />
					</td>
				</tr>
				<tr><th>サービス</th>
				<td><a id="service_href" href="popup_service_master.php?sid=<?php echo $this->_tpl_vars['v']['spec_id']; ?>
" onclick="show(this)" class="popup btn">選択する</a>
				<input style="border:0;box-shadow:none;background-color:transparent" type="text" class="text" name="service_name[]" value="<?php echo $this->_tpl_vars['v']['service_name']; ?>
" maxlength="100" readOnly="readOnly"/><input type="hidden" class="text" name="service_id[]" value="<?php echo $this->_tpl_vars['v']['service_id']; ?>
"/><?php echo $this->_tpl_vars['err']['service_name'][($this->_foreach['member']['iteration']-1)]; ?>


				</td>
				</tr>
				<tr><th>実施日</th>
					<td class="floats"><input type="text" class="text_date" name="day[]" value="<?php echo $this->_tpl_vars['v']['day']; ?>
"/>
						<input type="text" name="hour[]" value = "<?php echo $this->_tpl_vars['v']['hour']; ?>
" class="smartspinner spin_time" maxlength="2"/>
						<span>時&nbsp;</span>
						<input type="text" name="minute[]" value = "<?php echo $this->_tpl_vars['v']['minute']; ?>
" class="smartspinner spin_minute" maxlength="2"/>
						<span>分</span>
						<?php echo $this->_tpl_vars['err']['doing_time'][($this->_foreach['member']['iteration']-1)]; ?>

					</td>
				</tr>
				<tr><th>前日メール不要</th>
					<td>
						<label>

							<input type="checkbox" name="before_mail<?php echo $this->_tpl_vars['k']; ?>
"

							<?php if ($this->_tpl_vars['v']['before_mail'] == '1'): ?> checked="true" <?php endif; ?>

							value="1"/>
						</label>
					</td>
				</tr>
<?php if ($this->_tpl_vars['forms']['id'] != ''): ?>
				<tr><th>残業有無</th>
					<td>
							<?php $_from = $this->_tpl_vars['overtime_have']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
								<label>
									<input type="radio" class="overtime_have" name="overtime_have<?php echo $this->_tpl_vars['k']; ?>
" id="overtime_have<?php echo $this->_tpl_vars['k']; ?>
_<?php echo $this->_tpl_vars['kk']; ?>
"
									<?php if ($this->_tpl_vars['v']['overtime_have'] == $this->_tpl_vars['kk']): ?>
										checked
									<?php endif; ?>
									value="<?php echo $this->_tpl_vars['kk']; ?>
"/><?php echo $this->_tpl_vars['vv']; ?>

								</label>
							<?php endforeach; endif; unset($_from); ?>
					</td>
				</tr>
				<tr><th>残業費</th>
					<td>
						<input type="text" class="short" name="overtime_fee[]" id="overtime_fee_<?php echo $this->_tpl_vars['k']; ?>
"
						<?php if ($this->_tpl_vars['v']['overtime_have'] != '1'): ?>
							value="" disabled="true"
						<?php else: ?>
							value="<?php echo $this->_tpl_vars['v']['overtime_fee']; ?>
"
						<?php endif; ?>
						maxlength="10"/>円<?php echo $this->_tpl_vars['err']['overtime_fee'][($this->_foreach['member']['iteration']-1)]; ?>

					</td>
				</tr>
				<tr><th>交通費有無</th>
					<td>
					<?php $_from = $this->_tpl_vars['traffic_fee_have']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
								<label>
									<input type="radio" name="traffic_fee_have<?php echo $this->_tpl_vars['k']; ?>
" class="traffic_fee_have" id="traffic_fee_have<?php echo $this->_tpl_vars['k']; ?>
_<?php echo $this->_tpl_vars['kk']; ?>
"
									<?php if ($this->_tpl_vars['v']['traffic_fee_have'] == $this->_tpl_vars['kk']): ?>
										checked
									<?php endif; ?>
									value="<?php echo $this->_tpl_vars['kk']; ?>
"/><?php echo $this->_tpl_vars['vv']; ?>

								</label>
						<?php endforeach; endif; unset($_from); ?>
					</td>
				</tr>
				<tr>
				<th>！交通費</th>
					<td>
						<input type="text" class="short" name="traffic_fee[]" id="traffic_fee_<?php echo $this->_tpl_vars['k']; ?>
"
						<?php if ($this->_tpl_vars['v']['traffic_fee_have'] != '1'): ?>
							value="" disabled="true"
						<?php else: ?>
							value="<?php echo $this->_tpl_vars['v']['traffic_fee']; ?>
"
						<?php endif; ?>
						maxlength="10"/>円<?php echo $this->_tpl_vars['err']['traffic_fee'][($this->_foreach['member']['iteration']-1)]; ?>

					</td>
				</tr>
				<tr><th>！交通費詳細</th>
					<td>
						<input type="text" class="text" name="traffic_fee_detail[]" id="traffic_fee_detail_<?php echo $this->_tpl_vars['k']; ?>
"
						<?php if ($this->_tpl_vars['v']['traffic_fee_have'] != '1'): ?>
							value="" disabled="true"
						<?php else: ?>
							value="<?php echo $this->_tpl_vars['v']['traffic_fee_detail']; ?>
"
						<?php endif; ?>
						maxlength="1000"/><?php echo $this->_tpl_vars['err']['traffic_fee_detail'][($this->_foreach['member']['iteration']-1)]; ?>

					</td>
				</tr>
				<tr>
				<th>！宿泊費有無</th>
					<td>
					<?php $_from = $this->_tpl_vars['live_fee_have']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
								<label>
									<input type="radio" name="live_fee_have<?php echo $this->_tpl_vars['k']; ?>
" class="live_fee_have" id="live_fee_have<?php echo $this->_tpl_vars['k']; ?>
_<?php echo $this->_tpl_vars['kk']; ?>
"
									<?php if ($this->_tpl_vars['v']['live_fee_have'] == $this->_tpl_vars['kk']): ?>
										checked
									<?php endif; ?>
									value="<?php echo $this->_tpl_vars['kk']; ?>
"/><?php echo $this->_tpl_vars['vv']; ?>

								</label>
						<?php endforeach; endif; unset($_from); ?>
					</td>
				</tr>
				<tr><th>！宿泊費</th>
					<td>
						<input type="text" class="short" name="live_fee[]" id="live_fee_<?php echo $this->_tpl_vars['k']; ?>
"
						<?php if ($this->_tpl_vars['v']['live_fee_have'] != '1'): ?>
							value="" disabled="true"
						<?php else: ?>
							value="<?php echo $this->_tpl_vars['v']['live_fee']; ?>
"
						<?php endif; ?>
						 maxlength="10" />円<?php echo $this->_tpl_vars['err']['live_fee'][($this->_foreach['member']['iteration']-1)]; ?>

					</td>
				</tr>
				<tr><th>！宿泊費詳細</th>
					<td>
						<input type="text" class="text" name="live_fee_detail[]" id="live_fee_detail_<?php echo $this->_tpl_vars['k']; ?>
"
						<?php if ($this->_tpl_vars['v']['live_fee_have'] != '1'): ?>
							value="" disabled="true"
						<?php else: ?>
							value="<?php echo $this->_tpl_vars['v']['live_fee_detail']; ?>
"
						<?php endif; ?>
						maxlength="1000"/><?php echo $this->_tpl_vars['err']['live_fee_detail'][($this->_foreach['member']['iteration']-1)]; ?>

					</td>
				</tr>
				<tr><th>！その他経費有無</th>
					<td>
					<?php $_from = $this->_tpl_vars['other_fee_have']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
								<label>
									<input type="radio" name="other_fee_have<?php echo $this->_tpl_vars['k']; ?>
" class="other_fee_have" id="other_fee_have<?php echo $this->_tpl_vars['k']; ?>
_<?php echo $this->_tpl_vars['kk']; ?>
"
									<?php if ($this->_tpl_vars['v']['other_fee_have'] == $this->_tpl_vars['kk']): ?>
										checked
									<?php endif; ?>
									value="<?php echo $this->_tpl_vars['kk']; ?>
"/><?php echo $this->_tpl_vars['vv']; ?>

								</label>
						<?php endforeach; endif; unset($_from); ?>
					</td>
				</tr>
				<tr><th>！その他経費</th>
					<td>
						<input type="text" class="short" name="other_fee[]" id="other_fee_<?php echo $this->_tpl_vars['k']; ?>
"
						<?php if ($this->_tpl_vars['v']['other_fee_have'] != '1'): ?>
							value="" disabled="true"
						<?php else: ?>
							value="<?php echo $this->_tpl_vars['v']['other_fee']; ?>
"
						<?php endif; ?>
						maxlength="10"/>円<?php echo $this->_tpl_vars['err']['other_fee'][($this->_foreach['member']['iteration']-1)]; ?>

					</td>
				</tr>
				<tr><th>！その他経費名目</th>
					<td>
						<input type="text" name="other_fee_name[]" id="other_fee_name_<?php echo $this->_tpl_vars['k']; ?>
"
						<?php if ($this->_tpl_vars['v']['other_fee_have'] != '1'): ?>
							value="" disabled="true"
						<?php else: ?>
							value="<?php echo $this->_tpl_vars['v']['other_fee_name']; ?>
"
						<?php endif; ?>
						 maxlength="100"/><?php echo $this->_tpl_vars['err']['other_fee_name'][($this->_foreach['member']['iteration']-1)]; ?>

					</td>
				</tr>
				<tr><th>！その他経費詳細</th>
					<td>
						<input type="text" class="text" name="other_fee_detail[]" id="other_fee_detail_<?php echo $this->_tpl_vars['k']; ?>
"
						<?php if ($this->_tpl_vars['v']['other_fee_have'] != '1'): ?>
							value="" disabled="true"
						<?php else: ?>
							value="<?php echo $this->_tpl_vars['v']['other_fee_detail']; ?>
"
						<?php endif; ?>
						 maxlength="200"/><?php echo $this->_tpl_vars['err']['other_fee_detail'][($this->_foreach['member']['iteration']-1)]; ?>

					</td>
				</tr>
				<?php endif; ?>
				</tbody>
				</table>
				<input type="hidden" name="pro_id[]" value="<?php echo $this->_tpl_vars['v']['id']; ?>
" />
				<?php endforeach; endif; unset($_from); ?>
				</div>
				<!--
				<p style="color:red;text-align:left;">！業務終了後修正に使用</p>
				 -->
				<p class="button">

				<?php if ($this->_tpl_vars['forms']['id']): ?>
					<button type="button" class="btn_back" onclick="GoToRefer()"><span>戻る</span></button>
					<button type="button" class="btn_update"><span>更新</span></button>
					<button type="button" id="btn_regist" class="btn_regist"><span>登録</span></button>
					<button type="button" class="btn_copy"><span>この案件を繰り返して設定する</span></button>
				<?php else: ?>
					<button type="button" class="btn_regist"><span>登録</span></button>
				<?php endif; ?>
				</p>
				<input type="hidden" name="id" id="id" value="<?php echo $this->_tpl_vars['forms']['id']; ?>
" />
				<input type="hidden" name="mode" value="" />
				<input type="hidden" name="promise_id" value="<?php echo $this->_tpl_vars['promise_forms']['id']; ?>
">
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
							<li><a href="opportunity_search.php?hist=2">一覧に戻る</a></li>
							<li><a href="opportunity_edit.php?id=<?php echo $this->_tpl_vars['promise_id']; ?>
">登録した内容を更新</a></li>
						<?php else: ?>
							<li><a href="opportunity_edit.php">続けて新規登録する</a></li>
							<li><a href="opportunity_edit.php?id=<?php echo $this->_tpl_vars['promise_id']; ?>
">登録した内容を更新</a></li>
						<?php endif; ?>
					</ul>
<?php endif; ?>
<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>
</body>
</html>