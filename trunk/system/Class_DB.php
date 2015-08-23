<?php
/**
* MYSQL データベースクラス
**/
define('DB_SERVER','localhost');


//define('DB_PASS','aa');
define('DB_NAME','prego_db');


//define('DB_USER','pre82497');
//define('DB_PASS','h7ymvM3t');

define('DB_USER','root');
define('DB_PASS','aa');

class Class_DB{
	var $conn;
	var $rows;
	var $rows_count;
	var $DEBUG = false;
	
	// コンストラクタ
	function Class_DB(){
		$this->conn = mysql_connect( DB_SERVER, DB_USER, DB_PASS );
		if ( !$this->conn ) {
			die( "DB Connection Error：" . mysql_error() );
		}
		
		if( !mysql_select_db( DB_NAME, $this->conn ) ){
			die("DB selecterror");
		}
	}
	
	// クエリ
	function query( $sql ){
		if( $this->DEBUG ) { echo "$sql<br />"; }
		mysql_query( 'SET NAMES utf8', $this->conn );
		try {  
			$this->rows = mysql_query($sql , $this->conn);
			if( ! $this->rows ){
				//die("query error " . mysql_error() . "<hr/>" . $sql );
				return false;
			}
		}catch (Exception $e){ 
			return false;
		}
		return $this->rows;
	}

	//last_insert_id
	function last_id(){
		return mysql_insert_id( $this->conn );
	}

	// 行数
	function num_rows(){
		return mysql_num_rows( $this->rows );
	}
	
	// 検索結果の開放
	function free(){
		mysql_free_result( $this->rows );
	}

	// 検索結果をfetch
	function fetch(){
		return mysql_fetch_array( $this->rows, MYSQL_ASSOC );
	}
	
	// 切断
	function close(){
		mysql_close( $this->conn );
	}
	
	// シングルクォートエスケープ
	function quote( $str ){
		return str_replace("'", "''", $str);
	}
	
	function real_escape( $str ){
		return mysql_real_escape_string( $str );
	}
	
	function Debug($indebug = true){
		$this->DEBUG = $indebug;
	}

}

?>