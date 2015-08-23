<?php /* Smarty version 2.6.26, created on 2013-03-24 23:04:27
         compiled from popup_enquete.html */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/popup.css" rel="stylesheet" />

<script src="./assets/scripts/popup.js" type="text/javascript"></script>
<title>コントロールパネル</title>
<script type="text/javascript">
	$(function(){
		setRadioAndCheckbox();
		$('#enqBtn a').on("click",function(){
			var satisfy_status = $(this).data("val");
			var count_id = $("#count_id").val();
			customConfirm('決定します。よろしいですか？',"",$(this),function(){
				SetSatisfy(count_id,satisfy_status);
				parent.$.colorbox.close();
			});
		});
	});

</script>
</head>
<body>
<div class="thisPopup" id="contract_help">

<header>
	<h1><span>&nbsp;</span>アンケート</h1>
</header>

<section id="content">
	<ul id="enqBtn">
		<li id="eBtn01"><a href="javascript:;" name="satisfy" data-val="02">満足した</a></li>
		<li id="eBtn02"><a href="javascript:;" name="satisfy" data-val="01">不満足</a></li>
		<li id="eBtn03"><a href="javascript:;" name="satisfy" data-val="03">どちらでもない</a></li>
		<input type="hidden" name="count_id" id="count_id" value="<?php echo $this->_tpl_vars['count_id']; ?>
"/>
	</ul>
</section>
</div>
</body>
</html>