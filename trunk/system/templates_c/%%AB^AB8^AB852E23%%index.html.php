<?php /* Smarty version 2.6.26, created on 2013-03-25 16:42:59
         compiled from smp/index.html */ ?>
<!DOCTYPE html>
<html><head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=320,user-scalable=no" />
    <link href="./assets/styles/default.css" rel="stylesheet" />
    <link href="./assets/styles/page/index.css" rel="stylesheet" />
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
	<section class="content">
		<ul>
			<li><a href="account.php?id=<?php echo $this->_tpl_vars['id']; ?>
"><span>登録情報確認</span></a></li>
			<li><a href="opportunity.php?id=<?php echo $this->_tpl_vars['id']; ?>
"><span>案件情報</span></a></li>
			<li><a href="payment.php?id=<?php echo $this->_tpl_vars['id']; ?>
"><span>支払情報</span></a></li>
		</ul>
	</section>
</div>

<footer>Copyright (C) Prego. / All rights reserved.</footer>

</body>
</html>