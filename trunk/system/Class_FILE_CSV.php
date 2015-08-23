<?php
/**
 *
 * file_csvクラス - CSVファイルの入出力を簡略化するクラス
 * 
 *
 **/
class Class_FILE_CSV 
{
	// {{{ public properties
	/**
	 *
	 * CSVファイルの文字セット ※NULLで入出力時の自動変換を行わないようになります
	 *
	 * @access    public
	 * @var       string
	 *
	 **/
	public $charset = "UTF-8";
	
	/**
	 *
	 * デリミタ
	 *
	 * @access    public
	 * @var       string
	 *
	 **/
	public $delimiter  = ',';
	
	/**
	 *
	 * 書き込み時の改行コード
	 *
	 * @access    public
	 * @var       string
	 *
	 **/
	public $nlChar = "\n";
	// }}} public properties
	
	// {{{ private properties
	/**
	 *
	 * オープン中のファイルハンドル
	 *
	 * @access    private
	 * @var       resource
	 *
	 **/
	private $_fileHandle = NULL;
	
	/**
	 *
	 * 最も長い行のバイト長
	 *
	 * @access    private
	 * @var       int
	 *
	 **/
	private $_maxLength  = 0;
	// }}} private properties
	
	// {{{ __construct()
	/**
	 *
	 * コンストラクタ
	 *
	 * @access    public
	 * @param     string    $csv          オープンするCSVファイル
	 * @param     string    $delimiter    デリミタ(区切文字)
	 *
	 */
	public function __construct( $csv )
	{
		// 例外処理
		$check = array(array($csv, AOKI_VARTYPE_STR));
		$this->chkArgs(__CLASS__, __METHOD__, $check);
		if (is_file($csv) && (!is_readable($csv) || !is_writable($csv))) {
			throw exception(
				__CLASS__, __METHOD__, AOKI_PERMISSION_DENIED, "Cannot open {$csv}"
			);
		}
		// open csv file
		$this->_fileHandle = fopen($csv, "a+");
		$file = file($csv);
		$this->_maxLength  = empty($file) ? 0 : floor(max(array_map("strlen", $file)) * 3 / 2);
		$this->reset();
	}
	// }}} __construct()
	
	
	// {{{ __destruct()
	/**
	 *
	 * デストラクタ
	 *
	 * @access    public
	 *
	 */
	function __destruct()
	{
		$this->close();
	}
	// }}} __destruct()
	
	// {{{ close()
	/**
	 *
	 * ファイルを閉じる
	 *
	 * @access    public
	 * @return    bool      成功した場合にTRUE 、失敗した場合にFALSE
	 *
	 */
	public function close()
	{
		if (empty($this->_fileHandle) || !is_resource($this->_fileHandle)) {
			return TRUE;
		}
		return fclose($this->_fileHandle);
	}
	// }}} close()
	
	// {{{ offset()
	/**
	 *
	 * ファイルポインタの位置を取得する
	 *
	 * @access    public
	 * @return    mixed     成功した場合に読み込みポインタ位置 、失敗した場合にFALSE
	 *
	 */
	public function offset()
	{
		if (empty($this->_fileHandle) || !is_resource($this->_fileHandle)) {
			// ファイル未OPEN
			throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "File not opend");
		}
		return ftell($this->_fileHandle);
	}
	// }}} offset()
	
	// {{{ size()
	/**
	 *
	 * ファイルサイズを取得する
	 *
	 * @access    public
	 * @return    int       常にファイルサイズ(0～)を返す
	 *
	 */
	public function size()
	{
		if (empty($this->_fileHandle) || !is_resource($this->_fileHandle)) {
			// ファイル未OPEN
			throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "File not opend");
		}
		$tmp = fstat($this->_fileHandle);
		return (int)$tmp["size"];
	}
	// }}} size()
	
	// {{{ reset()
	/**
	 *
	 * 読込位置を先頭に戻す
	 *
	 * @access    public
	 * @return    bool      成功した場合にTRUE 、失敗した場合にFALSE
	 *
	 */
	public function reset()
	{
		if (empty($this->_fileHandle) || !is_resource($this->_fileHandle)) {
			// ファイル未OPEN
			throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "File not opend");
		}
		return rewind($this->_fileHandle);
	}
	// }}} reset()
	
	// {{{ truncate()
	/**
	 *
	 * ファイルをリセットする
	 *
	 * @access    public
	 * @return    bool      成功した場合にTRUE 、失敗した場合にFALSE
	 *
	 */
	public function truncate()
	{
		if (empty($this->_fileHandle) || !is_resource($this->_fileHandle)) {
			// ファイル未OPEN
			throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "File not opend");
		}
		return ftruncate($this->_fileHandle, 0) && rewind($this->_fileHandle);
	}
	// }}} truncate()
	
	// {{{ fetchRow()
	/**
	 *
	 * CSVから1行分のデータを取得する
	 *
	 * @access    public
	 * @return    array     取得された行のデータ
	 *
	 */
	public function fetchRow()
	{
		if (empty($this->_fileHandle) || !is_resource($this->_fileHandle)) {
			// ファイル未OPEN
			throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "File not opend");
		}
		// データ取得
		$row = fgetcsv($this->_fileHandle, $this->_maxLength, $this->delimiter);
		mb_convert_variables('UTF-8', 'sjis-win', $row);
		
		// 文字コード変換
