<?php
/**
* PASSWORDと権限管理ククラス
* 共通関数などもあります
**/

class Class_PWD{
	public static $_arr_weeks = array( "日", "月", "火", "水", "木", "金", "土"); 
	public static function do_encode($value ){	
// 		return md5($value);
		return $value;
	}
	
	public static function do_decode($value ){	
// 		return md5($value);
		return $value;
	}
	//
	public static function valid_auth($val, $auth = NULL ){	
			$aoki_auth = $_SESSION['ADMIN_LOGIN']['STAFF_AUTH_ARR'];
			if ( !isset( $aoki_auth[$val]) ) {
				echo ("メニューにアクセス不可です。");
				exit;
			}
			$url = $_SERVER['PHP_SELF'];
			$arr = explode( '/' , $url );
			$filename= $arr[count($arr)-1];
			$filename = str_replace(".php","",$filename);
	}
	//前年$matrix_cd
	public static function get_pre_matrix_cd( $matrix_cd ){
		return (substr($matrix_cd,0,4)* 1 -1).substr($matrix_cd,4);
	}
	
	//yyyymmddからyyyy/mm/dd変換
	public static function int8_to_date($val ){
		if (empty($val)) {
			return "";
		}
		return date("Y/m/d", strtotime($val));
	}
	//y/n/j
	public static function int8_to_date_nozero($val ){
		if (empty($val)) {
			return "";
		}
		return date("Y/n/j", strtotime($val));
	}
	

	
	//yyyymmddからyyyy/mm/dd(D)変換
	public static function int8_to_dateD($val ){
		if (empty($val)) {
			return "";
		}
		$shortime =  strtotime($val);
		return date("Y/m/d",$shortime)."(".Class_PWD::$_arr_weeks[date( "w",$shortime)].")";
		
	}
		//yyyymmddからyyyy/mm/dd(D)変換
	public static function int8_to_cell_dateD($val ){
		if (empty($val)) {
			return "";
		}
		$shortime =  strtotime($val);
		return date("m/d",$shortime)."(".Class_PWD::$_arr_weeks[date( "w",$shortime)].")";
	}
	//yyyymmddか変換
	public static function dateTime_to_dateD($val ,&$time = null){
		if (empty($val)) {
			return "";
		}
		$shortime =  strtotime($val);
		if (!empty($time)) {
			$time  = date("H",$shortime);
		} 
		
		return date("Y/m/d",$shortime)."(".Class_PWD::$_arr_weeks[date( "w",$shortime)].")";
	}
		//yyyy-mm-dd 00:00:00か変換Y-m-d H:i:s
	public static function dateTime_to_YmdHi($val ){
		if (empty($val)) {
			return "";
		}
		$shortime =  strtotime($val);
		
		return date("Y/m/d H:i",$shortime);
	}
	//yyyy/mm/ddからyyyymmdd変換
	public static function date_to_int8($str ){
		if (empty($str)) {
			return 0;
		}
		return date('Ymd', strtotime($str));
	}
	
	//yyyy/mm/dd(d)からyyyymmdd変換
	public static function dateD_to_int8($str ){
		if (empty($str)) {
			return 0;
		}
		
		return date('Ymd', strtotime($str));
	}
	
	public static function dateHH_to_time($str, $hour ){
		if ( empty($str) ) {
			return NULL;
		}
		if  ( empty($hour) ){
			return substr($str,0,10)." 00:00:00";
		} else {
			return substr($str,0,10)." ".$hour.":00:00";
		}
		
	}
	
	
	//年プルダウン配列
	public static function get_years( ){
		$year4 = array();
		for( $a = AOKI_YEAR_BEGIN; $a <= date('Y') + 1; $a++ )
		{
			$year4[$a] = $a;
		}
		return $year4;
	}
	//$intime 日付yyyy/mm/dd
	//$flag  1: >=,  2:<=
	public static function get_u_time_where_sql($intime, $flag = 1,$table =null ){
		
		$the_time = str_replace( '/', '-', $intime);
		if ($flag==1) {
			$the_time = $the_time. " 00:00:00";
			if ($table) {
				return  $table.".u_time >=  '{$the_time}'";
			} else {
				return  " u_time >=  '{$the_time}'";
			}
		}
		 
		if ($flag==2) {
			$the_time = $the_time. " 23:59:59";
			if ($table) {
				return  $table.".u_time <=  '{$the_time}'";
			}else {
				return  " u_time <=  '{$the_time}'";
			}
		}
		
	}
	
	public static function dateTime_to_YmdHis($val ){
		if (empty($val)) {
			return "";
		}
		$shortime =  strtotime($val);
		return date("Y/m/d H:i:s",$shortime);
	}
	
	public static function getMatrixStatues($row ) {
		$nowdate = $row["sysd"];
		if ($nowdate <= $row["draft_create_dt"]){
			return   AOKI_MATRIXS_DRAFT_CREATE ;
		} else if ($nowdate <= $row["draft_input_end_dt"]) {
			return  AOKI_MATRIXS_DRAFT_INPUT ;
		} else if ($nowdate <= $row["draft_modi_end_dt"]) {
			return   AOKI_MATRIXS_DRAFT_MODIFY ;
		} else if ($nowdate <= $row["draft_publish_end_dt"]) {
			return   AOKI_MATRIXS_DRAFT_PUBLISH ;
		} else if ($nowdate <= $row["final_input_end_dt"]) {
			return   AOKI_MATRIXS_FINAL_INPUT ;
		} else if ($nowdate <= $row["final_modi_end_dt"]) {
			return  AOKI_MATRIXS_FINAL_MODIFT ;
		} else {
			return  AOKI_MATRIXS_FINAL_END ;
		}
	}
	
	public static function  set_rate_inc(&$values){
		
		//計画比   計画差異
		$values["plane_inc"] =  $values["now_cost"] - $values["plane_cost"];
		if ( !empty($values["plane_cost"]) ) {
			$values["plane_rate"] =  $values["now_cost"] / $values["plane_cost"] * 100;
		} else {
			
		}
		
		//前年比   前年差異
		$values["last_inc"] =  $values["now_cost"] - $values["last_cost"];
		if ( !empty($values["last_cost"]) ) {
			$values["last_rate"] =  $values["now_cost"] / $values["last_cost"] * 100;
		}else {
			
		}
		
	}
}

?>