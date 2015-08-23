<?php /* Smarty version 2.6.26, created on 2013-03-24 23:04:06
         compiled from popup_process_history.html */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/popup.css" rel="stylesheet" />

<script src="./assets/scripts/popup.js" type="text/javascript"></script>
<title>コントロールパネル</title>

</head>
<body>
<div class="thisPopup" id="process_history">

<header>
	<h1><span>&nbsp;</span>履歴一覧</h1>
</header>

<section id="content">
	<table class="sortable">
    <thead>
        <tr>
			<th>処理日時</th>
			<th>内容</th>
			<th>処理者</th>
        </tr>
    </thead>
    <tbody>
    <?php $_from = $this->_tpl_vars['operation_history_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
        <tr>
			<td><?php echo $this->_tpl_vars['v']['operate_time']; ?>
</td>
			<td><?php echo $this->_tpl_vars['v']['operate_details']; ?>
</td>
			<td><?php echo $this->_tpl_vars['v']['operate_man']; ?>
</td>
        </tr>
     <?php endforeach; endif; unset($_from); ?>
    </tbody>
	</table>
</section></div>
</body>
</html>