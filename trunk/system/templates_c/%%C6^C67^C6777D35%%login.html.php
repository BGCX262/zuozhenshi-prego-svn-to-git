<?php /* Smarty version 2.6.26, created on 2013-03-26 09:59:33
         compiled from smp/login.html */ ?>
<!DOCTYPE html>
<html><head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=320,user-scalable=no" />
    <link href="../assets/styles/default.css" rel="stylesheet" />
    <link href="../assets/styles/page/login.css" rel="stylesheet" />
	<script src="../assets/scripts/lib/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="../assets/scripts/main.js" type="text/javascript"></script>

   	<title>コントロールパネル</title>

</head>
<body id="login">

<header id="dashboard_header">
	<h1>
    	<a href="">コントロールパネル</a>
    </h1>
</header>

<div id="container">
	<header>
		<h1><span>&nbsp;</span>ログイン</h1>
	</header>
	<section class="content">
		<form action="login.php" method="post">
			<dl>
				<dt>メールアドレスとパスワードを入力して下さい</dt><span class="error"><?php echo $this->_tpl_vars['err_msg']; ?>
</span>
				<dd><input type="text" placeholder="ID" name="email" value="" /></dd>
				<dd><input type="password" placeholder="パスワード" name="login_pass" value="" /></dd>
			</dl>
			<p class="login_btn">
				<input type="submit" value="ログイン" />
			</p>
		</form>
	</section>
</div>

<footer>Copyright (C) Prego. / All rights reserved.</footer>

</body>
</html>