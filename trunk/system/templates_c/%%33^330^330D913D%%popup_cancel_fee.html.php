<?php /* Smarty version 2.6.26, created on 2013-03-24 23:01:38
         compiled from popup_cancel_fee.html */ ?>
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
		$('#cancel_fee .btn_check').unbind('click').live('click',function(){
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
	});
</script>
</head>
<body>
<div class="thisPopup" id="cancel_fee">

<header>
	<h1><span>&nbsp;</span>キャンセルフィー</h1>
</header>

<section id="content">
	<p>キャンセルフィーの内容</p>
</section>

<section id="btn">
	<p>
		<button type="button" class="btn_check" ><span>同意する</span></button>
	</p>
</section>
</div>
</body>
</html>