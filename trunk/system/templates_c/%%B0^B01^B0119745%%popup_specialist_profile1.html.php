<?php /* Smarty version 2.6.26, created on 2013-03-24 23:13:31
         compiled from popup_specialist_profile1.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'popup_specialist_profile1.html', 67, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/popup.css" rel="stylesheet" />

<script src="./assets/scripts/popup.js" type="text/javascript"></script>
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
<div class="thisPopup" id="specialist_profile">

<section id="content">

	<h1><img src="./assets/images/common/logo.gif" alt="Prego" /></h1>

	<p class="img">
		<?php if ($this->_tpl_vars['image'] != ''): ?>
			<img src="<?php echo $this->_tpl_vars['image']; ?>
" />
		<?php endif; ?>
	</p>

	<h2><?php echo $this->_tpl_vars['speclist_forms']['spec_name']; ?>
</h2>
	<h3><?php echo $this->_tpl_vars['speclist_forms']['interlingua']; ?>
</h3>
	<h4><?php echo $this->_tpl_vars['spec_profile_forms']['title']; ?>
</h4>

	<p class="summary"><?php echo $this->_tpl_vars['spec_profile_forms']['summary']; ?>
</p>

	<table>
		<tbody>
			<tr>
				<td><?php echo $this->_tpl_vars['speclist_forms']['birthday']; ?>
</td>
				<td><?php echo $this->_tpl_vars['spec_profile_forms']['address']; ?>
</td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['spec_profile_forms']['experience']; ?>
</td>
				<td><?php echo $this->_tpl_vars['spec_profile_forms']['qualifications']; ?>
</td>
			</tr>
			<tr>
				<td><?php echo $this->_tpl_vars['spec_profile_forms']['actual_result']; ?>
</td>
				<td><?php echo $this->_tpl_vars['spec_profile_forms']['famous']; ?>
</td>
			</tr>

			<tr>
				<td>
				<?php if ($this->_tpl_vars['spec_profile_forms']['cartoon_url'] != ''): ?>
					<ul class="btns b10">
						<li class="btn single c"><a id="cartoon_url" href="javascript:;" data-url="<?php echo $this->_tpl_vars['spec_profile_forms']['cartoon_url']; ?>
">動画を見る</a></li>
					</ul>
				<?php endif; ?>
				<!--
				<a href="<?php echo $this->_tpl_vars['spec_profile_forms']['cartoon_url']; ?>
"><?php echo $this->_tpl_vars['spec_profile_forms']['cartoon_url']; ?>
</a></td>
				-->
				<?php if ($this->_tpl_vars['auth'] == '1'): ?>
				<td>
					<?php $_from = $this->_tpl_vars['spec_fee_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
						<?php if ($this->_tpl_vars['spec_profile_forms']['fee_message_a'] != '' && $this->_tpl_vars['v']['servers_menu'] == $this->_tpl_vars['spec_profile_forms']['fee_message_a']): ?>
							<?php echo $this->_tpl_vars['v']['servers_menu']; ?>
&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['spec_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['servers_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円<br/>
						<?php elseif ($this->_tpl_vars['spec_profile_forms']['fee_message_b'] != '' && $this->_tpl_vars['v']['servers_menu'] == $this->_tpl_vars['spec_profile_forms']['fee_message_b']): ?>
							<?php echo $this->_tpl_vars['v']['servers_menu']; ?>
&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['spec_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['servers_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円<br/>
						<?php elseif ($this->_tpl_vars['spec_profile_forms']['fee_message_c'] != '' && $this->_tpl_vars['v']['servers_menu'] == $this->_tpl_vars['spec_profile_forms']['fee_message_c']): ?>
							<?php echo $this->_tpl_vars['v']['servers_menu']; ?>
&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['spec_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['servers_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
				</td>
				<?php endif; ?>
			</tr>

		</tbody>
	</table>

</section>
</div>
</body>
</html>