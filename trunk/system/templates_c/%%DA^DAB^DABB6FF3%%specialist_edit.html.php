<?php /* Smarty version 2.6.26, created on 2013-03-24 22:53:34
         compiled from specialist_edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'specialist_edit.html', 292, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/default.css" rel="stylesheet" />
<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="./assets/scripts/import.js" type="text/javascript"></script>
<script src="./assets/scripts/plugin/jquery.datasort.js" type="text/javascript"></script>
<title>コントロールパネル</title>
<style>
.formTable th span {
	font-size:12px;
}
</style>
<script type="text/javascript">
$(function() {	
	$('.del_item').live("click",function(){	
		var deleteItem = function(){
			that.closest("tr").remove();
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
	//add new item
	$('#btn_traffic .left a').click(function(){
		var table = $('#table_traffic');
		var html = "";
		html += '<tr>';
		html += '<th style="width:24px !important;"><a href="javascript:;" class="del_item">削除</a></th>';
		html += '<td><input type="text" name="traffic_name[]" value="" maxlength="100"></td>';
		html += '<td><input type="text" name="traffic_fee[]" value="" maxlength="10">円</td>';
		html += '<td><input type="text" name="traffic_memo[]" value="" maxlength="1000"></td>';
		html += '<input type="hidden" name="traffic_fee_id[]" value=""/>';
		html += '</tr>';		
		var addArea = $('tbody',table);
		addArea.append(html);	
	});
	
	//delete all item with blank field
	$('#btn_traffic .right a').click(function(){
		var table = $('#table_traffic');
		$('tbody input[type=text]',table).each(function(){
			if(!$(this).val()){
				$(".del_item",$(this).closest('tr')).click();
			}
		});
	});
	
	$('.single').click(function(){
		/*
		var table = $('#table_fee');
		var html = "";
		html += '<tr>';
		html += '<th style="width:24px !important;"><a href="javascript:;" class="del_item">削除</a></th>';
		html += '<td><input type="text" name="servers_menu[]" id="servers_menu" value="" maxlength="100"></td>';
		html += '<td><input type="text" name="spec_fee[]" id="spec_fee" value="" maxlength="10">円</td>';
		html += '<td><input type="text" name="servers_fee[]" id="servers_fee" value="" maxlength="10">円</td>';
		html += '<input type="hidden" name="spec_fee_id[]" value=""/>';
		html += '<input type="hidden" name="service_id[]" id="service_id" value="">';
		html += '</tr>';
		var addServiceArea = $('tbody', table);
		addServiceArea.append(html);
		*/
	});
	
	/*
	$('#service_master #content table tbody tr').live('click',function(){
	
		var sku = $(this).children().html();
		var service_menu = $(this).children().next().html();
		//var spec_fee = $(this).children().next().next().html();
		//var service_fee = $(this).children().next().next().next().html();
		var caption = $(this).children().next().next().next().next().html();
		var memo = $(this).children().next().next().next().next().next().html();
		//var service_id = $(this).children().next().next().next().next().next().next().children().val();
		var id =  $(this).attr("id") ;
		var service_id = id.split("_")[1];
		var refarr =  $(this).attr("ref").split("_") ;
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
//  function String.prototype.Trim() { return this.replace(/(^/s*)|(/s*$)/g, ""); }
});

function setServiceMaster(service_id, service_menu,spec_fee, service_fee ){
	if (setSpec(service_id,service_menu,spec_fee,service_fee)){
		parent.$.colorbox.close();
	}
	
}
function setSpec(service_id,service_menu,spec_fee,service_fee){
	var checkRet = checkService(service_id);
	
	if ( checkRet == 100 ) {
		var spec_str    = spec_fee* 1;
		var service_str = service_fee* 1;
		var table = $('#table_fee');
		var html = "";
		html += '<tr>';
		html += '<th style="width:24px !important;"><a href="javascript:;" class="del_item">削除</a></th>';
		html += '<td><input type="text" name="servers_menu[]" id="servers_menu" value="' + service_menu + '" maxlength="100"></td>';
		html += '<td><input type="text" name="spec_fee[]" id="spec_fee" value="' + spec_str + '" maxlength="10">円</td>';
		html += '<td><input type="text" name="servers_fee[]" id="servers_fee" value="' + service_str+ '" maxlength="10">円</td>';
		html += '<input type="hidden" name="spec_fee_id[]" value=""/>';
		html += '<input type="hidden" name="service_id[]" id="service_id" value="' + service_id + '">';
		html += '</tr>';
		var addServiceArea = $('tbody', table);
		addServiceArea.append(html);
		return true;
	}else {
		alert("該当サービスはすでに選択されました");
	}
	return false;
}

function GoToRefer(){
	var val = document.getElementById("id").value;
	window.location.href="specialist_refer.php?id="+val;
}


function inputControl(obj){
	if(obj.checked == true){
		document.getElementById("spec_area_else").removeAttribute("disabled");
	}else{
		document.getElementById("spec_area_else").value = "";
		document.getElementById("spec_area_else").setAttribute("disabled","true");
	}
}

function checkService(inid) {
	var cdsul   = document.getElementsByName( 'service_id[]');
	var max = cdsul.length;
	for(var i=0; i<max; i++){
		if (inid == cdsul[i].value){
			return 0;
		}
	}
	return 100;
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
			<?php if ($this->_tpl_vars['auth'] == '1'): ?>
				<li class="active"><a href="specialist_unregistered.php"><span>未登録一覧</span></a></li>
				<li><a href="specialist_search.php"><span>スペシャリスト検索</span></a></li>
			<?php elseif ($this->_tpl_vars['auth'] == '3'): ?>
				<li class="active"><a href="specialist_refer.php"><span>スペシャリスト情報</span></a></li>
			<?php endif; ?>
			</ul>
		</nav>
		<section id="content">
			<h3>スペシャリスト<?php if ($this->_tpl_vars['forms']['id'] == '' || $this->_tpl_vars['forms']['insertid'] != ''): ?>登録<?php else: ?>更新 <?php endif; ?><?php if ($this->_tpl_vars['phase'] == 'complete'): ?>完了<?php endif; ?><?php if ($this->_tpl_vars['forms']['id'] != '' || $this->_tpl_vars['forms']['insertid'] != ''): ?>（基本情報+フィー） <?php endif; ?></h3>
<?php if ($this->_tpl_vars['phase'] == 'input'): ?>			
			<p class="message"><?php if ($this->_tpl_vars['forms']['id'] == '' || $this->_tpl_vars['forms']['insertid'] != ''): ?>登録<?php else: ?>更新<?php endif; ?>内容を確認し、<?php if ($this->_tpl_vars['forms']['id'] == '' || $this->_tpl_vars['forms']['insertid'] != ''): ?>登録<?php else: ?>更新<?php endif; ?>ボタンをクリックしてください。</p>
			<form name="fm" action="specialist_edit.php" method="post">
				<h4>基本情報</h4>
				<table class="formTable">
					<tbody>
						<tr>
							<th class="must">Name in Japanese<br /><span>（氏名）</span></th>
							<td>
								<input type="text" class="text" name="spec_name" value="<?php echo $this->_tpl_vars['spec_forms']['spec_name']; ?>
" maxlength="100"/><?php echo $this->_tpl_vars['err']['spec_name']; ?>

							</td>
						</tr>
						<tr>
							<th class="must">name<br /><span>（アルファベット</span>）</th>
							<td>
								<input type="text" class="text" name="interlingua" value="<?php echo $this->_tpl_vars['spec_forms']['interlingua']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['interlingua']; ?>

							</td>
						</tr>
						<tr>
							<th class="must">mail address 1<br /><span>（メールアドレス1）</span></th>
							<td>
								<input type="text" class="text" name="mail_address1" value="<?php echo $this->_tpl_vars['spec_forms']['mail_address1']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['mail_address1']; ?>

							</td>
						</tr>
						<tr>
							<th>mail address 2<br /><span>（メールアドレス2）</span></th>
							<td>
								<input type="text" class="text" name="mail_address2" value="<?php echo $this->_tpl_vars['spec_forms']['mail_address2']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['mail_address2']; ?>

							</td>
						</tr>
						<tr>
							<th>business field<br /><span>（スペシャリスト分野）</span></th>
							<td>
								<label><input type="checkbox" name="spec_area_a" <?php if ($this->_tpl_vars['spec_forms']['spec_area_a'] == '1'): ?>checked="checked"<?php endif; ?> value="1" />分野A</label>
								<label><input type="checkbox" name="spec_area_b" <?php if ($this->_tpl_vars['spec_forms']['spec_area_b'] == '1'): ?>checked="checked"<?php endif; ?> value="1"/>分野B</label>
								<label><input type="checkbox" name="spec_area_c" <?php if ($this->_tpl_vars['spec_forms']['spec_area_c'] == '1'): ?>checked="checked"<?php endif; ?> value="1"/>分野C</label>
								<label><input type="checkbox" onclick="inputControl(this)" name="spec_area_d" <?php if ($this->_tpl_vars['spec_forms']['spec_area_d'] == '1'): ?>checked="checked"<?php endif; ?> value="1"/>その他</label>
								<input type="text" name="spec_area_else" id="spec_area_else" <?php if ($this->_tpl_vars['spec_forms']['spec_area_d'] != '1'): ?>disabled="true" <?php endif; ?> value="<?php echo $this->_tpl_vars['spec_forms']['spec_area_else']; ?>
" maxlength="50"/>
							</td>
						</tr>
						<tr>
							<th>Company name<br /><span>（会社名or商号）</span><br />(if any)</th>
							<td>
								<input type="text" class="text" name="corporate_name" value="<?php echo $this->_tpl_vars['spec_forms']['corporate_name']; ?>
" maxlength="100" /><?php echo $this->_tpl_vars['err']['corporate_name']; ?>

							</td>
						</tr>
						<tr>
							<th>zip code<br /><span>（郵便番号）</span></th>
							<td class="floats">
								<input type="text" class="short post1" name="region" value="<?php echo $this->_tpl_vars['region']; ?>
" maxlength="3"/>
								<span> - </span>
								<input type="text" class="short post2" name="branch" value="<?php echo $this->_tpl_vars['branch']; ?>
" maxlength="4"/>
								<span class="btn_blank"><a href="javascript:;" style="position:relative;top:-2px;" class="searchAddress">住所検索</a></span>
								<?php echo $this->_tpl_vars['err']['post_code']; ?>

							</td>
						</tr>
						<tr>
							<th>home address<br /><span>（住所）</span></th>
							<td><input type="text" class="text resultAddress" name="address" value="<?php echo $this->_tpl_vars['spec_forms']['address']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['address']; ?>
</td>
						</tr>
						<tr>
							<th>TEL<br /><span>（電話番号）</span></th>
							<td>
								<input type="text" class="short" name="area_code" value="<?php echo $this->_tpl_vars['area_code']; ?>
" maxlength="5"/> - 
								<input type="text" class="short" name="office_number" value="<?php echo $this->_tpl_vars['office_number']; ?>
" maxlength="5"/> -
								<input type="text" class="short" name="called_number" value="<?php echo $this->_tpl_vars['called_number']; ?>
" maxlength="4"/>
								<?php echo $this->_tpl_vars['err']['tel']; ?>

							</td>
						</tr>
						<tr>
							<th>TEL cell phone<br /><span>（携帯電話番号）</span></th>
							<td>
								<input type="text" class="short" name="cell1" value="<?php echo $this->_tpl_vars['cell1']; ?>
" maxlength="5"/> - 
								<input type="text" class="short" name="cell2" value="<?php echo $this->_tpl_vars['cell2']; ?>
" maxlength="5"/> - 
								<input type="text" class="short" name="cell3" value="<?php echo $this->_tpl_vars['cell3']; ?>
" maxlength="4"/>
								<?php echo $this->_tpl_vars['err']['phone']; ?>

							</td>
						</tr>
						<tr>
							<th>FAX<br /><span>（FAX番号）</span></th>
							<td>
								<input type="text" class="short" name="fax1" value="<?php echo $this->_tpl_vars['fax1']; ?>
" maxlength="5"/> - 
								<input type="text" class="short" name="fax2" value="<?php echo $this->_tpl_vars['fax2']; ?>
" maxlength="5"/> - 
								<input type="text" class="short" name="fax3" value="<?php echo $this->_tpl_vars['fax3']; ?>
" maxlength="4"/>
								<?php echo $this->_tpl_vars['err']['fax']; ?>

							</td>
						</tr>
						<tr>
							<th>Birthday y/m/d<br /><span>（生年月日）</span></th>
							<td>
								<input type="text" class="short" name="birthday_year" value="<?php echo $this->_tpl_vars['birthday_year']; ?>
" maxlength="4"/> 年 
								<input type="text" class="short" name="birthday_month" value="<?php echo $this->_tpl_vars['birthday_month']; ?>
" maxlength="2"/> 月
								<input type="text" class="short" name="birthday_day" value="<?php echo $this->_tpl_vars['birthday_day']; ?>
" maxlength="2"/> 日
								<?php echo $this->_tpl_vars['err']['birthday']; ?>

							</td>
						</tr>
						<tr>
							<th>紹介者</th>
							<td>
								<input type="text" class="text" name="introducer" value="<?php echo $this->_tpl_vars['spec_forms']['introducer']; ?>
" maxlength="50"/><?php echo $this->_tpl_vars['err']['introducer']; ?>

							</td>
						</tr>
						<tr>
							<th>紹介者への支払い有無</th>
							<td>
							<?php if ($this->_tpl_vars['spec_forms']['introducer_fee'] != ''): ?>
<?php echo smarty_function_html_radios(array('id' => 'introducer_fee','name' => 'introducer_fee','options' => $this->_tpl_vars['introducer_fee'],'selected' => $this->_tpl_vars['spec_forms']['introducer_fee']), $this);?>

							<?php else: ?>
<?php echo smarty_function_html_radios(array('id' => 'introducer_fee','name' => 'introducer_fee','options' => $this->_tpl_vars['introducer_fee'],'selected' => '1'), $this);?>
	
							<?php endif; ?>
							<?php echo $this->_tpl_vars['err']['introducer_fee']; ?>

							</td>
						</tr>
						<tr>
							<th>紹介料支払い状況</th>
							<td>
							<?php if ($this->_tpl_vars['spec_forms']['introducer_fee_status'] != ''): ?>
<?php echo smarty_function_html_radios(array('id' => 'introducer_fee_status','name' => 'introducer_fee_status','options' => $this->_tpl_vars['introducer_fee_status'],'selected' => $this->_tpl_vars['spec_forms']['introducer_fee_status']), $this);?>

							<?php else: ?>
<?php echo smarty_function_html_radios(array('id' => 'introducer_fee_status','name' => 'introducer_fee_status','options' => $this->_tpl_vars['introducer_fee_status'],'selected' => '1'), $this);?>
							
							<?php endif; ?>								
								<input type="text" class="text_date" name="introducer_fee_status_time" value="<?php echo $this->_tpl_vars['spec_forms']['introducer_fee_status_time']; ?>
"/>
								<?php echo $this->_tpl_vars['err']['introducer_fee_status_time']; ?>

							</td>
						</tr>
						<tr>
							<th>契約日</th>
							<td class="floats">
								<input type="text" class="text_date" name="agreement_day" value="<?php echo $this->_tpl_vars['spec_forms']['agreement_day']; ?>
" /><?php echo $this->_tpl_vars['err']['agreement_day']; ?>

							</td>
						</tr>
						<tr>
							<th>契約条件</th>
							<td>
								<input type="text" class="text" name="agreement_condition" value="<?php echo $this->_tpl_vars['spec_forms']['agreement_condition']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['agreement_condition']; ?>

							</td>
						</tr>
						<tr>
							<th>登録料の支払有無</th>
							<td>
							<?php if ($this->_tpl_vars['spec_forms']['login_fee'] != ''): ?>
<?php echo smarty_function_html_radios(array('id' => 'login_fee','name' => 'login_fee','options' => $this->_tpl_vars['login_fee'],'selected' => $this->_tpl_vars['spec_forms']['login_fee']), $this);?>
							
							<?php else: ?>
<?php echo smarty_function_html_radios(array('id' => 'login_fee','name' => 'login_fee','options' => $this->_tpl_vars['login_fee'],'selected' => '1'), $this);?>
							
							<?php endif; ?>

							<?php echo $this->_tpl_vars['err']['login_fee']; ?>

							</td>
						</tr>
						<tr>
							<th>更新料の支払有無</th>
							<td>
							<?php if ($this->_tpl_vars['spec_forms']['update_fee'] != ''): ?>
<?php echo smarty_function_html_radios(array('id' => 'update_fee','name' => 'update_fee','options' => $this->_tpl_vars['update_fee'],'selected' => $this->_tpl_vars['spec_forms']['update_fee']), $this);?>

							<?php else: ?>
<?php echo smarty_function_html_radios(array('id' => 'update_fee','name' => 'update_fee','options' => $this->_tpl_vars['update_fee'],'selected' => '1'), $this);?>
							
							<?php endif; ?>						
							<?php echo $this->_tpl_vars['err']['update_fee']; ?>

							</td>
						</tr>
						<tr>
							<th>更新料支払い開始年月日</th>
							<td class="floats">
								<input type="text" class="text_date" name="update_fee_start_time" value="<?php echo $this->_tpl_vars['spec_forms']['update_fee_start_time']; ?>
" /><?php echo $this->_tpl_vars['err']['update_fee_start_time']; ?>

							</td>
						</tr>
						<tr>
							<th>契約終了日</th>
							<td class="floats">
								<input type="text" class="text_date" name="agreement_end_day" value="<?php echo $this->_tpl_vars['spec_forms']['agreement_end_day']; ?>
" /><?php echo $this->_tpl_vars['err']['agreement_end_day']; ?>

							</td>
						</tr>
						<tr>
							<th>HP掲載可能</th>
							<td>
							<?php if ($this->_tpl_vars['spec_forms']['hp'] != ''): ?>
<?php echo smarty_function_html_radios(array('id' => 'hp','name' => 'hp','options' => $this->_tpl_vars['hp_arr'],'selected' => $this->_tpl_vars['spec_forms']['hp']), $this);?>
							
							<?php else: ?>
<?php echo smarty_function_html_radios(array('id' => 'hp','name' => 'hp','options' => $this->_tpl_vars['hp_arr'],'selected' => '1'), $this);?>
							
							<?php endif; ?>
								
							<?php echo $this->_tpl_vars['err']['hp']; ?>

							</td>
						</tr>
						<tr>
							<th>銀行名</th>
							<td>
								<input type="text" class="text" name="bank_name" value="<?php echo $this->_tpl_vars['spec_forms']['bank_name']; ?>
" maxlength="100" /><?php echo $this->_tpl_vars['err']['bank_name']; ?>

							</td>
						</tr>
						<tr>
							<th>支店名</th>
							<td>
								<input type="text" class="text" name="shop_name" value="<?php echo $this->_tpl_vars['spec_forms']['shop_name']; ?>
" maxlength="100"/><?php echo $this->_tpl_vars['err']['shop_name']; ?>

							</td>
						</tr>
						<tr>
							<th>口座種類</th>
							<td>
							<?php if ($this->_tpl_vars['spec_forms']['account_kinds'] != ''): ?>
<?php echo smarty_function_html_radios(array('id' => 'account_kinds','name' => 'account_kinds','options' => $this->_tpl_vars['account_kinds'],'selected' => $this->_tpl_vars['spec_forms']['account_kinds']), $this);?>
						
							<?php else: ?>
<?php echo smarty_function_html_radios(array('id' => 'account_kinds','name' => 'account_kinds','options' => $this->_tpl_vars['account_kinds'],'selected' => '1'), $this);?>

							<?php endif; ?>
							<?php echo $this->_tpl_vars['err']['account_kinds']; ?>
						
							</td>
						</tr>
						<tr>
							<th>口座番号</th>
							<td>
								<input type="text" class="text" name="account_code" value="<?php echo $this->_tpl_vars['spec_forms']['account_code']; ?>
" maxlength="10"/><?php echo $this->_tpl_vars['err']['account_code']; ?>

							</td>
						</tr>
						<tr>
							<th>口座名義</th>
							<td>
								<input type="text" class="text" name="account_titular" value="<?php echo $this->_tpl_vars['spec_forms']['account_titular']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['account_titular']; ?>

							</td>
						</tr>
						<tr>
							<th>口座名義フリガナ</th>
							<td>
								<input type="text" class="text" name="account_titular_name" value="<?php echo $this->_tpl_vars['spec_forms']['account_titular_name']; ?>
" maxlength="200"/><?php echo $this->_tpl_vars['err']['account_titular_name']; ?>

							</td>
						</tr>
						<tr>
							<th>法人 OR 個人選択</th>
							<td>
							<?php if ($this->_tpl_vars['spec_forms']['person_choose'] != ''): ?>
<?php echo smarty_function_html_radios(array('id' => 'person_choose','name' => 'person_choose','options' => $this->_tpl_vars['person_choose'],'selected' => $this->_tpl_vars['spec_forms']['person_choose']), $this);?>
					
							<?php else: ?>
<?php echo smarty_function_html_radios(array('id' => 'person_choose','name' => 'person_choose','options' => $this->_tpl_vars['person_choose'],'selected' => '1'), $this);?>

							<?php endif; ?>

							<?php echo $this->_tpl_vars['err']['person_choose']; ?>
								
							</td>
						</tr>
					</tbody>
				</table>
				<?php if ($this->_tpl_vars['auth'] == '1' && $this->_tpl_vars['forms']['id'] != ''): ?>
				<h4>交通費マスター</h4>
				
				<ul class="btns b10" id="btn_traffic">
					<li class="btn left c"><a href="javascript:;">追加する</a></li>
					<li class="btn right c"><a href="javascript:;">空の項目を削除</a></li>
				</ul>
				
				<table class="formTable" id="table_traffic">
					<thead>
						<tr>
							<th style="width:24px !important;"></th>
							<th>交通費名称</th>
							<th>交通費</th>
							<th>備考</th>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['spec_traffic_fee_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['member'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['member']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['v']):
        $this->_foreach['member']['iteration']++;
?>
						<tr>
							<th style="width:24px !important;"><a href="javascript:;" class="del_item">削除</a></th>
							<td><input type="text" name="traffic_name[]" value="<?php echo $this->_tpl_vars['v']['traffic_name']; ?>
" maxlength="100"><?php echo $this->_tpl_vars['err']['traffic_name'][($this->_foreach['member']['iteration']-1)]; ?>
</td>
							<td><input type="text" name="traffic_fee[]" value="<?php echo $this->_tpl_vars['v']['traffic_fee']; ?>
" maxlength="10">円<?php echo $this->_tpl_vars['err']['traffic_fee'][($this->_foreach['member']['iteration']-1)]; ?>
</td>
							<td><input type="text" name="traffic_memo[]" value="<?php echo $this->_tpl_vars['v']['traffic_memo']; ?>
" maxlength="1000"><?php echo $this->_tpl_vars['err']['traffic_memo'][($this->_foreach['member']['iteration']-1)]; ?>
</td>
							<input type="hidden" name="traffic_fee_id[]" value="<?php echo $this->_tpl_vars['v']['id']; ?>
"/>
						</tr>
					<?php endforeach; endif; unset($_from); ?>
					</tbody>
				</table>
				<h4>フィー情報</h4>
				
				<ul class="btns b10" id="btn_fee">
					<li class="btn single c"><a href="popup_service_master.php?model=specl&aa=qaa" class="popup">サービスを追加</a></li>
				</ul>
				
				<table class="formTable" id="table_fee">
					<thead>
						<tr>
							<th style="width:24px !important;"></th>
							<th>サービスメニュー</th>
							<th>スペシャリストフィー</th>
							<th>サービスフィー</th>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['servers_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['member'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['member']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['v']):
        $this->_foreach['member']['iteration']++;
?>
						<tr>
							<th style="width:24px !important;"><a href="javascript:;" class="del_item">削除</a></th>
							<td><input type="text" name="servers_menu[]" value="<?php echo $this->_tpl_vars['v']['servers_menu']; ?>
"><?php echo $this->_tpl_vars['err']['servers_menu'][($this->_foreach['member']['iteration']-1)]; ?>
</td>
							<td><input type="text" name="spec_fee[]" value="<?php echo $this->_tpl_vars['v']['spec_fee']; ?>
">円<?php echo $this->_tpl_vars['err']['spec_fee'][($this->_foreach['member']['iteration']-1)]; ?>
</td>
							<td><input type="text" name="servers_fee[]" value="<?php echo $this->_tpl_vars['v']['servers_fee']; ?>
">円<?php echo $this->_tpl_vars['err']['servers_fee'][($this->_foreach['member']['iteration']-1)]; ?>
</td>
							<input type="hidden" name="spec_fee_id[]" value="<?php echo $this->_tpl_vars['v']['id']; ?>
"/>
							<input type="hidden" name="service_id[]" id="service_id" value="<?php echo $this->_tpl_vars['v']['service_id']; ?>
">
						</tr>
					<?php endforeach; endif; unset($_from); ?>
					</tbody>
				</table>
				<!-- ADD 
				<h4>プロフィール情報</h4>
				
				<ul class="btns b10">
					<li class="btn left c"><a href="specialist_profile.php?spec_id=<?php echo $this->_tpl_vars['forms']['id']; ?>
">追加</a></li>
					<?php if ($this->_tpl_vars['auth'] == '3'): ?>
						<li class="btn right c"><a href="mailto:">変更依頼</a></li>
					<?php endif; ?>
				</ul>
				
				<table class="formTable" id="table_fee">
					<thead>
						<tr>
							<th>プロフィール名</th>
							<th>登録日</th>
							<th>更新日</th>
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
							<!-- 
							<td style="width:70px;"><span class="btn_blank"><a class="blank" href="specialist_profile.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
">更新</a></span></td>
						</tr>
					<?php endforeach; endif; unset($_from); ?>
					</tbody>
				</table>
				 -->
				<?php endif; ?>
				<p class="button">
				
					<?php if ($this->_tpl_vars['forms']['id']): ?>
						<button type="button" class="btn_back" onclick="GoToRefer()" ><span>戻る</span></button>
						<button type="submit" class="btn_update" class="submit"><span>更新</span></button>
					<?php else: ?>
						<!-- 
						<button type="button" class="btn_back" onclick="GoToUnregistered()" ><span>戻る</span></button>
						 -->
						<button type="button" class="btn_regist" class="submit"><span>登録</span></button>
					<?php endif; ?>
				</p>
				<input type="hidden" name="id" id="id" value="<?php echo $this->_tpl_vars['forms']['id']; ?>
" />
				<input type="hidden" name="mode" value="" />
				<input type="hidden" name="account_id" value="<?php echo $this->_tpl_vars['account_id']; ?>
"  />
				<input type="hidden" name="specialist_id" value="<?php echo $this->_tpl_vars['specialist_id']; ?>
"  />
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
				<li><a href="specialist_search.php?hist=2">一覧に戻る</a></li>
				<li><a href="specialist_edit.php?id=<?php echo $this->_tpl_vars['specialist_id']; ?>
">登録した内容を更新</a></li>
			<?php else: ?>
				<li><a href="specialist_unregistered.php">続けて新規登録する</a></li>
				<li><a href="specialist_edit.php?id=<?php echo $this->_tpl_vars['specialist_id']; ?>
">登録した内容を更新</a></li>
			<?php endif; ?>
			</ul>
<?php endif; ?>
<footer id="dashboard_footer"><?php echo $this->_tpl_vars['footer']; ?>
</footer>
</body>
</html>