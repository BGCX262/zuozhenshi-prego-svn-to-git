<?php /* Smarty version 2.6.26, created on 2013-03-25 16:31:46
         compiled from popup_contract_help.html */ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="./assets/styles/popup.css" rel="stylesheet" />

<script src="./assets/scripts/popup.js" type="text/javascript"></script>
<title>コントロールパネル</title>
<style>
	#status_help th ,
	#status_help td {text-align:left;font-size:12px;line-height:1.6;}
</style>
</head>
<body>
<div class="thisPopup" id="contract_help">
<header>
	<h1><span>&nbsp;</span>約定状況</h1>
</header>

<section id="content">
	<table class="sortable" id="status_help">
		<tbody>
			<tr><th>未発注</th><td>約定がされていません。スペシャリストのスケジュール確保はこの状態では、確定できていません。</td></tr>
			<tr><th>発注確定</th><td>クライアント様がプレゴに発注した状態です。スペシャリストのスケジュール確保はこの状態では、確定できていません。</td></tr>
			<tr><th>約定確定</th><td>クライアント様がプレゴに発注し、スペシャリストが受託を確定しています。スペシャリストのスケジュール確保が決定しています。</td></tr>
			<tr><th>キャンセル済</th><td>約定がキャンセルされた状態です。</td></tr>
			<tr><th>業務完了</th><td>約定された業務が遂行完了された状態です。</td></tr>
			<tr><th>業務Ｓキャンセル</th><td>天変地異、悪天候、突然の傷病などで業務が遂行されなかった状態です。</td></tr>
		</tbody>
	</table>
</section>
</div>
</body>
</html>