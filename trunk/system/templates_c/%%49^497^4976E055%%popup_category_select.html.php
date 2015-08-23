<?php /* Smarty version 2.6.26, created on 2013-03-25 13:36:15
         compiled from popup_category_select.html */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/popup.css" rel="stylesheet" />

<script src="./assets/scripts/popup.js" type="text/javascript"></script>
<title>コントロールパネル</title>
<script type="text/javascript">
	$(function(){
		$('#category_select #content .preview a').unbind('click').live('click',function(){
			var p = $(this).closest("tr");
			var id = p.attr("id");
			var category_name = $(".tName",p).html();
			//var id = $(this).children().next().val();
			//var id = $(this).children().next().children().val();
			//alert("*" + id + "*");
			setS(id, category_name);
			parent.$.colorbox.close();
		});
	});
</script>
</head>
<body>
<div class="thisPopup" id="category_select">

<header>
	<h1><span>&nbsp;</span>カテゴリ選択</h1>
</header>

<section id="content">
<form name="fm">
	<table class="sortable">
    <thead>
        <tr>
			<th colspan="2">カテゴリ名</th>
        </tr>
    </thead>
    <tbody>
    <?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
        <tr id ="<?php echo $this->_tpl_vars['v']['id']; ?>
">
			<td class="tName"><?php echo $this->_tpl_vars['v']['category_name']; ?>
</td><input type="hidden" name="id" value="<?php echo $this->_tpl_vars['v']['id']; ?>
" />
			<td class="preview" ><a href="javascript:;">セット</a></td>
        </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
	</table>
</form>
</section>
</div>
</body>
</html>