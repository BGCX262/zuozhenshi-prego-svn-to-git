<?php
/**
* エラーチェッククラス
**/
require_once( 'Class_DB.php' );
require_once( 'prego_m.php' );



session_name('PREGO_ADMIN');
//session_cache_limiter(private_no_expire);
session_start();
class Class_M_DAO  {
	//protected properties begin
	/**
	 *
	 * DBオブジェクト
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_db = NULL;
	
	/**
	 *
	 * トランザクション状態
	 *
	 * @access    protected
	 * @var       bool
	 *
	 */
	protected $_transaction = FALSE;
	
	/**
	 *
	 * テーブル名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_table = NULL;
	
	/**
	 *
	 * 主キー名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_pkey = "id";
	
	/**
	 *
	 * ソート順
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_order = "";
	
	/**
	 *
	 * 主キー用のシーケンサ名
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_sequence = NULL;
	
	/**
	 *
	 * get()時に取得するカラムリスト
	 *
	 * @access    protected
	 * @var       string
	 *
	 */
	protected $_getColumns = '*';
	
	protected $_cols  = array();
	
	protected $_checks  = array();
	
	protected $_maxlens = array();
	
	// protected properties end
	
	//
	public function __construct($db=null)
	{
		if ( $db ) {
			$this->_db =  $db;;
		}else {
			$this->_db = new Class_DB;;
		}
	}
	
	public function setTables($tablename) {
		$this->_table =  $tablename;
	}
	
	public function get_cols() {
		return $this->_cols;
	}
	
	/**
	 *
	 * チェック用配列の設定
	 *
	 * @access    public
	 * @param     なし
	 * @return    Array     該当マスタチェック用配列
	 */
	 public function get_checks() {
		return $this->_checks ;
	}
	
	 public function get_maxlens() {
		return $this->_maxlens ;
	}

		
	/**
	 *
	 * 単一レコードを取得する
	 *
	 * @access    public
	 * @param     mixed     $id             主キーの値
	 * @return    mixed     取得に失敗した場合にFALSE, 成功した場合にレコードの内容(array)
	 */
	public function get($value) {
		$sql = sprintf("SELECT * FROM  {$this->_table}  WHERE {$this->_pkey} = '%s'" , $this->esc( $value ) );
		$this->_db->query( $sql );
		if( $this->_db->num_rows() ){
			$retrow =  $this->_db->fetch();
			/*
			if (isset($retrow["u_user"]) && ($retrow["u_user"])) {
				$sql = sprintf("SELECT user_name FROM  M_LOGIN  WHERE id = '%s'" , $retrow["u_user"]);
				$this->_db->query( $sql );
				if( $this->_db->num_rows() ){
					$userrow = $this->_db->fetch();
					$retrow["m_user_name"] = $userrow['user_name'];
				}else {
					$retrow["m_user_name"] = $retrow["u_user"];
				}
			}
			*/
			return $retrow;
		}else{
			return  FALSE;
		}
	}
	
	/**
	 *
	 * 条件によってレコード存在チェック
	 *
	 * @access    public
	 * @param     mixed     $where             抽出条件
	 * @return    mixed     存在しない場合にFALSE, 存在する場合TRUE
	 */
	public function exits($where) {
		$sql = "SELECT COUNT(*) AS cnt  FROM  {$this->_table} WHERE {$where} ";
		
		$this->_db->query( $sql );
		if( $this->_db->num_rows() ){
			$row = $this->_db->fetch();
			if( $row['cnt'] ){ 
				return TRUE;
			} else {
				return FALSE;
			}
		}else{
			return  FALSE;
		}
	}
	
