<?php
/**
* エラーチェッククラス
**/

class Class_ERROR{

	var $clear;
	var $tag_st;
	var $tag_ed;

	function Class_ERROR( $tag1 = '<p class="error">', $tag2 = '</p>' ){
		
		$this->clear = true;
		$this->tag_st = $tag1;
		$this->tag_ed = $tag2;
	}
	
	function format_msg($valmasg,$witherr=false){
		$this->clear = false;
		return $this->tag_st . $valmasg . $this->tag_ed;
	}
	


	function check( $value, $arrFunc, $default = '' ){

		//必須判定あり
		if( in_array('EXIST', $arrFunc) ){
			if (is_array($value)) {
				if (count($value) <=0) {
					$this->clear = false;
					return $this->tag_st . '必須項目です' . $this->tag_ed;
				}
				
			} else {
				if( $default != '' ){
					
					if( trim($value) == '' || $value == $default ){
						$this->clear = false;
						return $this->tag_st . '必須項目です' . $this->tag_ed;
					}
	
				}else{
					if( trim($value) == '' ){
						$this->clear = false;
						return $this->tag_st . '必須項目です' . $this->tag_ed;
					}
				}
		 	}
		}

        foreach ( $arrFunc as $key ) {

			switch( $key ){
			case "NUM":
				return $this->number_check( $value );
				break;

			case "ALNUM":
			 //半角英数チェック
				return $this->alnum_check( $value );
				break;
			case "ALPHA":
			//半角英数チェック
				return $this->alpha_check( $value );
				break;
			case "ALPHASPACE":
			 //半角英数チェック 空白
				return $this->alnum_checkspace( $value );
				break;
				
			case "YMD":
			//半角英数チェック
				return $this->myymd_check( $value );
				break;
			case "ZIP":
				return $this->zipcode_check( $value );
				break;
			case "TEL":
				return $this->tel_check( $value );
				break;

			case "EMAIL":
				return $this->mail_check( $value );
				break;
			case "FAX":
				return $this->fax_check( $value );
				break;
			case "URL":
				return $this->url_check( $value );
				break;
				
			case "KATAKANA":
				return $this->katakana_check( $value );
				break;

			case "HIRAKANA":
				return $this->hirakana_check( $value );
				break;

			case "YMD":
				return $this->ymd_check( $value );
				break;
			case "PLATFORM":
			//機種依存文字チェック
				return $this->platform_dependent_characters_filter( $value );
				break;
			}
        }
	}


	//必須チェック
	function exist_check( $value ){
		if( $value == '' ){
			$this->clear = false;
			return $this->tag_st . '必須項目です' . $this->tag_ed;
		}else{
			return '';
		}
	}
	
	//数値判定
	function number_check( $value ){
		if( is_numeric( $value ) ){
			return;
		}else{
			if( empty($value)  ){
				return ;
			}else{
				$this->clear = false;
				return $this->tag_st . '半角数字で入力して下さい' . $this->tag_ed;
			}
		}
	}
	
	//電話番号判定
	function tel_check( $value ){
	
		if( $value == '' ) return;
	
		if( preg_match("/^\d{2,5}\-\d{2,5}\-\d{4}$/", $value) ) {
			//if( preg_match("/[0-9\-]{1,}$/", $value) ) {
			return '';
		} else {
			if( $value == '--' ){
				return '';
			}else{
				$this->clear = false;
				return $this->tag_st . '電話番号正しく入力してください' . $this->tag_ed;
			}
		}
	
	}
	

	//郵便番号判定
	function zipcode_check( $value ){

	if( preg_match("/^\d{3}\-\d{4}$/", $value) ) {
		//if( preg_match("/[0-9\-]{1,}$/", $value) ) {
			return '';
	    } else {
			if( $value == '-' ){
				return '';
			}else{
				$this->clear = false;
				return $this->tag_st . '郵便番号正しく入力してください' . $this->tag_ed;
			}
	    }

	}

//FAX番号判定
	function fax_check( $value ){
	
		if( $value == '' ) return;
		
		if( preg_match("/^\d{2,5}\-\d{2,5}\-\d{4}$/", $value) ) {
			//if( preg_match("/[0-9\-]{1,}$/", $value) ) {
			return '';
		} else {
			if( $value == '--' ){
				return '';
			}else{
				$this->clear = false;
				return $this->tag_st . 'FAX番号正しく入力してください' . $this->tag_ed;
			}
		}
	
	}
	
	
	
