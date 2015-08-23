<?php /* Smarty version 2.6.26, created on 2013-03-25 16:42:48
         compiled from smp/account.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'smp/account.html', 65, false),)), $this); ?>
<!DOCTYPE html>
<html><head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=320,user-scalable=no" />
    <link href="./assets/styles/default.css" rel="stylesheet" />
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
		<h1><span>&nbsp;</span>登録情報</h1>
	</header>
	<section class="content">
		<h2>基本情報</h2>
		<dl class="formList">
			<dt>ID</dt>
			<dd><?php echo $this->_tpl_vars['spec_forms']['id']; ?>
</dd>
			<dt>登録日</dt>
			<dd><?php echo $this->_tpl_vars['spec_forms']['c_time']; ?>
</dd>
			<dt>更新日</dt>
			<dd><?php echo $this->_tpl_vars['spec_forms']['u_time']; ?>
</dd>
			<dt>氏名</dt>
			<dd><?php echo $this->_tpl_vars['spec_forms']['spec_name']; ?>
</dd>
			<dt>アルファベット</dt>
			<dd><?php echo $this->_tpl_vars['spec_forms']['interlingua']; ?>
</dd>
			<dt>メールアドレス</dt>
			<dd><?php echo $this->_tpl_vars['spec_forms']['mail_address1']; ?>
</dd>
			<dt>スペシャリスト分野</dt>
			<dd><?php echo $this->_tpl_vars['spec_area']; ?>
</dd>
			<dt>会社名 OR 商号</dt>
			<dd><?php echo $this->_tpl_vars['spec_forms']['corporate_name']; ?>
</dd>
			<dt>郵便番号</dt>
			<dd><?php echo $this->_tpl_vars['post_code']; ?>
</dd>
			<dt>住所</dt>
			<dd><?php echo $this->_tpl_vars['spec_forms']['address']; ?>
</dd>
			<dt>TEL</dt>
			<dd><?php echo $this->_tpl_vars['tel']; ?>
</dd>
			<dt>携帯TEL</dt>
			<dd><?php echo $this->_tpl_vars['phone']; ?>
</dd>
			<dt>FAX</dt>
			<dd><?php echo $this->_tpl_vars['fax']; ?>
</dd>
			<dt>生年月日</dt>
			<dd><?php echo $this->_tpl_vars['spec_forms']['birthday']; ?>
</dd>
		</dl>
	</section>

	<section class="content items">
		<h2>フィー情報</h2>
		<?php $_from = $this->_tpl_vars['fee_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['v']):
?>
		<dl class="itemList">
			<dt>サービスメニュー</dt>
			<dd><?php echo $this->_tpl_vars['v']['servers_menu']; ?>
</dd>
			<dt>スペシャリストフィー</dt>
			<dd>￥<?php echo ((is_array($_tmp=$this->_tpl_vars['v']['spec_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</dd>
		</dl>
		<?php endforeach; endif; unset($_from); ?>
	</section>



	<section class="content items">
		<h2>プロフィール情報</h2>
		<?php $_from = $this->_tpl_vars['profile_forms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vv']):
?>
		<dl class="itemList">
			<dt>プロフィール名</dt>
			<dd><a href="profile1.php?id=<?php echo $this->_tpl_vars['vv']['id']; ?>
"><?php echo $this->_tpl_vars['vv']['profile_name']; ?>
</a></dd>
			<dt>登録日</dt>
			<dd><?php echo $this->_tpl_vars['vv']['c_time']; ?>
</dd>
			<dt>更新日</dt>
			<dd><?php echo $this->_tpl_vars['vv']['u_time']; ?>
</dd>
		</dl>
		<?php endforeach; endif; unset($_from); ?>
	</section>

	<p class="btn"><a href="mailto:"><input type="button" value="変更依頼" /></a></p>

</div>

<footer>Copyright (C) Prego. / All rights reserved.</footer>

</body>
</html>