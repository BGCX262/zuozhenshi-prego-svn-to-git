<?php /* Smarty version 2.6.26, created on 2013-03-25 16:43:00
         compiled from smp/opportunity.html */ ?>
<!DOCTYPE html>
<html><head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=320,user-scalable=no" />
    <link href="./assets/styles/default.css" rel="stylesheet" />
    <link href="./assets/styles/page/opportunity.css" rel="stylesheet" />
	<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="./assets/scripts/main.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(function(){
			$('.content').each(function(){
				var t = $(this);
				t.data("height",t.outerHeight());
				if(t.hasClass("close")){
					t.css({height:"36px"}).find('h2').addClass("active");
				}
			});
			$('.content h2').click(function(){
				var t = $(this);
				var c = t.hasClass("active");
				var p = t.closest(".content");

				if(c){
					var height = p.data('height');
					p.stop().animate({height:height + "px"},200);
					t.removeClass("active");
				}else {
					p.animate({height:"36px"},200).find('h2').addClass("active");
				}
			});
		});
	</script>

   	<title>コントロールパネル</title>

</head>
<body id="login">

<header id="dashboard_header">
	<h1>
    	<a href="index.php">コントロールパネル</a>
    </h1>
</header>

<div id="container">
	<header>
		<h1><span>&nbsp;</span>案件情報</h1>
	</header>
	<section class="content close" id="going">
		<h2><span>進行中案件</span></h2>
		<?php $_from = $this->_tpl_vars['promise_on_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
		<a href="opportunity_detail.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
&&status=2&&spec_id=<?php echo $this->_tpl_vars['spec_id']; ?>
">
			<dl class="formList">
				<dt>案件ID</dt>
				<dd><?php echo $this->_tpl_vars['v']['id']; ?>
</dd>
				<dt>クライアント</dt>
				<dd><?php echo $this->_tpl_vars['v']['corporate_name']; ?>
</dd>
				<dt>案件名</dt>
				<dd><?php echo $this->_tpl_vars['v']['promise_name']; ?>
</dd>
			</dl>
		</a>
		<?php endforeach; endif; unset($_from); ?>
	</section>

	<section class="content close" id="complete">
		<h2><span>完了のものを表示する</span></h2>
		<?php $_from = $this->_tpl_vars['promise_off_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vv']):
?>
		<a href="opportunity_detail.php?id=<?php echo $this->_tpl_vars['vv']['id']; ?>
&&status=3&&spec_id=<?php echo $this->_tpl_vars['spec_id']; ?>
">
			<dl class="formList">
				<dt>案件ID</dt>
				<dd><?php echo $this->_tpl_vars['vv']['id']; ?>
</dd>
				<dt>クライアント</dt>
				<dd><?php echo $this->_tpl_vars['vv']['corporate_name']; ?>
</dd>
				<dt>案件名</dt>
				<dd><?php echo $this->_tpl_vars['vv']['promise_name']; ?>
</dd>
			</dl>
		</a>
		<?php endforeach; endif; unset($_from); ?>
	</section>
</div>

<footer>Copyright (C) Prego. / All rights reserved.</footer>

</body>
</html>