<?php /* Smarty version 2.6.26, created on 2013-03-25 12:17:48
         compiled from popup/popup_specialist_profile1.html */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="../assets/styles/default.css" rel="stylesheet" />
<script src="../assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="../assets/scripts/import.js" type="text/javascript"></script>
<script src="../assets/scripts/plugin/jquery.datasort.js" type="text/javascript"></script>
<script src="../assets/scripts/popup.js" type="text/javascript"></script>
<title>コントロールパネル</title>
<script type="text/javascript">
$(function(){
	$('#cartoon_url').unbind('click').click(function(){
		var url = $(this).data('url');
		window.open(url, 'mywindow2', 'width=600, height=700, menubar=no, toolbar=no, scrollbars=yes');
	});
});
</script>

</head>


<body>
<article id="article" class="load">

<div class="thisPopup" id="specialist_profile">
<section id="content">

	<h1><img src="../assets/images/common/logo.gif" alt="Prego" /></h1>
			       <?php if ($this->_tpl_vars['image'] != ''): ?>
		<img  src="<?php echo $this->_tpl_vars['image']; ?>
" style="float:left"/>
	<?php endif; ?>
	<table class="formTable">
		<tbody>
		<tr>
		    <th>

		    </th>
		</tr>

			<tr>
				<th><h2><?php echo $this->_tpl_vars['spec_name']; ?>
</h2></th>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>


			<tr>
				<th><h3><?php echo $this->_tpl_vars['interlingua']; ?>
</h3></th>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<th><?php echo $this->_tpl_vars['summary']; ?>
</th>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['title']; ?>
</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<th>生年月日</th>
				<td><?php echo $this->_tpl_vars['birthday']; ?>
</td>
				<th>所在地</th>
				<td><?php echo $this->_tpl_vars['address']; ?>
</td>
			</tr>
			<tr>
				<th>経歴</th>
				<td><?php echo $this->_tpl_vars['experience']; ?>
</td>
				<th>資格</th>
				<td><?php echo $this->_tpl_vars['qualifications']; ?>
</td>
			</tr>
			<tr>
				<th>実績</th>
				<td><?php echo $this->_tpl_vars['actual_result']; ?>
</td>
				<th>著者・著作</th>
				<td><?php echo $this->_tpl_vars['famous']; ?>
</td>
			</tr>
			<tr>
				<th>動画を見る</th>
                <td><?php echo $this->_tpl_vars['cartoon_url']; ?>
</td>
				<th>サービスフィー</th>
				<td><?php echo $this->_tpl_vars['fee_message_a']; ?>
 <?php echo $this->_tpl_vars['fee_message_b']; ?>
 <?php echo $this->_tpl_vars['fee_message_c']; ?>
</td>
			</tr>
		</tbody>
	</table>

</section>
</article>
</div>
</body>
</html>