	//年月日判定
	function ymd_check( $value ){
	
		if( preg_match("/^\d{4}\/\d{1,2}\/\d{1,2}/", $value ) ){
				
			$tmp = explode('/', $value);
			if( checkdate( $tmp[1], $tmp[2], $tmp[0] ) ){
				return;
			}else{
				$this->clear = false;
				return $this->tag_st . '日付正しく入力してください' . $this->tag_ed;
			}
				
		}else{
			if( $value == '' ){
				return;
			}else{
				$this->clear = false;
				return $this->tag_st . '日付正しく入力してください' . $this->tag_ed;
			}
		}
	
	}
	//年月日判定
	function myymd_check( $value ){
	
		if( preg_match("/^\d{4}\-\d{1,2}\-\d{1,2}/", $value ) ){
				
			$tmp = explode('-', $value);
			if( checkdate( $tmp[1], $tmp[2], $tmp[0] ) ){
				return;
			}else{
				$this->clear = false;
				return $this->tag_st . '日付正しく入力してください' . $this->tag_ed;
			}
				
		}else{
			if( $value == '' ){
				return;
			}else{
				$this->clear = false;
				return $this->tag_st . '日付正しく入力してください' . $this->tag_ed;
			}
		}
	
	}
	
	function time_check( $hour, $minute, $second ){
		if ( ($hour < 0) || ($hour > 23) )  {
			return false;
		}
		
		if ( ($minute < 0) || ($minute > 59) )  {
			return false;
		}
		if ( ($second < 0) || ($second > 59) )   {
			return false;
		}
		return true;
	}
	function set_time_msg( ){
			$this->clear = false;
			return $this->tag_st . '日付時間正しく入力してください' . $this->tag_ed;
	}
	
	
	//E-MAIL判定
	function mail_check( $value ){
		if( $value == '') return;
		if( preg_match("/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9_-]+[a-zA-Z0-9\._-]+\.[a-zA-Z]{1,4}$/", $value) ) {
			return;
			//return $this->Regex($value, '/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9_-]+[a-zA-Z0-9\._-]+\.[a-zA-Z]{1,4}$/');
		}else{
			$this->clear = false;
			return $this->tag_st . 'メール正しく入力してください' . $this->tag_ed;
		}
	}

	//URL判定
	function url_check( $value ){
		if( $value == '') return;
		if( preg_match("/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/", $value) ) {
			return;
		}else{
			$this->clear = false;
			return $this->tag_st . 'ＵＲＬ正しく入力してください' . $this->tag_ed;
		}
	}

	//ひらがな判定
	function hirakana_check( $value ){

		mb_regex_encoding("UTF-8");
		if( preg_match("/^[ぁ-ん]+$/u", $value) ){
			return;
		}else{
			$this->clear = false;
			return $this->tag_st . 'ひらがなで入力してください' . $this->tag_ed;
		}

	}

	//カタカナ判定
	function katakana_check( $value ){

		if( $value == '') return;
		mb_regex_encoding("UTF-8");
		if( preg_match("/^[ァ-ヶー]+$/u", $value) ){
			return;
		}else{
			$this->clear = false;
			return $this->tag_st . 'カタカナで入力してください' . $this->tag_ed;
		}

	}

	//半角英数チェック
	function alnum_check( $value ){
		
		if( preg_match("/^[!-~]+$/", $value)){
			return;
		}else{
			$this->clear = false;
			return $this->tag_st . '半角英数字で入力してください' . $this->tag_ed;
		}
		
	}
	
	//半角英数チェック
	function alnum_checkspace( $value ){
		
		if( preg_match("/^[a-zA-Z \t\n\r\f]+$/", $value)){
			return;
		}else{
			$this->clear = false;
			return $this->tag_st . '半角英数字で入力してください' . $this->tag_ed;
		}
		
	}
	
	// 半角英文チェック
	function alpha_check( $value ){
		if( preg_match("/^[A-Za-z]+$/", $value)){
			return;
		}else{
			$this->clear = false;
			return $this->tag_st . '半角英文で入力してください' . $this->tag_ed;
		}
	}
	