/*
		if (!empty($this->charset)) {
			$row = string_multibyte::convertEncoding($row, 'UTF-8', $this->charset);
			 mb_convert_encoding(implode(',', $linearr), "SJIS-win", "UTF-8")
		}
		*/
		return  $row;
	}
	// }}} fetchRow()
   public function toUtf8($row) {
   		$retrow = array();
   		foreach ($row as $rk => $rv){
   			$retrow[$rk] =  mb_convert_encoding($rv, "UTF-8",  "SJIS-win");
   		}
   		
   }
	
	
	// {{{ fetchAll()
	/**
	 *
	 * CSVから全行のデータを取得する
	 *
	 * @access    public
	 * @return    array     取得された行のデータ
	 *
	 */
	public function &fetchAll()
	{
		if (empty($this->_fileHandle) || !is_resource($this->_fileHandle)) {
			// ファイル未OPEN
			throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "File not opend");
		}
		$this->reset();
		
		// データ取得
		$rows = array();
		while ($tmp = fgetcsv($this->_fileHandle, $this->_maxLength, $this->delimiter)) {
			$rows[] = $tmp;
		}
		/*
		// 文字コード変換
		if (!empty($this->charset)) {
			$rows = string_multibyte::convertEncoding($rows, 'UTF-8', $this->charset);
		}
		*/
		return $rows;
	}
	// }}} fetchAll()
	
	// {{{ addRow()
	/**
	 *
	 * CSVに1行書き加える
	 *
	 * @access    public
	 * @param     array     $record     書き加える行データ(配列)
	 * @param     string    $nlChar     改行文字
	 * @param     bool      $speedUp    高速化のためにエラーチェックをスキップする場合にTRUE
	 * @return    bool                  成功した場合にTRUE 、失敗した場合にFALSE
	 *
	 */
	public function addRow($record, $nlChar = NULL, $speedUp = FALSE)
	{
		if (!$speedUp) {
			// 例外処理
			$check = array(array($record, AOKI_VARTYPE_ARRAY));
			$this->chkArgs(__CLASS__, __METHOD__, $check);
			if (empty($this->_fileHandle) || !is_resource($this->_fileHandle)) {
				// ファイル未OPEN
				throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "File not opend");
			} elseif (fseek($this->_fileHandle, 0, SEEK_END)) {
				// ファイルポインタ移動失敗
				throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "Failed to move pointer");
			}
		} else {
			fseek($this->_fileHandle, 0, SEEK_END);
		}
		// 改行コードの決定
		$nlChar = is_null($nlChar) ? $this->nlChar : $nlChar;
		// レコードの作成
		foreach ($record as $k => $v) {
			if (preg_match('/[",\r\n]/', $v)) {
				// レコード内改行コードをLFで統一
				$v = preg_replace("/\r\n|\r/", "\n", $v);
				
				// " でくくる
				$v = sprintf('"%s"', str_replace('"', '""', $v));
				
				// 書き換え
				$record[$k] = $v;
			}
		}
		$line = implode($this->delimiter, $record) . $nlChar;
		if ($this->charset) {
			$line = string_multibyte::convertEncoding($line, $this->charset);
		}
		if (($len = strlen($line)) > $this->_maxLength) {
			$this->_maxLength = $len;
		}
		return (bool)(fwrite($this->_fileHandle, $line));
	}
	// }}} addRow()
	
	// {{{ addRows()
	/**
	 *
	 * CSVに複数行書き加える
	 *
	 * @access    public
	 * @param     array     $records    書き加える行データ(配列)の配列
	 * @param     string    $nlChar     改行文字
	 * @return    int                   書き込みに成功した行数
	 *
	 */
	public function addRows($records, $nlChar = NULL)
	{
		// 例外処理
		$check = array(array($records, AOKI_VARTYPE_ARRAY));
		$this->chkArgs(__CLASS__, __METHOD__, $check);
		foreach ($records as $row) {
			if (!is_array($row)) {
				throw exception(__CLASS__, __METHOD__, AOKI_BAD_ARGUMENT, array(1, 'non-array', 'array'));
			}
		}
		if (empty($this->_fileHandle) || !is_resource($this->_fileHandle)) {
			// ファイル未OPEN
			throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "File not opend");
		} elseif (fseek($this->_fileHandle, 0, SEEK_END)) {
			// ファイルポインタ移動失敗
			throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "Failed to move pointer");
		}
		
		$ok = 0;
		foreach ($records as $r) {
			if ($this->addRow($r, $nlChar, TRUE)) {
				++$ok;
			}
		}
		return $ok;
	}
	// }}} addRows()
	
	/**
	 *
	 * 引数チェックの実施 (_chkArgs()へのインターフェース)
	 *
	 * @access    public
	 * @param     string    $class       このメソッドを呼び出したクラス名
	 * @param     string    $method      このメソッドを呼び出したメソッド名
	 * @param     array     $args        チェック対象の引数配列
	 * @return    null
	 *
	 */
	final public static function chkArgs($class, $method, $args)
	{
		$chk = array(
			array($class,  AOKI_VARTYPE_STRING), array($method, AOKI_VARTYPE_STRING), array($args,  AOKI_VARTYPE_ARRAY)
			);
		if (!is_null($check = self::_chkArgs(__CLASS__, __METHOD__, $chk))) {
			throw call_user_func_array(array('aoki', 'exception'), $check);
		} elseif (!is_null($check = self::_chkArgs($class, $method, $args))) {
			throw call_user_func_array(array('aoki', 'exception'), $check);
		}
		return NULL;
	}
	
	// {{{ _chkArgs()
	/**
	 *
	 * 引数チェックの実施
	 *
	 * @access    private
	 * @param     string    $class       このメソッドを呼び出したクラス名
	 * @param     string    $method      このメソッドを呼び出したメソッド名
	 * @param     array     $args        チェック対象の引数配列
	 * @return    null
	 *
	 */
	final private static function _chkArgs($class, $method, $args)
	{
		$types = array(
			AOKI_VARTYPE_INT    => "integer",
			AOKI_VARTYPE_FLOAT  => "float",
			AOKI_VARTYPE_BOOL   => "boolean",
			AOKI_VARTYPE_STRING => "string",
			AOKI_VARTYPE_ARRAY  => "array",
			AOKI_VARTYPE_OBJECT => "object",
			AOKI_VARTYPE_NULL   => "null",
			AOKI_VARTYPE_SCALAR => "scalar",
		);
		foreach ($args as $i => $arg) {
			list($value, $type) = @(array)$arg;
			if (is_null($type) || !is_numeric($type)) {
				continue;
			}
			switch ($type) {
				case AOKI_VARTYPE_SCALAR:
					if (is_scalar($value) || is_null($value)) continue 2;
					break;
					
				case AOKI_VARTYPE_INT:
					if (is_numeric($value) && ($value == (int)$value)) continue 2;
					break;
					
				case AOKI_VARTYPE_FLOAT:
					if (is_numeric($value)) continue 2;
					break;
					
				case AOKI_VARTYPE_ARRAY:
					if (is_array($value)) continue 2;
					break;
					
				case AOKI_VARTYPE_OBJECT:
					if (is_object($value)) continue 2;
					break;
					
				case AOKI_VARTYPE_NULL:
					if (is_null($value)) continue 2;
					break;
					
				case AOKI_VARTYPE_BOOL:
				case AOKI_VARTYPE_STRING:
					if (!is_array($value) && !is_object($value)) continue 2;
					break;
			}
			$option = array($i + 1, $types[$type], gettype($value));
			return array($class, $method, AOKI_BAD_ARGUMENT, $option);
		}
		return NULL;
	}
	// }}} _schkArgs()
	
		// {{{ read()
	/**
	 *
	 * ファイルを読み込む
	 *
	 * @access    public
	 * @param     string    $file      読み込み対象ファイルのパス
	 * @param     int       $offset    読み込み開始位置
	 * @param     int       $length    読み込みサイズ
	 * @return    string               読み込んだファイルの内容, 読み込みに失敗した場合はFALSE
	 *
	 */
	public static function &read($file, $offset = 0, $length = 0)
	{
		// 例外処理
		$check = array(
			array($file,   AOKI_VARTYPE_STR),
			array($offset, AOKI_VARTYPE_INT),
			array($length, AOKI_VARTYPE_INT),
		);
		$this->chkArgs(__CLASS__, __METHOD__, $check);
		if (!is_file($file)) {
			throw exception(__CLASS__, __METHOD__, AOKI_FILE_NOT_FOUND, "cannot open {$file}");
		} elseif (!is_readable($file)) {
			throw exception(__CLASS__, __METHOD__, AOKI_PERMISSION_DENIED, "cannot open {$file}");
		}
		
		// 読み込み処理
		if (!empty($length)) {
			$result = file_get_contents($file, FALSE, NULL, $offset, $length);
		} else {
			$result = file_get_contents($file, FALSE, NULL, $offset);
		}
		
		// 完了
		return $result;
	}
	// }}} read()
	
	// {{{ write()
	/**
	 *
	 * ファイルへの出力
	 *
	 * @access    public
	 * @param     string    $file      書き込み対象ファイルのパス
	 * @param     string    $data      書き込む内容
	 * @param     bool      $add       追記モードで書き込む場合はTRUE
	 * @param     bool      $binary    改行コードの自動変換を許可する場合はFALSE
	 * @return    int                  書き込んだByte数、失敗した場合はFALSE
	 *
	 */
	public static function write($file, $data, $add = FALSE, $binary = TRUE)
	{
		// 例外処理
		$check = array(
			array($file, AOKI_VARTYPE_STR),
			array($data, AOKI_VARTYPE_SCALAR),
		);
		$this->chkArgs(__CLASS__, __METHOD__, $check);
		if (!is_file($file)) {
			throw exception(__CLASS__, __METHOD__, AOKI_FILE_NOT_FOUND, "cannot open {$file}");
		} elseif (!is_writable($file)) {
			throw exception(__CLASS__, __METHOD__, AOKI_PERMISSION_DENIED, "cannot open {$file}");
		}
		
		// 書き込み処理
		$res = FALSE;
		if (version_compare(PHP_VERSION, '6.0.0', '<')) {
			if ($fp = @fopen($file, ($add ? "a" : "w") . ($binary ? "b" : ""))) {
				$res = fwrite($fp, $data);
				fclose($fp);
			}
		} else {
			$flag = ($add ? FILE_APPEND : 0) | ($binary ? FILE_BINARY : FILE_TEXT);
			$res  = file_put_contents($file, $data, $flag);
		}
		if ($res === FALSE) {
			throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "cannot write to {$file}");
		}
		
		// 完了
		return $res;
	}
	// }}} write()
	
	//チェックfile
	public  static function get_upload_file() {
		echo '<script language="javascript"> parent.document.getElementById("information").innerHTML="チェック中......"</script>';
		ob_flush();
		flush();
		$docsv_import = FALSE;
		if (isset($_POST["isfilesubmit"]) && $_POST["isfilesubmit"] == "1" ) {
			// アップロードチェック
			try {
				$records = 0;
				$upload  = $_FILES["upfile"];
				if ( $upload['error'] == UPLOAD_ERR_OK ) {
					$csvf = $upload['tmp_name'];
					if (!is_file($csvf) || !is_readable($csvf)) {
						//throw new exception(NULL, AFRO_SEARCH_ERROR_CANT_READ);
						$err_mes["file"] = "正しいファイルではありません。";
					} elseif (!$records = count(file($csvf))) {
						//throw new exception(NULL, AFRO_SEARCH_ERROR_FILE_IS_EMPTY);
						$err_mes["file"] = "ファイルの内容は存在しません。";
					}else {
						$docsv_import = TRUE;
					}
				} else {
					$err_mes["file"] = "ファイルが選択されていません";
				}
			} catch (Exception $e) {
				$err_mes["file"] ="Exception　".$e->getCode();		
			}
		}
		
		if (!$docsv_import) {
			Class_FILE_CSV::write_msg_error( $err_mes["file"] );
			return FALSE;
		}
		return $csvf;
	}
 /**
     * ファイルポインタから行を取得し、CSVフィールドを処理する
     * @param resource handle
     * @param int length
     * @param string delimiter
     * @param string enclosure
     * @return ファイルの終端に達した場合を含み、エラー時にFALSEを返します。
     */
   public function fgetcsv_reg (&$handle, $length = null, $d = ',', $e = '"') {
   	
   	/*
   	 *  $row = 1;
    $handle = fopen("test.csv", "r");
    while (($data = fgetcsv_reg($handle)) !== false) {
        $_enc_to=mb_internal_encoding();
        $_enc_from=mb_detect_order();
        mb_convert_variables($_enc_to,$_enc_from,$data);
        $num = count($data);
        echo "<p> $num fields in line $row: </p><br />\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo nl2br($data[$c]) . "<br />\n";
        }
    }
    fclose($handle);
?>

   	 */
   	
        $d = preg_quote($d);
        $e = preg_quote($e);
        $_line = "";
        $eof = false;
        while (($eof != true)and(!feof($handle))) {
            $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
            $itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);
            if ($itemcnt % 2 == 0) $eof = true;
        }
        $_csv_line = preg_replace('/(?:\\r\\n|[\\r\\n])?$/', $d, trim($_line));
        $_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data = $_csv_matches[1];
        for($_csv_i=0;$_csv_i<count($_csv_data);$_csv_i++){
            $_csv_data[$_csv_i]=preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
            $_csv_data[$_csv_i]=str_replace($e.$e, $e, $_csv_data[$_csv_i]);
        }
        return empty($_line) ? false : $_csv_data;
    }

	//チェック中......
	public  static function fget_rows( $csvf, $withHead = true, &$rethead=false  ) {
		try {
			$tmp = file_get_contents($csvf, FALSE, NULL, 0);
			$tmp = mb_convert_encoding($tmp, 'UTF-8','sjis-win') ;
			
			$res = FALSE;
			//$csv = tempnam("/tmp", 'aoki');
			$fp = tmpfile();
			fwrite($fp, $tmp);
			rewind($fp);
			if ($withHead) {
				$line = fgetcsv($fp);
				if ($rethead) {
					$rethead = $line;
				}
			}
			
			$allrows = array();
			$index  = 1 ;
			while($line = fgetcsv($fp)) {
				$allrows[$index] = $line;
				$index ++;
			}
			fclose($fp);
		} catch (Exception $e) {
			//print_r(exception);	
			Class_FILE_CSV::write_msg_error( " Class_FILE_CSV fwrite_tmp_utf8 Exception " );
			 return  FALSE ;	
		}
		
		return count($allrows) ? $allrows: FALSE;
	}
	
	//チェック中......
	public  static function fwrite_tmp_utf8( $csvf ) {
		try {
			
			$tmp = file_get_contents($csvf, FALSE, NULL, 0);
			$tmp = mb_convert_encoding($tmp, 'UTF-8','sjis-win');
		
			$res = FALSE;
			$csv = tempnam("/tmp", 'aoki');
			
			if (version_compare(PHP_VERSION, '6.0.0', '<')) {
				
				if ($fp = @fopen($csv,  "w" .  "b" )) {
					$res = fwrite($fp, $tmp);
					rewind($fp);
					while($line = fgetcsv($fp)) {
						echo  $line."<br>";
					}

					fclose($fp);
				}
			} else {
				$flag = 0 | FILE_BINARY;
				$res  = file_put_contents($csv  , $tmp ,$flag);
			}
			
			
			if ($res === FALSE) {
				throw exception(__CLASS__, __METHOD__, AOKI_OTHER, "cannot write to {$csvf }");
			}
			
			
			
			chmod($csv, 0666);
			
		} catch (Exception $e) {
			//print_r(exception);	
			Class_FILE_CSV::write_msg_error( " Class_FILE_CSV fwrite_tmp_utf8 Exception " );
			$csv = FALSE ;	
		}
		
		return $csvf;
	}
	
	//チェック中......
	public  static function write_msg_checking() {
		echo "write_msg_checking...";
		echo '<script language="javascript"> parent.document.getElementById("information").innerHTML="チェック中. . . ";  </script>';
		echo str_repeat('*' ,FLUSH_CATCH_BYTES * 1);
		ob_flush();
		flush();

	}
	
	public  static function write_msg_checking_per($percent) {
		echo "write_msg_doing...";
		echo '<script language="javascript">
		parent.document.getElementById("progress").innerHTML="<div style=\"position:absolute;left:0px;width:'.$percent.';background-color:#00ee00;\">&nbsp;</div>";
		parent.document.getElementById("information").innerHTML="チェック中. . . '.$percent.'";  </script>';
		echo str_repeat('*' ,FLUSH_CATCH_BYTES * 1);
		ob_flush();
		flush();

	}
	//エラーがありました
	public  static function write_msg_error($error_txt, $error_stop = NULL) {
		echo "write_msg_error...";
		if ($error_stop) {
			echo '<script language="javascript"> parent.document.getElementById("information").innerHTML="エラー数は'.$error_stop.'超えるので、処理中止!!"</script>';
		} else {
			echo '<script language="javascript"> parent.document.getElementById("information").innerHTML="エラーがありました"</script>';
		}
		echo '<script language="javascript"> parent.document.getElementById("importmsg").innerHTML="'.$error_txt.'"</script>';
	}
	
	//何パセント完了
	public  static function write_msg_doing($percent) {
		echo "write_msg_doing...";
		echo '<script language="javascript">
		parent.document.getElementById("progress").innerHTML="<div style=\"position:absolute;left:0px;width:'.$percent.';background-color:#00ee00;\">&nbsp;</div>";
		parent.document.getElementById("information").innerHTML="ＤＢ更新中. . . '.$percent.'";  </script>';
		echo str_repeat('*' ,FLUSH_CATCH_BYTES * 1);
		ob_flush();
		flush();
		//sleep(1);
	}
	
	//処理成功完了
	public  static function write_msg_succed($line_nums,$url,$csvflg = 0) {
		echo "write_msg_succed...";
		echo '<script language="javascript"> parent.document.getElementById("information").innerHTML="100%処理完了しました、画面自動遷移中...";</script>';
		if (!$csvflg) {
			echo '<script language="javascript"> parent.document.getElementById("importmsg").innerHTML="'.$line_nums.'行データをインポートされました;"</script>';
		} else {
			echo '<script language="javascript"> parent.document.getElementById("importmsg").innerHTML="'.$line_nums.'行データをインポートされました; *通知メールを送信失敗しました*"</script>';
		} 
		echo str_repeat('*', FLUSH_CATCH_BYTES * 2);
		ob_flush();
		flush();
	   	sleep(1);
	   	if (!empty($url) ) {
		//	echo '<script language="javascript">parent.location.href = "'.$url.'_import.php?pro=sucess"</script>';
	   	}
	   	
	}
	public  static function format_msg( $ngMsg_tmp ) {
		$errHtml = "";
		$errindex = 0;
		
		foreach ($ngMsg_tmp as $k=>$v ) {
			foreach ($v as $vv ) {
				$errindex ++;
				$errHtml = $errHtml."【No{$errindex}】".str_replace('<br>','',$vv)."<br>";
			}
			$errHtml = $errHtml;
		}
		return $errHtml;
	}
	
}

// }}} class file_csv
?>
