<?php

define('PAGE_MAX', 30 ); //毎ページ最大行数
define('PAGEING_MAX', 4 );//ページ数が多い場合、表示最大ページ数

define('PAGE_MAX_SEARH', 8 ); //毎検索ページ最大行数
define('PAGEING_MAX_SEARH', 5 );//検索ページ数が多い場合、表示最大ページ数

define("PREGO_VARTYPE_STR",      4);
define("PREGO_VARTYPE_INT",      2);
define("PREGO_VARTYPE_INTEGER",  PREGO_VARTYPE_INT);
define("PREGO_VARTYPE_STRING",   10);
/*
define("PREGO_SMTP_SERVER","smtp.mail.yahoo.co.jp");
define("PREGO_SMTP_PASS","123qaz");
define("PREGO_JP_MAIL","sasinnsi@yahoo.co.jp");
*/
define("PREGO_ZAIKIN_RATE",0.05);
define("PREGO_SMTP_SERVER","smtp.shift-jp.net");
define("PREGO_SMTP_PASS","yingwu");
define("PREGO_JP_MAIL","zou@shift-jp.net");
define("PREGO_MAIL_ADDRESS","zou@shift-jp.net");
$prego_mail = 'cs@prego.co.jp';
//$prego_mail = 'sasinnsi@yahoo.co.jp';
//define("PREGO_JP_MAIL","miyazawa@shift-jp.net");


define("PREGO_LOGIN_URL","http://www.pregosystem.biz");

