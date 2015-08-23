<?php /* Smarty version 2.6.26, created on 2013-03-25 16:44:30
         compiled from smp/service_detail.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'smp/service_detail.html', 49, false),)), $this); ?>
<!DOCTYPE html>
<html><head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=320,user-scalable=no" />
    <link href="./assets/styles/default.css" rel="stylesheet" />
	<script src="./assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="./assets/scripts/main.js" type="text/javascript"></script>

   	<title>コントロールパネル</title>

	<script type="text/javascript">

   		function changeVal(){
			var obj_u_id = document.getElementById('u_id');
   			var u_id = obj_u_id.value;
   			var obj_id = document.getElementById('service_id');
   			var id = obj_id.value;
   			window.location.href="service_detail.php"+"?id="+id+"&&u_id="+u_id;
   		}

   	</script>

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
		<h2>サービス情報詳細</h2>
		<dl class="formList">
			<dt>スペシャリスト</dt>
			<dd>
				<?php echo $this->_tpl_vars['promise_spec_forms']['spec_name']; ?>
<br />
				<a href="profile1.php?id=<?php echo $this->_tpl_vars['id']; ?>
"><?php echo $this->_tpl_vars['spec_profile_forms']['profile_name']; ?>
</a>
			</dd>
			<dt>サービス名</dt>
			<dd><?php echo $this->_tpl_vars['promise_spec_forms']['service_name']; ?>
</dd>
			<dt>実施日</dt>
			<dd><?php echo $this->_tpl_vars['promise_spec_forms']['doing_time']; ?>
</dd>
			<dt>スペシャリストフィー</dt>
			<dd>￥<?php echo ((is_array($_tmp=$this->_tpl_vars['service_forms']['service_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</dd>
			<dt>約定S <span><a href="service_help.php">ヘルプ</a></span></dt>
			<dd><?php echo $this->_tpl_vars['promise_s']; ?>
</dd>
			<dt>完了F</dt>
			<dd><?php echo $this->_tpl_vars['over_f']; ?>
</dd>
			<dt>CF</dt>
			<dd><?php echo $this->_tpl_vars['cf']; ?>
</dd>
			<dt>処理履歴</dt>
			<dd><a href="">参照</a></dd>
			<?php if ($this->_tpl_vars['promise_spec_forms']['status'] == 3 && isset ( $this->_tpl_vars['promise_spec_forms']['satisfy_status'] ) && ! empty ( $this->_tpl_vars['satisfy_status'] )): ?>
			<dt>アンケート</dt>
			<dd><?php echo $this->_tpl_vars['satisfy_status']; ?>
</dd>
			<?php endif; ?>
		</dl>
	</section>
	<input type="hidden" id="u_id" name="u_id" value="1"/>
	<input type="hidden" id="service_id" name="service_id" value="<?php echo $this->_tpl_vars['service_id']; ?>
"/>
	<?php if ($this->_tpl_vars['promise_spec_forms']['status'] == 1): ?>
	<p class="btn"><a href="mailto:"><input type="button" value="受注確定" onclick="changeVal()"/></a></p>
	<?php endif; ?>
</div>

<footer>Copyright (C) Prego. / All rights reserved.</footer>

</body>
</html>