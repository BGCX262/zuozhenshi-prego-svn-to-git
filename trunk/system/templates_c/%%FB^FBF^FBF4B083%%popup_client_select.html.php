<?php /* Smarty version 2.6.26, created on 2013-03-25 16:19:50
         compiled from popup_client_select.html */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/popup.css" rel="stylesheet" />

<script src="./assets/scripts/popup.js" type="text/javascript"></script>
<title>コントロールパネル</title>

<script type="text/javascript">
	$(function(){
		/*
		$('#client_select .preview a').unbind('click').live('click',function(){
			var corporate_name = $(this).parent().prev().html();
			var corporate_id = $(this).parent().next().children().val();
			setS(corporate_id,corporate_name);
			parent.$.colorbox.close();
		});
		*/

		$("#condition").change(function(){
			var search_str = this.value;
			var myDate = new Date();
			var nowtime = myDate.getTime();
			$.get("popup_client_select.php",
				{v:search_str,t:nowtime},
				function(data){
					$("#search_p").remove();
					$("#txtHint").children().remove();
					$("#txtHint").append(data);
				});

		});

	});
	function dosearch(){
		var search_str = $("#condition").val();
		var myDate = new Date();
		var nowtime = myDate.getTime();

		$.get("popup_client_select.php",
			{v:search_str,t:nowtime},
			function(data){
				//$("#search_p").remove();
				//$("#txtHint").children().remove();
				//$("#txtHint").append(data);
				$("#cboxLoadedContent").html(data);
			});
		return false;
	}
	function pSetClient(corporate_id,corporate_name){
		setS(corporate_id,corporate_name);
		parent.$.colorbox.close();
	}
</script>

</head>
<body>
<div class="thisPopup" id="client_select">

<section id="content">
	<form name="fm">
		<p id="search_p">
			絞込み：
			<input type="text" name="condition" id="condition" value="<?php echo $this->_tpl_vars['condition']; ?>
" />
			&nbsp;<button type="button" class="btn2" onclick="dosearch()">検索</button>
		</p>
		<table class="sortable" id="txtHint">
	    <thead>
	        <tr>
				<th>ID</th>
				<th>クライアント名</th>
				<th>セット</th>
	        </tr>
	    </thead>
	    <tbody>

	    <?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
	        <tr>
				<td><?php echo $this->_tpl_vars['k']+1; ?>
</td>
				<td><?php echo $this->_tpl_vars['v']['corporate_name']; ?>
</td>
				<td class="preview"><a href="javascript:pSetClient('<?php echo $this->_tpl_vars['v']['id']; ?>
','<?php echo $this->_tpl_vars['v']['corporate_name']; ?>
');">セット</a></td>
				<input type="hidden" name="corporate_id" value="<?php echo $this->_tpl_vars['v']['id']; ?>
" />
	        </tr>
	    <?php endforeach; endif; unset($_from); ?>

	    </tbody>
		</table>
	</form>
</section>
</div>
</body>
</html>