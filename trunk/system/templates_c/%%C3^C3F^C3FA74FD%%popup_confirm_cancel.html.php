<?php /* Smarty version 2.6.26, created on 2013-03-23 22:40:13
         compiled from popup_confirm_cancel.html */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/popup.css" rel="stylesheet" />

<script src="./assets/scripts/popup.js" type="text/javascript"></script>
<title>コントロールパネル</title>

<script type="text/javascript">
	var g_control = 0;
	$(function(){
		$('#cancel').unbind('click').live('click',function(){
			//SetConfirmCancel();
			//parent.$.colorbox.close();
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
 ,t:nowtime }, function(data){
				deliveCnt = 1 * data;
				 if ( (deliveCnt * 1) > 0 ) {

						locaRefresh();
				 } else {
					 alert('操作失敗しました、再ログインしてやってみてください');
					 parent.$.colorbox.close();
				 }
			});
			 }
		});

		$('#off').unbind('click').live('click',function(){
			parent.$.colorbox.close();
		});
	});
</script>

</head>
<body>
<div class="thisPopup" id="confirm_cancel">

<header>
	<h1><span>&nbsp;</span>確認</h1>
</header>

<section id="content">
	<p>業務を実施しなかったことをもう一度確認してください。</p>
</section>

<section id="btn">
	<p>
		<button type="button" id="off" class="btn_check "><span>閉じる</span></button>
		<button type="button" id="cancel" class="btn_check "><span>実施しなかった</span></button>
	</p>
</section>
</div>
</body>
</html>