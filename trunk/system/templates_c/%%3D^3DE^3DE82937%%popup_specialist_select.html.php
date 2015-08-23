<?php /* Smarty version 2.6.26, created on 2013-03-25 16:23:47
         compiled from popup_specialist_select.html */ ?>
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
		$('#specialist_select .preview a').unbind('click').on('click',function(){
			var profile_name = $(this).parent().prev().children().html();

			var profile_id = $(this). parent().next().children().val();
			var spec_id = $(this).parent().next().children().next().val();
			var spec_name = $(this).parent().next().children().next().next().val();
			setSpec(profile_id,profile_name, spec_id, spec_name);
			parent.$.colorbox.close();
		});
		*/
		$('#specialist_select .td_name a').unbind('click').click(function(){
			var url = $(this).data('url');
			window.open(url, 'mywindow2', 'width=600, height=700, menubar=no, toolbar=no, scrollbars=yes');
		});
		/*
		$("#spec_search").change(function(){
			var search_str = this.value;
			var myDate = new Date();
			var nowtime = myDate.getTime();
			$.get("popup_specialist_select.php",
				{v:search_str,t:nowtime},
				function(data){
					$("#search_p").remove();
					$("#txtHint").children().remove();
					$("#txtHint").append(data);
				});

		});
		*/
	});
	function dosearch(){
		var search_str = $("#spec_search").val();
		var myDate = new Date();
		var nowtime = myDate.getTime();
		$.get("popup_specialist_select.php",
			{v:search_str,t:nowtime},
			function(data){
				$("#search_p").remove();
				$("#txtHint").children().remove();
				$("#txtHint").append(data);
			});
		return false;
	}
</script>

</head>
<body>
<div class="thisPopup" id="specialist_select">

<section id="content">

	<p id="search_p">
		絞込み：
		<input type="text" value="" id="spec_search" value="<?php echo $this->_tpl_vars['condition']; ?>
"/>
&nbsp;<button type="button" class="btn2" onclick="dosearch()">検索</button>
	</p>

	<table class="sortable" id="txtHint">
    <thead>
        <tr>
			<th width="40">ID</th>
			<th width="120">スペシャリスト名</th>
			<th>セット</th>
        </tr>
    </thead>
    <tbody>
    <?php $_from = $this->_tpl_vars['spec_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
        <tr>
			<td><?php echo $this->_tpl_vars['k']+1; ?>
</td>
			<td><?php echo $this->_tpl_vars['v']['spec_name']; ?>
</td>
			<td>
				<table>
					<tbody>
				<?php $_from = $this->_tpl_vars['spec_profile_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kk'] => $this->_tpl_vars['vv']):
?>
				<?php if ($this->_tpl_vars['v']['id'] == $this->_tpl_vars['vv']['spec_id']): ?>

						<tr>
							<td class="td_name" width="100%"><a href="javascript:;"
							 data-url="popup_specialist_profile1.php?id=<?php echo $this->_tpl_vars['vv']['id']; ?>
"><?php echo $this->_tpl_vars['vv']['profile_name']; ?>
</a></td>
							<td class="preview" ><a href="javascript:parent.$.colorbox.close();setSpec('<?php echo $this->_tpl_vars['vv']['id']; ?>
','<?php echo $this->_tpl_vars['vv']['profile_name']; ?>
','<?php echo $this->_tpl_vars['v']['id']; ?>
','<?php echo $this->_tpl_vars['v']['spec_name']; ?>
')">セット</a></td>
							<input type="hidden" name="profile_id" value="<?php echo $this->_tpl_vars['vv']['id']; ?>
"/>
							<input type="hidden" name="spec_id" value="<?php echo $this->_tpl_vars['v']['id']; ?>
"/>
							<input type="hidden" name="spec_name" value="<?php echo $this->_tpl_vars['v']['spec_name']; ?>
"/>
						</tr>
				<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
					</tbody>
				</table>
			</td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
	</table>
</section>
</div>
</body>
</html>