	// 機種依存文字チェック
	function platform_dependent_characters_filter( $text ){

		mb_regex_encoding('UTF-8');
		
		$pdc = '①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩ㍉㌔㌢㍍㌘㌧㌃㌶㍑㍗㌍㌦㌣㌫㍊㌻㎜㎝㎞㎎㎏㏄㎡㍻〝〟№㏍℡㊤㊥㊦㊧㊨㈱㈲㈹㍾㍽㍼∮∟⊿纊褜鍈銈蓜俉炻昱棈鋹曻彅丨仡仼伀伃伹佖侒侊侚侔俍偀倢俿倞偆偰偂傔僴僘兊兤冝冾凬刕劜劦勀勛匀匇匤卲厓厲叝﨎咜咊咩哿喆坙坥垬埈埇﨏塚增墲夋奓奛奝奣妤妺孖寀甯寘寬尞岦岺峵崧嵓﨑嵂嵭嶸嶹巐弡弴彧德忞恝悅悊惞惕愠惲愑愷愰憘戓抦揵摠撝擎敎昀昕昻昉昮昞昤晥晗晙晴晳暙暠暲暿曺朎朗杦枻桒柀栁桄棏﨓楨﨔榘槢樰橫橆橳橾櫢櫤毖氿汜沆汯泚洄涇浯涖涬淏淸淲淼渹湜渧渼溿澈澵濵瀅瀇瀨炅炫焏焄煜煆煇凞燁燾犱犾猤猪獷玽珉珖珣珒琇珵琦琪琩琮瑢璉璟甁畯皂皜皞皛皦益睆劯砡硎硤礰礼神祥禔福禛竑竧靖竫箞精絈絜綷綠緖繒罇羡羽茁荢荿菇菶葈蒴蕓蕙蕫﨟薰蘒﨡蠇裵訒訷詹誧誾諟諸諶譓譿賰賴贒赶﨣軏﨤逸遧郞都鄕鄧釚釗釞釭釮釤釥鈆鈐鈊鈺鉀鈼鉎鉙鉑鈹鉧銧鉷鉸鋧鋗鋙鋐﨧鋕鋠鋓錥錡鋻﨨錞鋿錝錂鍰鍗鎤鏆鏞鏸鐱鑅鑈閒隆﨩隝隯霳霻靃靍靏靑靕顗顥飼餧館馞驎髙髜魵魲鮏鮱鮻鰀鵰鵫鶴鸙黑ⅰⅱⅲⅳⅴⅵⅶⅷⅸⅹ￢￤＇＂';
		$pdc_array = Array();
		$pdc_text = str_replace(array("\r\n","\n","\r"), '', $text);

		while($iLen = mb_strlen($pdc, 'UTF-8')) {
			array_push($pdc_array, mb_substr($pdc, 0, 1, 'UTF-8'));
			$pdc = mb_substr($pdc, 1, $iLen, 'UTF-8');
		}
		
		foreach($pdc_array as $value) {
			if(preg_match("/(" . $value . ")/", $pdc_text)) {
				return $this->tag_st . '機種依存文字が使われています' . $this->tag_ed;
				break;
			}
		}
		return;
	}
	
	//桁数チェック
	/**
	 *
	 * 入力値定義 -strlen- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("min" => 下限値, "max" => 上限値)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public  function check_size($value, $maxsize, $params = NULL)
	{
		if (empty($params["charset"])) {
			$len = mb_strlen($value,"UTF8");
		} else {
			$len = mb_strlen($value, $params["charset"]);
		}
		//$len = strlen($value);
		
		if ($len) {
			if ($len > $maxsize) {
				 $this->clear = false;
				 return $this->tag_st . $maxsize . '以内文字を入力してください' .$this->tag_ed;
			}
		} 
		return;
	}
	public  function check_size_equal($value, $maxsize)
	{
		
		$len = mb_strlen($value,"UTF8");
		
		if ($len) {
			if ($len != $maxsize) {
				 $this->clear = false;
				 return $this->tag_st . $maxsize . '桁文字を入力してください' .$this->tag_ed;
			}
		} 
		return;
	}
}

?>