<?php /* Smarty version 2.6.26, created on 2013-03-25 16:43:17
         compiled from smp/opportunity_detail.html */ ?>
<!DOCTYPE html>
<html><head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=320,user-scalable=no" />
    <link href="./assets/styles/default.css" rel="stylesheet" />
    <link href="./assets/styles/page/opportunity.css" rel="stylesheet" />
	<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="./assets/scripts/main.js" type="text/javascript"></script>
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
	<section class="content">
		<h2>基本情報</h2>
		<dl class="formList">
			<dt>案件ID</dt>
			<dd><?php echo $this->_tpl_vars['promise_forms']['id']; ?>
</dd>
			<dt>登録日時</dt>
			<dd><?php echo $this->_tpl_vars['promise_forms']['c_time']; ?>
</dd>
			<dt>更新日時</dt>
			<dd><?php echo $this->_tpl_vars['promise_forms']['u_time']; ?>
</dd>
			<dt>クライアント</dt>
			<dd><?php echo $this->_tpl_vars['promise_forms']['corporate_name']; ?>
</dd>
			<dt>案件名</dt>
			<dd><?php echo $this->_tpl_vars['promise_forms']['promise_name']; ?>
</dd>
		</dl>



	</section>

	<section class="content">
		<h2>サービス情報一覧</h2>
		<?php $_from = $this->_tpl_vars['promise_spec_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
		<a href="service_detail.php?id=<?php echo $this->_tpl_vars['v']['id']; ?>
">
			<dl class="formList">
				<dt>サービス名</dt>
				<dd><?php echo $this->_tpl_vars['v']['service_name']; ?>
</dd>
				<dt>実施日</dt>
				<dd><?php echo $this->_tpl_vars['v']['doing_time']; ?>
</dd>
				<dt>約定S</dt>
				<?php if ($this->_tpl_vars['v']['status'] == 1): ?>
				<dd><?php echo $this->_tpl_vars['promise_s_1']; ?>
</dd>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['v']['status'] == 2): ?>
				<dd><?php echo $this->_tpl_vars['promise_s_2']; ?>
</dd>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['v']['status'] == 3): ?>
				<dd><?php echo $this->_tpl_vars['promise_s_3']; ?>
</dd>
				<?php endif; ?>
			</dl>
		</a>
		<?php endforeach; endif; unset($_from); ?>
	</section>
</div>

<footer>Copyright (C) Prego. / All rights reserved.</footer>

</body>
</html>