<?php /* Smarty version 2.6.26, created on 2013-03-25 15:16:38
         compiled from smp/service_help.html */ ?>
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
		<h1><span>&nbsp;</span>案件情報</h1>
	</header>
	<section class="content">
		<h2>サービス情報詳細</h2>
		<dl class="formList">
			<dt>未発注</dt><dd>約定がされていません。スペシャリストのスケジュール確保はこの状態では、確定できていません。</dd>
			<dt>発注確定</dt><dd>クライアント様がプレゴに発注した状態です。スペシャリストのスケジュール確保はこの状態では、確定できていません。</dd>
			<dt>約定確定</dt><dd>クライアント様がプレゴに発注し、スペシャリストが受託を確定しています。スペシャリストのスケジュール確保が決定しています。</dd>
			<dt>キャンセル済</dt><dd>約定がキャンセルされた状態です。</dd>
			<dt>業務完了</dt><dd>約定された業務が遂行完了された状態です。</dd>
			<dt>業務Ｓキャンセル</dt><dd>天変地異、悪天候、突然の傷病などで業務が遂行されなかった状態です。</dd>
		</dl>
	</section>
	
	<p class="btn"><input type="button" value="戻る" onclick="history.back();" /></p>
	
</div>

<footer>Copyright (C) Prego. / All rights reserved.</footer>

</body>
</html>