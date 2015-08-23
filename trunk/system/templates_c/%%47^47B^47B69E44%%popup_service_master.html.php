<?php /* Smarty version 2.6.26, created on 2013-03-25 13:03:30
         compiled from popup_service_master.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'popup_service_master.html', 38, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/popup.css" rel="stylesheet" />

<script src="./assets/scripts/popup.js" type="text/javascript"></script>
<title>コントロールパネル</title>
</head>
<body>
<div class="thisPopup" id="service_master">

<header>
	<h1><span>&nbsp;</span>サービスマスタ選択</h1>
</header>

<section id="content">
<input type="hidden" name="model" id="model" value="<?php echo $this->_tpl_vars['model']; ?>
"/>
<?php $_from = $this->_tpl_vars['category_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
<div>
	<h2><?php echo $this->_tpl_vars['v']['category_name']; ?>
aaa</h2>
			<table class="sortable">
						<thead>
					        <tr>
								<th>SKU<br />サービスメニュー</th>
								<th>スペシャリストフィー<br />サービスフィー</th>
								<th>キャプション</th>
								<th colspan="2">メモ</th>
					        </tr>
					    </thead>
	<?php $_from = $this->_tpl_vars['service_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vv']):
?>
		<?php if ($this->_tpl_vars['v']['id'] == $this->_tpl_vars['vv']['category_id']): ?>
			    <tbody>
			    	 <tr id ='<?php echo $this->_tpl_vars['v']['id']; ?>
_<?php echo $this->_tpl_vars['vv']['id']; ?>
' >
						<td><?php echo $this->_tpl_vars['vv']['sku']; ?>
<br/><?php echo $this->_tpl_vars['vv']['service_menu']; ?>
</td>
						<td>
						<?php if ($this->_tpl_vars['vv']['spec_fee'] != ''): ?>
						<?php echo ((is_array($_tmp=$this->_tpl_vars['vv']['spec_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円（ス）
						<?php else: ?>
						-（ス）
						<?php endif; ?>
						<br/>
						<?php if ($this->_tpl_vars['vv']['service_fee'] != ''): ?>
						<?php echo ((is_array($_tmp=$this->_tpl_vars['vv']['service_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円（サ）
						<?php else: ?>
						-（サ）
						<?php endif; ?>
						</td>
						<td><?php echo $this->_tpl_vars['vv']['caption']; ?>
</td>
						<td><?php echo $this->_tpl_vars['vv']['memo']; ?>
</td>
						<td class="preview" ><a href="javascript:setServiceMaster('<?php echo $this->_tpl_vars['vv']['id']; ?>
','<?php echo $this->_tpl_vars['vv']['service_menu']; ?>
','<?php echo $this->_tpl_vars['vv']['spec_fee']; ?>
','<?php echo $this->_tpl_vars['vv']['service_fee']; ?>
')">セット</a></td>
						<input type="hidden" name="service_id" value="<?php echo $this->_tpl_vars['vv']['id']; ?>
" />
			        </tr>
			    </tbody>
		<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>
			</table>

</div>
<?php endforeach; endif; unset($_from); ?>
</section>
</div>
</body>
</html>