	/**
	 *
	 * 条件によってレコード削除する
	 *
	 * @access    public
	 * @param     mixed     $where             抽出条件
	 * @return    mixed     成功しない場合にFALSE, 成功する場合TRUE
	 */
	public function del($where) {
		$sql = "DELETE  FROM {$this->_table} WHERE {$where} ";
		try {
			if ($this->_db->query( $sql )) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return FALSE;
		}
	}
	
	
	/**
	 *
	 * 条件によってレコードを取得する
	 *
	 * @access    public
	 * @param     array     $where         WHERE条件配列(AND)
	 * @param     array     $page          ページ数、NULL時、全部データを抽出する
	 * @return    mixed     取得に失敗した場合にFALSE, 成功した場合にレコードの内容(array)
	 *
	 */
	 public function search($where ,&$page = NULL ,$myselect = NULL,$mycountsql = NULL, $orderby = NULL){	
		$where = implode(' AND ', $where);
		if ($myselect) {
			$sql = $myselect;
		}else {
			$sql = "SELECT * FROM {$this->_table} ";
		}
		
		$order = "";
		if ($orderby) {
			$order = " ORDER BY {$orderby}";
		} else {
			if ( $this->_order ){
				$order = " ORDER BY {$this->_order}";
			}			
		}
		if ($mycountsql) {
			$cnt_sql = $mycountsql; 
		}else {
			$cnt_sql = "SELECT COUNT(*) AS cnt FROM {$this->_table}";
		}
		
		if ($where) {
			$sql     = $sql . " WHERE ".$where ;
			$cnt_sql = $cnt_sql . " WHERE ".$where ;
		}
		try {
			$limit = "";
			if ($page) {
				$this->_db->query( $cnt_sql );
				$row = $this->_db->fetch();
				
				$page['cnt'] = $row['cnt'];
				$page['end'] = floor( $page['cnt'] / $page['item'] );
				if( $page['cnt'] % $page['item'] ) $page['end']++;
				
				if ( ($page['end'] - $page['current'])  >= PAGEING_MAX ) {
					for( $i = $page['current']; $i <=  $page['current']+ PAGEING_MAX; $i++ ){
						$page['paging'][] = $i;
					}
				} else {
					$begin = $page['end'] - PAGEING_MAX > 0 ? $page['end'] - PAGEING_MAX : 1;
					
					for( $i = $begin; $i <= $page['end']; $i++ ){
						$page['paging'][] = $i;
					}
				}
				$limit = " limit ".( ( $page['current'] -1 ) * $page["item"] ).",".$page["item"] ; 
			}
		
			$this->_db->query( $sql.$order.$limit );
			
			$data = array();
			while( $row = $this->_db->fetch() ){
				$data[] = $row;
			}
			return $data;
		} catch (Exception $e) {
			
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return NULL;
		}
	}
	