define("PREGO_MAIL_CORPORATE_INSERT_SUBJECT","登録完了メール");
define("PREGO_MAIL_CORPORATE_INSERT_CONTENT_A","スペシャリストエージェンシープレゴへのクライアント様アカウント登録完了メールです。
ＩＤは");
define("PREGO_MAIL_CORPORATE_INSERT_CONTENT_B","、パスワードは");
define("PREGO_MAIL_CORPORATE_INSERT_CONTENT_C","です。
ログインご担当者を追加登録できます。
複数登録された場合は各種通知メールが,登録された全ご担当者に送られます。
ＩＤ、パスワードは共通です。
下記ＵＲＬよりログインできます。");

define("PREGO_MAIL_CORPORATE_UPDATE_SUBJECT","更新完了メール");
define("PREGO_MAIL_CORPORATE_UPDATE_CONTENT","スペシャリストエージェンシープレゴのクライアント様登録情報の変更が完了いたしました。
下記ＵＲＬよりログインできます。");

define("PREGO_MAIL_SPECIALIST_INSERT_SUBJECT","登録完了メール");
define("PREGO_MAIL_SPECIALIST_INSERT_CONTENT_A","スペシャリストエージェンシープレゴへのスペシャリスト様アカウント登録完了メールです。
ご登録ありがとうございました。
ＩＤは");
define("PREGO_MAIL_SPECIALIST_INSERT_CONTENT_B","、パスワードは");
define("PREGO_MAIL_SPECIALIST_INSERT_CONTENT_C","です。
下記ＵＲＬよりログインできます。");

define("PREGO_MAIL_SPECIALIST_UPDATE_SUBJECT","更新完了メール");
define("PREGO_MAIL_SPECIALIST_UPDATE_CONTENT","スペシャリストエージェンシープレゴのスペシャリスト登録情報・変更が完了しました。
以下ＵＲＬよりご確認ください。");

define("PREGO_MAIL_PROMISE_INSERT_SUBJECT","約定確定メール");
define("PREGO_MAIL_PROMISE_INSERT_CONTENT","スペシャリストエージェンシープレゴより、クライアント様案件の約定をシステムアップしています。
４日以内に、以下ＵＲＬより発注確定してください。
４日以内に約定確定されない場合は、案件が自動キャンセルされます。
ログインＵＲＬ");

define("PREGO_MAIL_CORPORATE_AGREEMENT_SUBJECT","発注確定メール");
define("PREGO_MAIL_CORPORATE_AGREEMENT_SPECIALIST_CONTENT","スペシャリストエージェンシープレゴより、スペシャリスト様案件の約定をシステムアップしています。
２４時間以内に、下記ログインＵＲＬより受託確定ください。
２４時間以内に約定確定されない場合、案件は自動キャンセルされます。");

define("PREGO_MAIL_CORPORATE_AGREEMENT_CORPORATE_CONTENT_A","スペシャリストエージェンシープレゴより、発注確定のメールです。");
define("PREGO_MAIL_CORPORATE_AGREEMENT_CORPORATE_CONTENT_B","様、発注確定いただきありがとうございます。
この後スペシャリストが受託確定をしたのち、約定成立となります。
発注内容はオンラインで、確認することができます。
ご発注内容を確認する場合は、下記ＵＲＬクライアント様アカウント画面をご利用ください。
ログインＵＲＬ");

define("PREGO_MAIL_SPECIALIST_AGREEMENT_SUBJECT","受注確定メール");
define("PREGO_MAIL_SPECIALIST_AGREEMENT_CONTENT","スペシャリストエージェンシープレゴより、約定確定のメールです。
約定内容はオンラインで、確認することができます。
業務前日には、プレゴより前日メールをお送りします。
ご不明点・ご質問等あれば、いつでもプレゴにご連絡ください。
業務のご成功を、心より応援しています。");

define("PREGO_MAIL_COMMUNICATION_MEMO_SUBJECT","業務完了メール");
define("PREGO_MAIL_COMMUNICATION_MEMO_SPECIALIST_CONTENT","本日の業務、お疲れ様でした。
業務に関して、ご意見・ご要望がございましたら、プレゴへご連絡ください。
プレゴはスペシャリスト様を全力でサポートしてまいります。");
define("PREGO_MAIL_COMMUNICATION_MEMO_CORPORATE_CONTENT","スペシャリストエージェンシープレゴより、本日の業務完了お知らせです。
プレゴのご利用、誠にありがとうございました。
クライアント様約定画面より満足度アンケートにご協力いただければ幸いです。
ログインＵＲＬ");

define("PREGO_MAIL_CANCEL_FEE_SUBJECT","キャンセルメール");
define("PREGO_MAIL_CANCEL_FEE_CONTENT","スペシャリストエージェンシープレゴより、約定キャンセルメールです。
キャンセル内容は、下記ログインＵＲＬよりご確認ください。");

define("PREGO_MAIL_CONFIRM_CANCEL_SUBJECT","実施しなかったメール");
define("PREGO_MAIL_CONFIRM_CANCEL_CONTENT","実施しなかったメール送信");

define("TWO_OR_THREE_DAYS_WARNING_EMAIL_SUBJECT","発注確定の警告メール");
define("TWO_OR_THREE_DAYS_WARNING_EMAIL_CONTENT","スペシャリストエージェンシープレゴより、クライアント様の案件につきまして、まだ発注確定をいただいていません。
あと２日で案件は自動的にキャンセルになります。
下記ログインＵＲＬより、発注確定をお願いします。");

define("ORDER_CONFIRM_EMAIL_SUBJECT","受注確定の警告メール");
define("ORDER_CONFIRM_EMAIL_CONTENT","スペシャリストエージェンシープレゴより、スペシャリスト様の案件につきまして、まだ受託確定をいただいていません。
あと２３時間で、案件は自動的にキャンセルされます。
下記ログインＵＲＬより、早急に受託確定をお願いします。");


$prego_account_sorts = array( 
	'1'  => '運営者',
	'2'  => 'クライアント',
	'3'  => 'スペシャリスト'
);

$prego_login_flgs = array(
	'0'  => 'ログイン可',
	'1'  => 'ログイン不可'
);

$prego_introducer_fee = array(
	'0'	 => '有り',
	'1'	 => '無し'	
);

$prego_introducer_fee_status = array(
	'0'	 => '済み',
	'1'	 => '未払い'
);

$prego_login_fee = array(
	'0'	 => '有り',
	'1'	 => '無し'
);

$prego_update_fee = array(
	'0'	 => '有り',
	'1'	 => '無し'
);

$prego_spec_area = array(
	'1'	 => 'スキンケア',
	'2'	 => 'メイク',
	'3'	 => '健康',
	'5'	 => '美容一般',
	'6'	 => 'フィットネス',
	'7'	 => 'フード・料理・栄養',
	'8'	 => 'コミュニケーション',
	'4'	 => 'その他'
);



$prego_account_kinds = array(
	'0'	 => '当座',
	'1'	 => '普通'	
);

$prego_person_choose = array(
	'0'	 => '法人',
	'1'	 => '個人'
);

$promise_spec_before_mail = array(
	'0' => '',
	'1' => ''
);
$promise_spec_overtime_have = array(
	'0'	 => 'なし',
	'1'  => 'あり'
);
$promise_spec_traffic_fee_have = array(
	'0'	 => 'なし',
	'1'  => 'あり'
);
$promise_spec_live_fee_have = array(
	'0'	 => 'なし',
	'1'  => 'あり'
);
$promise_spec_other_fee_have = array(
	'0'	 => 'なし',
	'1'  => 'あり'
);


$promise_status_arr = array(
	'0' => array('-','-','-','-'),
	'1' => array('クライアント送信済み','-','-',''),
	'2' => array('約定送信済み','-','-',''),
	'3' => array('約定確定','業務済み','-','-'),
	'4' => array('約定確定','-','キャンセル','-'),
	'5' => array('約定確定','-','実施しなかった','-'),
);

$overtime_arr = array(
		"1 月",
		"2 月",
		"3 月",
		"4 月",
		"5 月"
);

$year_arr = array();
$showtime  = date("Y");
$n = $showtime - 2012;

FOR ($i = $n; $i >=0; $i--)
{
  $now_year = 2013+$i;
 $year_arr[$now_year] =$now_year."年";
}

$month_arr = array(
		"1月",
		"2月",
		"3月",
		"4月",
		"5月",
		"6月",
		"7月",
		"8月",
		"9月",
		"10月",
		"11月",
		"12月"
);

$pay_status_arr = array(
		"0" => "-",
		"1" => "OK",
		"2" => "要修正"
		);

$hp_arr = array(
		"0" => "OK",
		"1" => "NG");

$m_prego_pro = array(
		"1" => "スキンケア",
		"2" => "メイク",
		"3" => "健康",
		"4" => "美容一般",
		"5" => "フィットネス",
		"6" => "フード・料理・栄養",
		"7" => "コミュニケーション",
		"99" => "その他（自由記入)"
);

$prego_local = array(
		''=> '都道府県',
		1 => '北海道',
		2 => '青森県',
		3 => '岩手県',
		4 => '宮城県',
		5 => '秋田県',
		6 => '山形県',
		7 => '福島県',
		8 => '茨城県',
		9 => '栃木県',
		10 => '群馬県',
		11 => '埼玉県',
		12 => '千葉県',
		13 => '東京都',
		14 => '神奈川県',
		15 => '新潟県',
		16 => '富山県',
		17 => '石川県',
		18 => '福井県',
		19 => '山梨県',
		20 => '長野県',
		21 => '岐阜県',
		22 => '静岡県',
		23 => '愛知県',
		24 => '三重県',
		25 => '滋賀県',
		26 => '京都府',
		27 => '大阪府',
		28 => '兵庫県',
		29 => '奈良県',
		30 => '和歌山県',
		31 => '鳥取県',
		32 => '島根県',
		33 => '岡山県',
		34 => '広島県',
		35 => '山口県',
		36 => '徳島県',
		37 => '香川県',
		38 => '愛媛県',
		39 => '高知県',
		40 => '福岡県',
		41 => '佐賀県',
		42 => '長崎県',
		43 => '熊本県',
		44 => '大分県',
		45 => '宮崎県',
		46 => '鹿児島県',
		47 => '沖縄県',
);


$prego_hour = array(
		0 => 0,
		1 => 1,
		2 => 2,
		3 => 3,
		4 => 4,
		5 => 5,
		6 => 6,
		7 => 7,
		8 => 8,
		9 => 9,
		10 => 10,
		11 => 11,
		12 => 12,
		13 => 13,
		14 => 14,
		15 => 15,
		16 => 16,
		17 => 17,
		18 => 18,
		19 => 19,
		20 => 20,
		21 => 21,
		22 => 22,
		23 => 23,
		24 => 24,
		
);
$prego_minute = array(
		0 => 0,
		30=> 30
);
?>
