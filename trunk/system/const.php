<?php

$status = array( 
			1 => '公開',
			0 => '非公開'
);

$project_type = array(
			1	=>	'新規立ち上げ',
			2	=>	'リニューアル',
			3	=>	'システム開発',
			4	=>	'サイトデザイン',
			5	=>	'保守・メンテナンス',
			6	=>	'プランニング'
);

$sight_type = array(
			1	=>	'コーポレートサイト',
			2	=>	'プロモーションサイト',
			3	=>	'ECサイト',
			4	=>	'ポータルサイト',
			5	=>	'ブログ'
);

$design1 = array(
			1	=>	'白背景',
			2	=>	'淡色背景',
			3	=>	'濃色背景',
			4	=>	'黒背景'
);

$design2 = array(
			1	=>	'寒色系',
			2	=>	'暖色系',
			3	=>	'低彩度',
			4	=>	'カラフル'
);

$design3 = array(
			1	=>	'青系メイン',
			2	=>	'赤系メイン',
			3	=>	'緑系メイン',
			4	=>	'黄系メイン'
);

$design4 = array(
			1	=>	'信頼感',
			2	=>	'シック',
			3	=>	'ポップ',
			4	=>	'やわらかい',
			5	=>	'堅い',
			6	=>	'おしゃれ'
);

$technique = array(
			1	=>	'Flash',
			2	=>	'Ajax',
			3	=>	'PHP',
			4	=>	'Movable Type',
			5	=>	'Wordpress'
);

$products = array(
			1	=>	'PIECE EC',
			2	=>	'PIECE CMS',
			3	=>	'PIECE CRM',
			4	=>	'かんたんCMS',
			5	=>	'INDEX PUBLISHER',
			6	=>	'Change IMG',
			7	=>	'Make Form',
			8	=>	'Net Watch',
			9	=>	'ちょいカート',
			10	=>	'eMart',
			11	=>	'EST'
);

$pref = array(
			0	=> '選択してください',
			1	=> '北海道',
			2	=> '青森県',
			3	=> '岩手県',
			4	=> '宮城県',
			5	=> '秋田県',
			6	=> '山形県',
			7	=> '福島県',
			8	=> '茨城県',
			9	=> '栃木県',
			10	=> '群馬県',
			11	=> '埼玉県',
			12	=> '千葉県',
			13	=> '東京都',
			14	=> '神奈川県',
			15	=> '新潟県',
			16	=> '富山県',
			17	=> '石川県',
			18	=> '福井県',
			19	=> '山梨県',
			20	=> '長野県',
			21	=> '岐阜県',
			22	=> '静岡県',
			23	=> '愛知県',
			24	=> '三重県',
			25	=> '滋賀県',
			26	=> '京都府',
			27	=> '大阪府',
			28	=> '兵庫県',
			29	=> '奈良県',
			30	=> '和歌山県',
			31	=> '鳥取県',
			32	=> '島根県',
			33	=> '岡山県',
			34	=> '広島県',
			35	=> '山口県',
			36	=> '徳島県',
			37	=> '香川県',
			38	=> '愛媛県',
			39	=> '高知県',
			40	=> '福岡県',
			41	=> '佐賀県',
			42	=> '長崎県',
			43	=> '熊本県',
			44	=> '大分県',
			45	=> '宮崎県',
			46	=> '鹿児島県',
			47	=> '沖縄県'
		);


// ステータス
$smarty->assign('select_status',array(
						1	=>	'公開',
						0	=>	'非公開',
						2	=>	'仮登録')
				);

// 有無
$smarty->assign('select_exist',array(
						0	=>	'なし',
						1	=>	'あり')
				);

// コントロール種別
$select_control = array(
						1	=>	'テキスト',
						2	=>	'プルダウン',
						3	=>	'チェックボックス',
						4	=>	'ラジオボタン',
						5	=>	'テキストエリア'
					);
$smarty->assign('select_control',$select_control );

// 文字種チェック
$smarty->assign('select_check',array(
						0	=>	'指定なし',
						1	=>	'半角英字',
						2	=>	'半角数字',
						3	=>	'半角英数字',
						4	=>	'半角英数字＋記号',
						5	=>	'ひらがな',
						6	=>	'カタカナ')
				);

// 正規表現
$smarty->assign('select_regexp',array(
						0	=>	'指定なし',
						1	=>	'E-Mailアドレス',
						2	=>	'URL')
				);

$smarty->assign('select_kana',array(
						''	=>	'選択してください',
						'a'	=>	'ア',
						'k'	=>	'カ',
						's'	=>	'サ',
						't'	=>	'タ',
						'n'	=>	'ナ',
						'h'	=>	'ハ',
						'm'	=>	'マ',
						'y'	=>	'ヤ',
						'r'	=>	'ラ',
						'w'	=>	'ワ')
					);



?>
