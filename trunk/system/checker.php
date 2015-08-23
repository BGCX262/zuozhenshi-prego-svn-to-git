<?php
/**
 *
 * web_smartForm_checker - フォーム入力エラー判別クラス
 *
 * @package     Jazz
 * @category    web
 * @author      Shogo Kawase <shogo@arcstyle.jp>
 * @copyright   Arc Style Inc.
 * @version     CVS: $Id: checker.php 19305 2011-10-11 12:07:28Z yuk $
 *
 **/
// {{{ class web_smartForm_checker
class web_smartForm_checker extends jazz
{
	// {{{ checkAlphabet()
	/**
	 *
	 * 入力値定義 -alphabet- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkAlphabet($value)
	{
		return preg_match('/^[a-zA-Z]*$/', $value) ? TRUE : FALSE;
	}
	// }}} checkAlphabet()

	// {{{ checkAlphanumeric()
	/**
	 *
	 * 入力値定義 -alphanumeric- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkAlphanumeric($value)
	{
		return preg_match('/^[a-zA-Z0-9]*$/', $value) ? TRUE : FALSE;
	}
	// }}} checkAlphanumeric()

	// {{{ checkAscii()
	/**
	 *
	 * 入力値定義 -ascii- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkAscii($value)
	{
		return preg_match('/^[\x20-\x7e\r\n]*$/', $value) ? TRUE : FALSE;
	}
	// }}} checkAscii()
	
	// {{{ checkBitcount()
	/**
	 *
	 * 入力値定義 -bitcount- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("min" => 下限値, "max" => 上限値)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkBitcount($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (!is_numeric($value) || (floor($value) != $value)) {
			return FALSE;
		}
		return self::_checkRange(substr_count(decBin($value), '1'), $params);
	}
	// }}} checkBitcount()

	// {{{ checkBitmask()
	/**
	 *
	 * 入力値定義 -bitmask- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト
	 * @param     array       $params     属性値配列：array("mask" => マスク値)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkBitmask($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (!is_numeric($value) || (floor($value) != $value)) {
			return FALSE;
		} elseif (isset($params["mask"]) || !strlen($mask = $params["mask"]) || !is_numeric($mask) || (floor($mask) != $mask)) {
			return FALSE;
		}
		return (bool)(0 != ($value & $mask));
	}
	// }}} checkBitmask()
	
	// {{{ checkChartype()
	/**
	 *
	 * 入力値定義 -chartype- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("type")
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkChartype($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (isset($params["type"]) && strlen($type = strToLower($params["type"]))) {
			switch ($type) {
				case "alphabet":
				case "alphanumeric":
				case "ascii":
				case "hiragana":
				case "katakana":
				case "numeric":
					return call_user_func(array("web_smartForm_checker", sprintf('check%s', ucFirst($type))), $value, NULL);
			}
		}
		return TRUE;
	}
	// }}} checkChartype()
	
	// {{{ checkCompare()
	/**
	 *
	 * 入力値定義 -compare- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("idref" => 比較対象値, "expr" => 比較式, "type" => 比較方法)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkCompare($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (!isset($params["idref"]) || is_null($source = $params["idref"])) {
			return FALSE;
		} elseif (!isset($params["expr"]) || is_null($expr = $params["expr"])) {
			return FALSE;
		}
		// 比較の実行
		$result = 0;
		if (!isset($params["type"]) || !strlen($type = $params["type"]) || ($type == "auto")) {
			$type = (is_numeric($value) && is_numeric($source)) ? "num" : "str";
		}
		switch ($type) {
			case "num":
				// 数値として比較
				$result = $value - $source;
				break;
			
			case "str":
				// ケース依存文字列として比較
				$result = strcmp($value, $source);
				break;
			
			case "stri":
				// ケース非依存文字列として比較
				$result = strncasecmp($value, $source);
				break;
			
			case "timestamp":
			case "seconds":
				// 日時表現として秒単位で比較
				$value  = dateTime_convert::strToTime($value);
				$source = dateTime_convert::strToTime($source);
				$result = $value - $source;
				break;
				
			case "minutes":
				// 日時表現として分単位で比較
				$value  = dateTime_convert::strToTime($value);
				$source = dateTime_convert::strToTime($source);
				$result = floor(($value - $source) / 60);
				break;
				
			case "hours":
				// 日時表現として時単位で比較
				$value  = dateTime_convert::strToTime($value);
				$source = dateTime_convert::strToTime($source);
				$result = floor(($value - $source) / 3600);
				break;
				
			case "days":
				// 日時表現として日単位で比較
				$value  = dateTime_convert::strToTime($value);
				$source = dateTime_convert::strToTime($source);
				$result = floor(($value - $source) / 86400);
				break;
				
			case "months":
				// 日時表現として月単位で比較
				$value  = dateTime_convert::strToTime($value);
				$value  = (int)date("Y", $value) * 12 + (int)date("n", $value);
				$source = dateTime_convert::strToTime($source);
				$source = (int)date("Y", $source) * 12 + (int)date("n", $source);
				$result = $value - $source;
				if (dateTime_convert::strToTime(date("Y-m-d H:i:s", $source) . " + {$span} month") > $value) {
					--$result;
				}
				break;
				
			case "years":
				// 日時表現として年単位で比較
				$value  = (int)date("Y", dateTime_convert::strToTime($value));
				$source = (int)date("Y", dateTime_convert::strToTime($source));
				$result = $value - $source;
				if (dateTime_convert::strToTime(date("Y-m-d H:i:s", $source) . " + {$span} year") > $value) {
					--$result;
				}
				break;
		}
		// $value値は$source値と比較されたときに$expr条件式を満たさなくてはならない
		return eval("return (bool)(\$result {$expr});");
	}
	// }}} checkCompare()

	// {{{ checkDate()
	/**
	 *
	 * 入力値定義 -date- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("min" => 下限値, "max" => 上限値, "strict" => 厳密検査の可否)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkDate($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (!preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $match)) {
			return FALSE;
		}
		list($dummy, $y, $m, $d) = $match;
		if (isset($params['strict']) && !empty($params['strict']) && !dateTime_calendar::isValid($y, $m, $d)) {
			return FALSE;
		}
		return self::_checkDateRange(sprintf('%04d-%02d-%02d', $y, $m, $d), $params);
	}
	// }}} checkDate()

	// {{{ checkDatetime()
	/**
	 *
	 * 入力値定義 -datetime- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("min" => 下限値, "max" => 上限値, "strict" => 厳密検査の可否)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkDatetime($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (!preg_match('/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/', $value, $match)) {
			return FALSE;
		}
		list($dummy, $y, $m, $d, $h, $i, $s) = $match;
		if (isset($params['strict']) && !empty($params['strict'])) {
			if (!dateTime_calendar::isValid($y, $m, $d) || ($h > 23) || ($h < 0) || ($i > 59) || ($i < 0) || ($s > 59) || ($s < 0)) {
				return FALSE;
			}
		}
		return self::_checkDateRange(sprintf('%04d-%02d-%02d %02d:%02d:%02d', $y, $m, $d, $h, $i, $s), $params);
	}
	// }}} checkDatetime()
	
	// {{{ checkEmail()
	/**
	 *
	 * 入力値定義 -email- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("type" => E-MAILアドレス種別定数値)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkEmail($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		}
		if (!isset($params["type"]) || !strlen($types = str_replace("rfc", "rfc2821", $params["type"]))) {
			$types = "all";
		}
		require_once "string/regex.php";
		$type = 0;
		foreach (explode("|", $types) as $t) {
			$name  = sprintf("JAZZ_STRING_REGEX_MAILADDRESS_%s", strToUpper(trim($t)));
			if (defined($name)) {
				$type |= constant($name);
			}
		}
		$regex = string_regex::mailAddress($type);
		return preg_match("/^{$regex}$/", $value) ? TRUE : FALSE;
	}
	// }}} checkEmail()
	
	// {{{ checkFileisvalid()
	/**
	 *
	 * 入力値定義 -fileisvalid- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkFileisvalid($value)
	{
		$check = array(UPLOAD_ERR_PARTIAL, UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE);
		return !self::checkFilenotnull($value) || !in_array($value["error"], $check);
	}
	// }}} checkFileisvalid()
	
	// {{{ checkFilename()
	/**
	 *
	 * 入力値定義 -filename- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("regex" => PCRE互換正規表現)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkFilename($value, $params = NULL)
	{
		if (!self::checkFilenotnull($value)) {
			return TRUE;
		}
		return self::_checkRegex($value["name"], $params);
	}
	// }}} checkFilename()
	
	// {{{ checkFilenotnull()
	/**
	 *
	 * 入力値定義 -filenotnull- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkFilenotnull($value)
	{
		foreach (array("name", "type", "size", "tmp_name", "error") as $key) {
			if (!isset($value[$key])) {
				return FALSE;
			}
		}
		return (bool)($value["error"] != UPLOAD_ERR_NO_FILE);
	}
	// }}} checkFilenotnull()
	
	// {{{ checkFilesize()
	/**
	 *
	 * 入力値定義 -filesize- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("min" => 下限値, "max" => 上限値)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkFilesize($value, $params = NULL)
	{
		if (!self::checkFilenotnull($value)) {
			return TRUE;
		} elseif (in_array($value["error"], array(UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE))) {
			return FALSE;
		}
		return self::_checkRange($value["size"], $params);
	}
	// }}} checkFilesize()

	// {{{ checkHiragana()
	/**
	 *
	 * 入力値定義 -hiragana- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkHiragana($value)
	{
		return string_multibyte::isHiragana($value);
	}
	// }}} checkHiragana()

	// {{{ checkHtmlcolor()
	/**
	 *
	 * 入力値定義 -htmlcolor- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkHtmlcolor($value)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (!preg_match('/^#([0-9A-F]{3}|[0-9A-F]{6})$/i', $value)) {
			$colors = array(
				"black", "navy", "darkblue", "mediumblue", "blue", "darkgreen",
				"green", "teal", "darkcyan", "deepskyblue", "darkturquoise",
				"mediumspringgreen", "lime", "springgreen", "aqua", "cyan",
				"midnightblue", "dodgerblue", "lightseagreen", "forestgreen",
				"seagreen", "darkslategray", "limegreen", "mediumseagreen",
				"turquoise", "royalblue", "steelblue", "darkslateblue",
				"mediumturquoise", "indigo", "darkolivegreen", "cadetblue",
				"cornflowerblue", "mediumaquamarine", "dimgray", "slateblue",
				"olivedrab", "slategray", "lightslategray", "mediumslateblue",
				"lawngreen", "chartreuse", "aquamarine", "maroon", "purple",
				"olive", "gray", "skyblue", "lightskyblue", "blueviolet",
				"darkred", "darkmagenta", "saddlebrown", "darkseagreen",
				"lightgreen", "mediumpurple", "darkviolet", "palegreen",
				"darkorchid", "yellowgreen", "sienna", "brown", "darkgray",
				"lightblue", "greenyellow", "paleturquoise", "lightsteelblue",
				"powderblue", "firebrick", "darkgoldenrod", "mediumorchid",
				"rosybrown", "darkkhaki", "silver", "mediumvioletred", "indianred",
				"peru", "chocolate", "tan", "lightgrey", "thistle", "orchid",
				"goldenrod", "palevioletred", "crimson", "gainsboro", "plum",
				"burlywood", "lightcyan", "lavender", "darksalmon", "violet",
				"palegoldenrod", "lightcoral", "khaki", "aliceblue", "honeydew",
				"azure", "sandybrown", "wheat", "beige", "whitesmoke", "mintcream",
				"ghostwhite", "salmon", "antiquewhite", "linen", "lightgoldenrodyellow",
				"oldlace", "red", "fuchsia", "magenta", "deeppink", "orangered",
				"tomato", "hotpink", "coral", "darkorange", "lightsalmon", "orange",
				"lightpink", "pink", "gold", "peachpuff", "navajowhite", "moccasin",
				"bisque", "mistyrose", "blanchedalmond", "papayawhip", "lavenderblush",
				"seashell", "cornsilk", "lemonchiffon", "floralwhite", "snow", "yellow",
				"lightyellow", "ivory", "white", "activeborder", "activecaption",
				"appworkspace", "background", "buttonface", "buttonhighlight", "buttonshadow",
				"buttontext", "captiontext", "graytext", "highlight", "highlighttext",
				"inactiveborder", "inactivecaption", "inactivecaptiontext", "infobackground",
				"infotext", "menu", "menutext", "scrollbar", "threeddarkshadow", "threedface",
				"threedhighlight", "threedlightshadow", "threedshadow", "window", "windowframe", "windowtext"
				);
			if (!in_array(strToLower($value), $colors)) {
				return FALSE;
			}
		}
		return TRUE;
	}
	// }}} checkHtmlcolor()

	// {{{ checkInt()
	/**
	 *
	 * 入力値定義 -int- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("min" => 下限値, "max" => 上限値)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkInt($value, $params)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (!is_numeric($value) || ((string)(int)$value !== (string)$value)) {
			return FALSE;
		}
		return self::_checkRange($value, $params);
	}
	public static function checkInteger($value, $params)
	{
		return self::checkInt($value, $params);
	}
	// }}} checkInt()
	
	// {{{ checkIpv4()
	/**
	 *
	 * 入力値定義 -ipv4- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkIpv4($value)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (preg_match('/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/', $value, $m)) {
			for ($i = 1; $i <= 4; ++$i) {
				if ($m[$i] < 0 || $m[$i] > 255) {
					return FALSE;
				}
			}
			return TRUE;
		}
		return FALSE;
	}
	// }}} checkIpv4()

	// {{{ checkKatakana()
	/**
	 *
	 * 入力値定義 -katakana- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkKatakana($value)
	{
		return string_multibyte::isKatakana($value);
	}
	// }}} checkKatakana()

	// {{{ checkMimetype()
	/**
	 *
	 * 入力値定義 -mimetype- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("regex" => PCRE互換正規表現)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkMimetype($value, $params = NULL)
	{
		if (!self::checkFilenotnull($value)) {
			return TRUE;
		}
		return self::_checkRegex($value["type"], $params);
	}
	// }}} checkMimetype()
	
	// {{{ checkNotdependence()
	/**
	 *
	 * 入力値定義 -notdependence- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array()
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkNotdependence($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		}
		// 文字コード範囲参考URL：http://memo.xight.org/2006-06-19-13
		$tmp = array(
			'\xE2' => array(
			  // ℃(E28483)は除外
				// '\x84[\x80-\xB8]',
				'\x84[\x80-\x82\x84-\xB8]',
				'\x85[\x93-\xBF]',
				// ←↑→↓は除外
				// '\x86[\x80-\x82\x90-\x9F]',
				'\x86[\x80-\x82\x94-\x9F]',
				'\x91[\xA0-\xBF]',
				'\x92[\x80-\xBF]',
				'\x93[\x80-\xAF]',
				// ☆★は除外
				// '\x98[\x80-\x93\x9A-\xBF]',
				'\x98[\x80-\x84\x87\x93\x9A-\xBF]',
				// ♪♭♯は除外
				// '\x99[\x80-\xAF]',
				'\x99[\x80-\xA9\xAB\xAC\xAE]',
			),
			'\xE3' => array(
				'\x88[\xA0-\xBF]',
				'\x89[\x80-\x83]',
				'\x8A[\x80-\xBF]',
				'\x8B[\x80-\x8B\x90-\xBE]',
				'\x8C[\x80-\xBF]',
				'\x8D[\x80-\xB6\xBB-\xBF]',
				'\x8E[\x80-\xBF]',
				'\x8F[\x80-\xBE]',
			),
		);
		$regex = array();
		foreach ($tmp as $key => $range) {
			$regex[] = sprintf('%s(?:%s)', $key, implode('|', $range));
		}
		$regex = implode('|', $regex);
		return preg_match("/{$regex}/", $value) ? FALSE : TRUE;
	}
	// }}} checkNotdependence()
	
	// {{{ checkNothtml()
	/**
	 *
	 * 入力値定義 -nothtml- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkNothtml($value)
	{
		$allowTags = $denyTags = NULL;
		if (isset($params["allowtags"]) && strlen($tmp = $params["allowtags"])) {
			$allowTags = explode(",", $tmp);
		} elseif (isset($params["denytags"]) && strlen($tmp = $params["denytags"])) {
			$denyTags  = explode(",", $tmp);
		}
		require_once "string/html.php";
		return (bool)($value == string_html::stripTags($value, $allowTags, $denyTags));
	}
	// }}} checkNothtml()

	// {{{ checkNotnull()
	/**
	 *
	 * 入力値定義 -notnull- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkNotnull($value)
	{
		return strlen($value) ? TRUE : FALSE;
	}
	// }}} checkNotnull()

	// {{{ checkNull()
	/**
	 *
	 * 入力値定義 -null- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkNull($value)
	{
		return !self::checkNotnull($value);
	}
	// }}} checkNull()

	// {{{ checkNumeric()
	/**
	 *
	 * 入力値定義 -numeric- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("min" => 下限値, "max" => 上限値)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkNumeric($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (!is_numeric($value)) {
			return FALSE;
		}
		return self::_checkRange($value, $params);
	}
	// }}} checkNumeric()
	
	// {{{ checkRange()
	/**
	 *
	 * 入力値定義 -range- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("min" => 下限値, "max" => 上限値)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkRange($value, $params)
	{
		return self::checkNumeric($value, $params);
	}
	// }}} checkRange()
	
	// {{{ checkRegex()
	/**
	 *
	 * 入力値定義 -regex- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("type" => 正規表現種別)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkRegex($value, $params)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (isset($params["type"]) && strlen($type = strToLower($params["type"]))) {
			switch ($type) {
				case "email":
				case "url":
				case "htmlcolor":
				case "ipv4":
					return call_user_func(array("web_smartForm_checker", sprintf('check%s', ucFirst($type))), $value, NULL);
			}
		}
		return TRUE;
	}
	// }}} checkRegex()
	
	// {{{ checkSize()
	/**
	 *
	 * 入力値定義 -size- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("min" => 下限値, "max" => 上限値)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkSize($value, $params = NULL)
	{
		if (empty($params["charset"])) {
			$len = strlen($value);
		} else {
			$tmp = string_multibyte::convertEncoding($value, $params["charset"], JAZZ_INNER_ENCODING);
			$len = strlen($tmp);
		}
		return !strlen($value) ? TRUE : self::_checkRange($len, $params);
	}
	// }}} checkSize()
	
	// {{{ checkSpan()
	/**
	 *
	 * 入力値定義 -span- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("min" => 下限値, "max" => 上限値)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkSpan($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		}
		return self::_checkDateRange($value, $params);
	}
	// }}} checkSpan()
	
	// {{{ checkString()
	/**
	 *
	 * 入力値定義 -string- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("regex" => PCRE互換正規表現)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkString($value, $params = NULL)
	{
		return self::_checkRegex($value, $params);
	}
	// }}} checkString()
	
	// {{{ checkStrlen()
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
	public static function checkStrlen($value, $params = NULL)
	{
		if (empty($params["charset"])) {
			$len = mb_strlen($value);
		} else {
			$len = mb_strlen($value, $params["charset"]);
		}
		return !mb_strlen($value) ? TRUE : self::_checkRange($len, $params);
	}
	// }}} checkStrlen()
	
	// {{{ checkTel()
	/**
	 *
	 * 入力値定義 -tel- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkTel($value)
	{
		return self::_checkRegex($value, array("regex" => '/^0\d{1,4}-\d{1,4}-\d{1,4}$/'));
	}
	// }}} checkTel()

	// {{{ checkTime()
	/**
	 *
	 * 入力値定義 -time- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("min" => 下限値, "max" => 上限値, "strict" => 厳密検査の可否)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkTime($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (!preg_match('/^(\d{2}):(\d{2}):(\d{2})$/', $value, $match)) {
			return FALSE;
		}
		list($dummy, $h, $i, $s) = $match;
		
		if (isset($params['strict']) && !empty($params['strict']) && ($h > 23 || $h < 0 || $i > 59 || $i < 0 || $s > 59 || $s < 0)) {
			return FALSE;
		}
		$time = (int)$h * 3600 + (int)$i * 60 + (int)$s;
		
		if (isset($params["min"]) && strlen($min = $params["min"])) {
			if (preg_match('/(\d{2})(?:(\d{2})(?:(\d{2}))?)?/', $min, $match)) {
				if ($time < ((int)$match[1] * 3600 + (int)@$match[2] * 60 + (int)@$match[3])) {
					return FALSE;
				}
			}
		}
		if (isset($params["max"]) && strlen($max = $params["max"])) {
			if (preg_match('/(\d{2})(?:(\d{2})(?:(\d{2}))?)?/', $max, $match)) {
				if ($time > ((int)$match[1] * 3600 + (int)@$match[2] * 60 + (int)@$match[3])) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}
	// }}} checkTime()
	
	// {{{ checkUrl()
	/**
	 *
	 * 入力値定義 -url- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @param     array       $params     属性値配列：array("scheme" => URLスキーム正規表現)
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkUrl($value, $params = NULL)
	{
		if (!strlen($value)) {
			return TRUE;
		}
		require_once "string/url.php";
		return string_url::isValid($value, @$params["scheme"]);
	}
	// }}} checkUrl()

	// {{{ checkZipcode()
	/**
	 *
	 * 入力値定義 -zipcode- チェック
	 *
	 * @access    public
	 * @param     mixed       $value      検査対象のリクエスト値
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function checkZipcode($value)
	{
		return self::_checkRegex($value, array("regex" => '/^\d{3}-?\d{4}$/'));
	}
	// }}} checkZipcode()
	
	// {{{ _checkRegex()
	/**
	 *
	 * 正規表現チェック
	 *
	 * @access    public
	 * @param     mixed       $value      チェック対象の値
	 * @param     array       $params     regexを含んだ属性値配列
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	public static function _checkRegex($value, $params)
	{
		if (!strlen($value)) {
			return TRUE;
		} elseif (!isset($params["regex"]) || !strlen($regex = $params["regex"])) {
			return FALSE;
		}
		return preg_match($regex, $value) ? TRUE : FALSE;
	}
	// }}} _checkRegex()
	
	// {{{ _checkRange()
	/**
	 *
	 * 範囲値チェック
	 *
	 * @access    public
	 * @param     mixed       $value      チェック対象の値
	 * @param     array       $params     min, maxを含んだ属性値配列
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	protected static function _checkRange($value, $params)
	{
		if (isset($params["min"]) && is_numeric($params["min"])) {
			if ($value < $params["min"]) {
				return FALSE;
			}
		}
		if (isset($params["max"]) && is_numeric($params["max"])) {
			if ($value > $params["max"]) {
				return FALSE;
			}
		}
		return TRUE;
	}
	// }}} _checkRange()
	
	// {{{ _checkDateRange()
	/**
	 *
	 * 日時文字列の範囲値チェック
	 *
	 * @access    public
	 * @param     mixed       $value      チェック対象の値
	 * @param     array       $params     min, maxを含んだ属性値配列
	 * @return    bool        $valueが定義に沿っていればTRUE
	 *
	 */
	protected static function _checkDateRange($value, $params)
	{
		if (($date = dateTime_convert::strToTime($value)) === FALSE) {
			return FALSE;
		}
		if (isset($params["min"]) && strlen($params["min"])) {
			if ($date < dateTime_convert::strToTime($params["min"])) {
				return FALSE;
			}
		}
		if (isset($params["max"]) && strlen($params["max"])) {
			if ($date > dateTime_convert::strToTime($params["max"])) {
				return FALSE;
			}
		}
		return TRUE;
	}
	// }}} _checkDateRange()
}
// }}} class web_smartForm_checker
?>
