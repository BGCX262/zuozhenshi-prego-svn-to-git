<?php /* Smarty version 2.6.26, created on 2013-03-20 09:01:25
         compiled from popup_payment_edit.html */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/popup.css" rel="stylesheet" />

<script src="./assets/scripts/popup.js" type="text/javascript"></script>
<title>コントロールパネル</title>
<script type="text/javascript">
$(function() {
	$('#payment_edit .del_item').unbind('click').live("click",function(){
		var deleteItem = function(){
			that.closest("tr").remove();
		}
		var that = $(this);
		var v = $('input[type=text]',$(this).closest('tr')).val();
		if(v != ""){
			if(confirm('削除しますか？') == true){
				deleteItem();
			}
		}else {
			deleteItem();
		}
	});
	//add new item

	var g_index = 0;
	$('#payment_edit .btns .left a').unbind('click').click(function(){



		g_index++;

		var table = $('#tablePayment');
		var html = "";

		html = '<tr>';
		html += '<td><a href="javascript:;" class="del_item">削除</a></td>';
		html += '<td><input type="text" value="" name="pay_content"/></td>';
		html += '<td><input   type="text" class="short" value="" name="money" /> <input type="hidden" value="'+ g_index +'" name="hnmy"/><span id = "nmy_'+ g_index +'"></span> </td>';
		html += '</tr>';

	var addArea = $('tbody',table);
		addArea.append(html);
	});

	$('.pay_btn').unbind('click').live('click',function(e){
		//setVal(e);
	});

	//delete all item with blank field
	$('#payment_edit .btns .right a').unbind('click').click(function(){
		var table = $('#tablePayment');
		$('tbody input[type=text]',table).each(function(){
			if(!$(this).val()){
				$(".del_item",$(this).closest('tr')).click();
			}
		});
	});

});

var content_temp = new Array();
var money_temp = new Array();
function check_nomey( val, index){
	//var val = $('#' + idnm).val();

	$('#nmy_' + index).html("");

	if  ( (val != null) && (val != "") ) {
		if (isNaN(val)) {
			var errmsg = '<p class="error">数字を入力してください</p>';

			$('#nmy_' + index).html(errmsg);
			return false;
		}
	}else {
		var errmsg = '<p class="error">数字を入力してください</p>';
		$('#nmy_' + index).html(errmsg);
		return false;
	}
	return true;
}
function setVal(){
	var model_flag = document.getElementById("model_flag").value;
	var payment_id = document.getElementById("payment_id").value;
	var request_id = document.getElementById("request_id").value;
	var obj = document.getElementsByName("pay_content");
	var money =   document.getElementsByName("money");
	var hnmy =   document.getElementsByName("hnmy");

	for(var i = 0; i< obj.length; i++){
	 		if (obj[i].value !="") {
	 			//check_nomey( money[i].value, hnmy[i].value);

	 			if (check_nomey(  money[i].value, hnmy[i].value)){
					content_temp[i] = obj[i].value;
					money_temp[i] = money[i].value;
	 			} else {
	 				return false;
	 			}


	 		}
	}
	if(model_flag == ''){
		setPayAddVal(payment_id,content_temp,money_temp);
	}else{
		setRequestAddVal(request_id,content_temp,money_temp);
	}
	parent.$.colorbox.close();
	/*
	if(model_flag == ''){
		window.location.href="payment_search.php?hist=2";
	}else{
		window.location.href="bill_search.php?hist=2";
	}
	*/

}







</script>
</head>
<body>
<div class="thisPopup" id="payment_edit">

<section id="content">

	<ul class="btns">
		<li class="btn left c"><a href="javascript:;">追加する</a></li>
		<li class="btn right c"><a href="javascript:;">空の項目を削除</a></li>
	</ul>

	<table class="sortable" id="tablePayment">
    <thead>
        <tr>
			<th class="delete_column"></th>
			<th>内容</th>
			<th>金額</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
	</table>
	<p class="button">
		<button type="submit" id="pay_btn" onclick="setVal()"><span>確定</span></button>
	</p>
	<input type="hidden" name="payment_id" id="payment_id" value="<?php echo $this->_tpl_vars['payment_id']; ?>
" />
	<input type="hidden" name="request_id" id="request_id" value="<?php echo $this->_tpl_vars['request_id']; ?>
" />
	<input type="hidden" name="model_flag" id="model_flag" value="<?php echo $this->_tpl_vars['model_flag']; ?>
" />
</section>
</div>
</body>
</html>