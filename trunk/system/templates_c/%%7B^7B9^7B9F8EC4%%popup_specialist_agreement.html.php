<?php /* Smarty version 2.6.26, created on 2013-03-24 23:03:38
         compiled from popup_specialist_agreement.html */ ?>
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
		$('#specialist_agree .btn_check').unbind('click').live('click',function(){
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
							alert('約定が確定されました。確定メールをお送りします');
							locaRefresh();
					 } else {
						 alert('操作失敗しました、再ログインしてやってみてください');
						 parent.$.colorbox.close();
					 }
				});
			}

			//alert('約定が確定されました。確定メールをお送りします');
			//setSpecAgree();
			//parent.$.colorbox.close();
		});
	});
</script>

</head>
<body>
<div class="thisPopup" id="specialist_agree">

<header>
	<h1><span>&nbsp;</span>受注規約</h1>
</header>

<section id="content">
	<iframe src="./assets/pdf/specialist.pdf" frameborder="0" style="border:0;width:100%;height:446px;"></iframe>
</section>

<section id="btn">
	<p>
		<button type="button" class="btn_check" ><span>同意する</span></button>
	</p>
</section>
</div>
</body>
</html>