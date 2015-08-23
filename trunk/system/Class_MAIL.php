<?php
/**
*メール送信関連関数
* 
**/

class Class_MAIL{
	
	/**
	 *
	 * 書き込み時の改行コード
	 *
	 * @access    public
	 * @var       string
	 *
	 **/	
	public  static $newLineChar = "\n";
	
	public static function my_mail_to($value, $mails ){
		//return md5($value);
	
		mb_internal_encoding("utf-8");
	
		$subject = $value["title"];
		$body    = $value["text"];
		//$from = "lightbox@sdc";
		//ini_set( "SMTP", "localhost" );
		//ini_set( "smtp_port", 25 );
		//ini_set( "sendmail_from", $from );
		$bccs = implode(' ,', $mails) ;
	
		$header="From: sasinnsi@yahoo.co.jp";
		$header.="\n";
		$header = "Bcc:".$bccs ;
	
		//$header ="Bcc:zuo@it-art.jp,zou@shift-jp.net";
		$header .= "\n";
	
		if  (!@mb_send_mail("sasinnsi@yahoo.co.jp",$subject,$body,$header)) {
			// echo "*********mb_send_mailエラー**************";
			return false;
		}else {
			//echo "*********sucess**************";
			return true;
		}
	
	}
	
	
	public static function mail_to($value, $mails ){	
		//return md5($value);
		
		mb_language("japanese");
		mb_internal_encoding("utf-8");
		
		$email = mb_encode_mimeheader("チラシシステム") ."<zuo@it-art.jp>";
		
		$subject = $value["title"];
		$body    = $value["text"];
		
		//$from = "lightbox@sdc";
		//ini_set( "SMTP", "localhost" );
		//ini_set( "smtp_port", 25 );
		//ini_set( "sendmail_from", $from );
		$bccs = implode(' ,', $mails) ;
	
		$header="From: " .mb_encode_mimeheader("チラシシステム") ."<zuo@it-art.jp>";
		$header.="\n";
		$header = "Bcc:".$bccs ;
		
		//$header ="Bcc:zuo@it-art.jp,zou@shift-jp.net";
		$header .= "\n";
		
		if  (!@mb_send_mail(NULL,$subject,$body,$header)) {
		 // echo "*********mb_send_mailエラー**************";
			return false;
		 }else {
			//echo "*********sucess**************";
			 return true;
		}
		
	}
	
	public static function get_insshop_form_upd_text($oldVal, $newVal, $username ) {
		$new_line = self::$newLineChar ;
		$retval = array();
		$retval["title"] = "【チラシ手配システム】折込販売店情報が更新されました";
		
		//	販売店名
		$ins_shop_name   = $oldVal['ins_shop_name']."販売店" ;
		if ( $oldVal['ins_shop_name'] == $newVal['ins_shop_name']) {
			$ins_shop_name = $ins_shop_name."【".$oldVal['ins_shop_cd']."】";
		} else {
			$ins_shop_name = $ins_shop_name."　→　".$newVal['ins_shop_name']."販売店【".$oldVal['ins_shop_cd']."】";
		}
		
		//	都道府県
		$local_name   = $oldVal['local_name'] ;
		if ( $oldVal['local_cd'] != $newVal['local_cd']) {
			$local_name = $local_name."　→　".$newVal['local_name'];
		}
		
		//	媒体名
		$media_name   = $oldVal['media_name'] ;
		
		//if ( $oldVal['media_name'] != $newVal['media_name']) {
		//	$media_name = $media_name."　→　".$newVal['media_name'];
		//}
		
		//	納品先
		$delive_name   = $oldVal['delive_name'] ;
		if ( $oldVal['delive_name'] != $newVal['delive_name']) {
			$delive_name = $delive_name."　→　".$newVal['delive_name'];
		}
		
		//	折込会社部数
		$insert_conums   = $oldVal['insert_conums']."部" ;
		if ( $oldVal['insert_conums'] != $newVal['insert_conums']) {
			$insert_conums = $insert_conums."　→　".$newVal['insert_conums']."部";
		}
		
		//	廃止日
		$stop_date   = Class_PWD::int8_to_date( $newVal['stop_date'] );
		
		//	備考
		$memo   = $newVal['memo'];
		
		$retval["text"] = "{$new_line}" .
				"関係各位{$new_line}" .
				"{$new_line}" .
				"チラシ手配システムからの自動送信メールです。{$new_line}" .
				"{$new_line}" .
				"折込販売店情報が{$username}によって更新されました。{$new_line}" .
				"更新内容は下記のとおりです。{$new_line}" .
				"{$new_line}" .
				"{$ins_shop_name}{$new_line}" .
				"都道府県：{$local_name}{$new_line}" .
				"媒体名：{$media_name}{$new_line}" .
				"納品先：{$delive_name}{$new_line}" .
				"販売店部数：{$insert_conums}{$new_line}" .
				"廃止日：{$stop_date}{$new_line}" .
				"情報更新理由：{$memo}{$new_line}" .
				"{$new_line}" .
				"以上です。{$new_line}" .
				"部数等が変更になった折込パターン情報などの見直しをお願いいたします。{$new_line}"; 
		return $retval;
	}
	
	public static function get_insshop_csv_upd_text($ins_cos, $username ) {
		$new_line = self::$newLineChar ;
		$retval = array();
		$retval["title"] = "【チラシ手配システム】折込販売店情報が更新されました";
		$ins_co_msg = "";
		foreach ($ins_cos as $k => $v) {
			$ins_co_msg  = $ins_co_msg."{$v}管理の全折込販売店情報{$new_line}";
		}
		$retval["text"] = "{$new_line}" .
				"関係各位{$new_line}" .
				"{$new_line}" .
				"チラシ手配システムからの自動送信メールです。{$new_line}" .
				"{$new_line}" .
				"折込販売店情報が{$username}によって更新されました。{$new_line}" .
				"影響を受ける更新範囲は下記のとおりです。{$new_line}" .
				"{$new_line}" .
				"{$ins_co_msg}{$new_line}" .
				"{$new_line}" .
				"以上です。{$new_line}" .
				"{$new_line}" .
				"大幅に販売店情報が変更になっている可能性が高いので、{$new_line}" .
				"必ず折込パターン情報などの見直しをお願いいたします。"; 
		return $retval;
	}

}

?>