	public function  get_rows($sql) {
		try {
			$this->_db->query( $sql);
			
			$data = array();
			while( $row = $this->_db->fetch() ){
				$data[] = $row;
			}
			return $data;
		} catch (Exception $e) {
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return NULL;
		}
	}
	public function  get_row($sql) {
		try {
			$this->_db->query( $sql);
			
			$data = array();
			if ( $row = $this->_db->fetch() ){
				return $row;
			}
			
		} catch (Exception $e) {
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return NULL;
		}
	}
	public function exec_sql($sql) {
		try {
			if ($this->_db->query( $sql )) {
				
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return FALSE;
		}

	}
	
	/**
	 *
	 * レコードを追加する
	 *
	 * @access    public
	 * @param     array     $values         追加する内容
	 * @return    mixed     追加に失敗した場合にFALSE, 成功した場合に主キーの値
	 *
	 */
	public function add($values)
	{
		//$this->_begin();
		$cols = "";
		$vals = "";
		//テーブルの列属性
		$ctp = $this->get_cols();
		
		foreach ($values as $k=>$v) {
			$vv = $v;
			if ($ctp[$k][0] == PREGO_VARTYPE_STR) {
				$vv = $this->_db->quote($vv);
			}
			$cols = $cols.$k.", ";
			$vals  = $vals."'{$vv}', ";
			
		}
		
		$cols = $cols."u_time ,u_user,c_time,c_user";
		$loginuser = $_SESSION['PREGO_ADMIN']['STAFF_SEQ'];
		$vals = $vals."CURRENT_TIMESTAMP,'{$loginuser}' ".",CURRENT_TIMESTAMP,'{$loginuser}' ";
		
		$sql = "INSERT INTO {$this->_table}({$cols}) VALUES ({$vals})";
		
		try {
			if ($this->_db->query( $sql )) {
				$id = $this->_db->last_id();
				return $id;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return FALSE;
		}
		
		//$this->_commit();
	}
	/**
	 *
	 *auto （id）存在しない場合、 レコードを追加する
	 *
	 * @access    public
	 * @param     array     $values         追加する内容
	 * @return    mixed     追加に失敗した場合にFALSE, 成功した場合に主キーの値
	 *
	 */
	public function add0($values)
	{
		//$this->_begin();
		$cols = "";
		$vals = "";
		//テーブルの列属性
		$ctp = $this->get_cols();
		
		foreach ($values as $k=>$v) {
			$vv = $v;
			if ($ctp[$k][0] == PREGO_VARTYPE_STR) {
				$vv = $this->_db->quote($vv);
			}
			$cols = $cols.$k.", ";
			$vals  = $vals."'{$vv}', ";
		}
		
		$cols = $cols."u_time ,u_user,c_time,c_user";
		$loginuser = $_SESSION['PREGO_ADMIN']['STAFF_SEQ'];
		$vals = $vals."CURRENT_TIMESTAMP,'{$loginuser}' ".",CURRENT_TIMESTAMP,'{$loginuser}' ";
		
		$sql = "INSERT INTO {$this->_table}({$cols}) VALUES ({$vals})";
		
		try {
			if ($this->_db->query( $sql )) {
				
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return FALSE;
		}

		//$this->_commit();
		
	}
	
	/**
	 *
	 * レコードを追加する
	 *
	 * @access    public
	 * @param     array     $values         追加する内容
	 * @return    mixed     追加に失敗した場合にFALSE, 成功した場合に主キーの値
	 *
	 */
	public function addnotime($values)
	{
		//$this->_begin();
		$cols = "";
		$vals = "";
		//テーブルの列属性
		$ctp = $this->get_cols();
		
		foreach ($values as $k=>$v) {
			$vv = $v;
			if ($ctp[$k][0] == PREGO_VARTYPE_STR) {
				$vv = $this->_db->quote($vv);
			}
			
			$colsarr[]  = $k;
			$valsarr[]  = "'{$vv}'";
		}
		
		$cols = implode(',',  $colsarr);
		$vals = implode(',',  $valsarr);
		
		$sql = "INSERT INTO {$this->_table}({$cols}) VALUES ({$vals})";
		
		try {
			if ($this->_db->query( $sql )) {
				$id = $this->_db->last_id();
				return $id;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return FALSE;
		}

		//$this->_commit();
	}
	
	/**
	 *
	 * レコードを編集する
	 *
	 * @access    public
	 * @param     mixed     $id             主キーの値
	 * @param     array     $values         追加する内容
	 * @param     bool      $mstamp         最終更新日時を更新しない場合はFALSE
	 * @return    bool      編集に失敗した場合にFALSE, 成功した場合にTRUE
	 *
	 */
	public function edit($id, $values)
	{
		//$this->_begin();
		$sets = "";
		
		//テーブルの列属性
		$ctp = $this->get_cols();
		foreach ($values as $k=>$v) {
			
			if ( isset($ctp[$k]) ) {
				if ($ctp[$k][0] == PREGO_VARTYPE_STR) {
					$v = $this->_db->quote($v);
				}
			}
			$sets = $sets."{$k} ='{$v}', ";
		}
		
		$loginuser = $_SESSION['PREGO_ADMIN']['STAFF_SEQ'];
		$sets = $sets."u_time = CURRENT_TIMESTAMP ,u_user = '{$loginuser}'";
		$sql = "UPDATE {$this->_table} SET {$sets}   WHERE {$this->_pkey} = '{$this->esc( $id )}' ";
		
		try {
			if ($this->_db->query( $sql )) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return FALSE;
		}
		//$this->_commit();
		return FALSE;
	}
	
	/**
	 *
	 * レコードを編集する
	 *
	 * @access    public
	 * @param     mixed     $id             主キーの値
	 * @param     array     $values         追加する内容
	 * @param     bool      $mstamp         最終更新日時を更新しない場合はFALSE
	 * @return    bool      編集に失敗した場合にFALSE, 成功した場合にTRUE
	 *
	 */
	public function editbywhere($where, $values)
	{
		//$this->_begin();
		$sets = "";
		
		//テーブルの列属性
		$ctp = $this->get_cols();
		foreach ($values as $k=>$v) {
			$vv = $v;
			if ($ctp[$k][0] == PREGO_VARTYPE_STR) {
				$vv = $this->_db->quote($vv);
			}
			$sets = $sets."{$k} ='{$vv}', ";
		}
		$loginuser = $_SESSION['PREGO_ADMIN']['STAFF_SEQ'];
		$sets = $sets."u_time = CURRENT_TIMESTAMP ,u_user = '{$loginuser}'";
		$sql = "UPDATE {$this->_table} SET {$sets} where  {$where} ";
		try {
			if ($this->_db->query( $sql )) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return FALSE;
		}
		//$this->_commit();
		return FALSE;
	}
		/**
	 *
	 * レコードを編集する
	 *
	 * @access    public
	 * @param     mixed     $id             キーの値
	 * @param     array     $values         追加する内容
	 * @param     array     $values           キーの物理名 
	 * @param     bool      $mstamp         最終更新日時を更新しない場合はFALSE
	 * @return    bool      編集に失敗した場合にFALSE, 成功した場合にTRUE
	 *
	 */
	public function editbycol($id, $values, $keycol)
	{
		//$this->_begin();
		$sets = "";
		
		//テーブルの列属性
		$ctp = $this->get_cols();
		foreach ($values as $k=>$v) {
			$vv = $v;
			if ($ctp[$k][0] == PREGO_VARTYPE_STR) {
				$vv = $this->_db->quote($vv);
			}
			$sets = $sets."{$k} ='{$vv}', ";
		}
		$loginuser = $_SESSION['PREGO_ADMIN']['STAFF_SEQ'];
		$sets = $sets."u_time = CURRENT_TIMESTAMP ,u_user = '{$loginuser}'";
		$sql = "UPDATE {$this->_table} SET {$sets}   WHERE {$keycol} = '{$this->esc( $id )}' ";
		
		try {
			if ($this->_db->query( $sql )) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return FALSE;
		}
		//$this->_commit();
		return FALSE;
	}
	
	/**
	 *
	 * 単一レコードを削除する
	 *
	 * @access    public
	 * @param     mixed     $id             主キーの値
	 * @return    bool      削除に失敗した場合にFALSE, 成功した場合にTRUE
	 *
	 */
	public function remove($id){
		$sql = "DELETE FROM {$this->_table}  WHERE {$this->_pkey} = '{$this->esc( $id )}' ";
		
		//$this->_begin();
		try {
			if ($this->_db->query( $sql )) {
				return TRUE;
			} else {
				return FALSE;
			}
		} catch (Exception $e) {
			//$this->_rollback();
			echo "例外キャッチ：", $e->getMessage(), "\n";
			return FALSE;
		}
		//$this->_commit();
		return TRUE;
	}
	
	/**
	 *
	 * CSV出力する
	 *
	 * @access    public
	 * @param     $data    出力用データ
	 * @param     $colums  出力用$colums
	 * @return    なし
	 *
	 */
	public function  output_csv($data, $colums, $delimiter = ',' )
	{
		if ( $colums["head"] ) {
			echo   mb_convert_encoding(implode(',',  $colums["head"]), "SJIS-win", "UTF-8")."\r\n";
		} else {
			echo  implode($delimiter, $colums["name"])."\r\n";
		}
		foreach ($data as $k => $v) {
			$linearr  = array();
			foreach ($colums["name"]  as $ck => $cv) {
				if (isset($colums["type"][$cv]) && $colums["type"][$cv] == 4) {
					$linearr[]= '"'.$v[$cv].'"';
				} else {
					$linearr[]= isset($v[$cv]) ? $v[$cv] : "" ;
				}
			}
		
			echo  mb_convert_encoding(implode($delimiter, $linearr), "SJIS-win", "UTF-8")."\r\n";
		}
	}
	public function  output_csv_file($data, $colums,$file_name, $delimiter = ',' )
	{

		$csv_data ="";
		if ( $colums["head"] ) {
			$csv_data =   mb_convert_encoding(implode(',',  $colums["head"]), "SJIS-win", "UTF-8")."\r\n";
		} else {
			$csv_data =   implode($delimiter, $colums["name"])."\r\n";
		}
		
		foreach ($data as $k => $v) {
			$linearr  = array();
			foreach ($colums["name"]  as $ck => $cv) {
				if (isset($colums["type"][$cv]) && $colums["type"][$cv] == 4) {
					$linearr[]= '"'.$v[$cv].'"';
				} else {
					$linearr[]= isset($v[$cv]) ? $v[$cv] : "" ;
				}
			}
			$csv_data =$csv_data .  mb_convert_encoding(implode($delimiter, $linearr), "SJIS-win", "UTF-8")."\r\n";
		}
		
		// ファイルを追記モードで開く
		$fp = fopen($file_name, 'ab');
		
		// ファイルを排他ロックする
		flock($fp, LOCK_EX);
		
		// ファイルの中身を空にする
		ftruncate($fp, 0);
		
		// データをファイルに書き込む
		fwrite($fp, $csv_data);
		
		// ファイルを閉じる
		fclose($fp);
	}

	/**
	 *
	 * トランザクションの開始
	 *
	 * @access    protected
	 * @return    bool      成功時にTRUE
	 *
	 */
	public function begin_trans(){
		$sql = "begin";
		if (($this->_db->query( $sql ))) {
		    return TRUE;
		}
		return FALSE;
	}
	
	/**
	 *
	 * トランザクションの完了
	 *
	 * @access    protected
	 * @return    bool      成功時にTRUE
	 *
	 */
	public function commit_trans(){
		$sql = "commit";
		if (($this->_db->query( $sql ))) {
		    return TRUE;
		}
		return FALSE;
	}

	/**
	 *
	 * トランザクションの中止
	 *
	 * @access    protected
	 * @return    bool      成功時にTRUE
	 *
	 */
	public function  rollback_trans(){
		$sql = "rollback";
		if (($this->_db->query( $sql ))) {
		    return TRUE;
		}
		return FALSE;
	}
	
	public function auto_commit($auto){
		$this->_db->autocommit($auto);
	}
	
	
	public function get_db(){
		 return $this->_db ;
	}
	public function do_debug(){
		$this->_db->Debug() ;
	}
	public function notdo_debug(){
		$this->_db->Debug(false) ;
	}
	
	function esc( $str ){
		return mysql_real_escape_string( $str );
	}
	function quote( $str ){
		return str_replace("'", "''", $str);
	}
	
	public function getFromToWhere($from,$to, $field){
		$ret = "";
		if (! empty ($from) && ! empty ($to)) {
			$ret = " ({$field} >= '$from' and {$field} <= '$to') ";
		} elseif(! empty ($from) ){
			$ret = " {$field} >= '$from' ";
		} elseif(! empty ($to) ){
			$ret = " {$field} <= '$to' ";
		}
		return $ret;
	}
	
}

?>